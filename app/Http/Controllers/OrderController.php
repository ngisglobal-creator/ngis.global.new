<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Notifications\NewOrderNotification;
use App\Notifications\OrderStatusUpdatedNotification;
use Illuminate\Support\Facades\Notification;

class OrderController extends Controller
{
    /**
     * Client view their own orders
     */
    public function index()
    {
        $orders = Order::where('user_id', Auth::id())
            ->with(['product', 'product.user', 'product.images'])
            ->latest()
            ->get();

        return view('client.orders.index', compact('orders'));
    }

    /**
     * Client place an order (AJAX)
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer',
            'shipping_unit_type' => 'required|string',
            'notes' => 'nullable|string'
        ]);

        $product = Product::findOrFail($request->product_id);

        if ($request->quantity < $product->min_order_quantity) {
            return response()->json([
                'success' => false,
                'message' => 'الكمية يجب أن تكون أكبر من أو تساوي الحد الأدنى للطلب (' . $product->min_order_quantity . ')'
            ], 422);
        }

        // Calculate logistics fields
        $qty = (int) $request->quantity;
        $piecesPerCarton = max((int) $product->product_piece_count, 1);
        $cartons = (int) ceil($qty / $piecesPerCarton);
        $totalWeight = round($qty * (float) $product->piece_weight, 2);
        $cbmPerCarton = (float) $product->carton_volume_cbm;
        $totalCbm = round($cartons * $cbmPerCarton, 3);
        $totalCost = round($qty * (float) $product->price, 2);

        $order = Order::create([
            'user_id' => Auth::id(),
            'product_id' => $request->product_id,
            'quantity' => $qty,
            'shipping_unit_type' => $request->shipping_unit_type,
            'notes' => $request->notes,
            'status' => 'pending',
            'cartons_count' => $cartons,
            'total_weight' => $totalWeight,
            'total_cbm' => $totalCbm,
            'total_cost' => $totalCost,
        ]);

        // Notify Admins and Seller
        $admins = User::where('type', 'admin')->get();
        $seller = User::find($order->product->user_id);
        $client = Auth::user();

        Notification::send($admins, new NewOrderNotification($order, $client));
        Notification::send($seller, new NewOrderNotification($order, $client));

        return response()->json([
            'success' => true,
            'message' => 'تم إرسال الطلب بنجاح! سيتم معالجة الطلب خلال 72 ساعة'
        ]);
    }

    /**
     * Seller (Company/Factory) view received orders
     */
    public function receivedOrders()
    {
        $user = Auth::user();
        
        // Orders for products owned by this user
        $orders = Order::whereHas('product', function($query) use ($user) {
            $query->where('user_id', $user->id);
        })->with(['product', 'user', 'product.images'])->latest()->get();

        return view('orders.received', compact('orders'));
    }

    /**
     * Show received order details
     */
    public function showReceivedOrder(Order $order)
    {
        // Ensure the seller owns the product
        if ($order->product->user_id !== Auth::id()) {
            abort(403);
        }

        if ($order->status === 'pending') {
            $order->update(['status' => 'pending_approval']);
        }

        $order->load(['user', 'product', 'product.user', 'product.images', 'product.sector', 'product.branch', 'product.category']);
        
        return view('orders.received_details', compact('order'));
    }

    /**
     * Update order status (Accept/Reject)
     */
    public function updateStatus(Request $request, Order $order)
    {
        // Ensure the seller owns the product
        if ($order->product->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'status' => 'required|in:accepted,rejected',
            'rejection_reason' => 'nullable|string|max:1000|required_if:status,rejected',
        ]);

        $updateData = ['status' => $request->status];
        if ($request->status === 'rejected') {
            $updateData['rejection_reason'] = $request->rejection_reason;
        }

        $order->update($updateData);

        // Notify Client and Admin
        $client = User::find($order->user_id);
        $admins = User::where('type', 'admin')->get();
        $seller = Auth::user();

        Notification::send($client, new OrderStatusUpdatedNotification($order, $seller));
        Notification::send($admins, new OrderStatusUpdatedNotification($order, $seller));

        return back()->with('success', 'تم تحديث حالة الطلب بنجاح');
    }

    public function bulkStore(Request $request)
    {
        $request->validate([
            'items' => 'required|array',
            'items.*.id' => 'required|exists:products,id',
            'items.*.qty' => 'required|numeric|min:1',
        ]);

        $orders = [];
        foreach ($request->items as $item) {
            $order = Order::create([
                'user_id' => auth()->id(),
                'product_id' => $item['id'],
                'quantity' => $item['qty'],
                'shipping_unit_type' => $item['shipping_unit_type'] ?? 'CBM',
                'notes' => $item['notes'] ?? null,
                'status' => 'pending_approval',
                'cartons_count' => $item['cartons'] ?? 0,
                'total_weight' => $item['total_weight'] ?? 0,
                'total_cbm' => $item['total_cbm'] ?? 0,
                'total_cost' => $item['total_cost'] ?? ($item['unit_price'] * $item['qty']),
            ]);

            // Notify Admin
            $admins = User::where('type', 'admin')->get();
            Notification::send($admins, new NewOrderNotification($order, auth()->user()));

            // Notify Seller
            if ($order->product && $order->product->user) {
                $order->product->user->notify(new NewOrderNotification($order, auth()->user()));
            }

            $orders[] = $order;
        }

        return response()->json([
            'success' => true,
            'message' => 'تم إرسال الطلبات بنجاح إلى جميع الأطراف المعنية.',
            'order_ids' => collect($orders)->pluck('id'),
        ]);
    }

    /**
     * Delete an order
     */
    public function destroy(Order $order)
    {
        // Only allow deletion if the order belongs to the user OR the user is the seller of the product
        $isBuyer = $order->user_id === Auth::id();
        $isSeller = $order->product && $order->product->user_id === Auth::id();
        
        if (!$isBuyer && !$isSeller && Auth::user()->type !== 'admin') {
            abort(403, 'غير مصرح لك بحذف هذا الطلب');
        }

        $order->delete();

        return back()->with('success', 'تم حذف الطلب بنجاح');
    }
}
