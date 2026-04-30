<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Package;
use App\Models\CustomSourcingOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $packages = Package::where('type', 'client')->get();

        // Get sectors associated with the authenticated client
        $userSectorIds = $user->sectors->pluck('id')->toArray();

        // Fetch products that match the client's sectors
        $suggestedProducts = \App\Models\Product::with(['images', 'user', 'sector', 'category'])
            ->whereIn('sector_id', $userSectorIds)
            ->latest()
            ->take(12)
            ->get();

        return view('client.home', compact('user', 'packages', 'suggestedProducts'));
    }

    public function subscriptionPlans()
    {
        return view('client.subscription_plans');
    }

    public function specialOrder()
    {
        return view('client.special_order');
    }

    public function storeSpecialOrder(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category_type' => 'required',
            'description' => 'required',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'spec_file' => 'nullable|mimes:pdf,dwg,dxf|max:10000',
        ]);

        $data = $request->except(['images', 'spec_file']);
        $data['user_id'] = Auth::id();

        // Handle Images
        if ($request->hasFile('images')) {
            $images = [];
            foreach ($request->file('images') as $image) {
                $path = $image->store('custom_orders/images', 'public');
                $images[] = $path;
            }
            $data['images'] = $images;
        }

        // Handle Spec File
        if ($request->hasFile('spec_file')) {
            $data['spec_file'] = $request->file('spec_file')->store('custom_orders/specs', 'public');
        }

        CustomSourcingOrder::create($data);

        return redirect()->route('client.special_orders.index')->with('success', 'تم إرسال طلبك الخاص بنجاح، سيقوم فريقنا بمراجعته والرد عليك قريباً.');
    }

    public function mySpecialOrders()
    {
        $orders = CustomSourcingOrder::with(['matchedProducts.images', 'matchedProducts.sector', 'matchedProducts.branch', 'matchedProducts.category'])
            ->where('user_id', Auth::id())
            ->latest()
            ->get();
        return view('client.my_special_orders', compact('orders'));
    }

    public function editSpecialOrder($id)
    {
        $order = CustomSourcingOrder::where('user_id', Auth::id())->findOrFail($id);
        return view('client.edit_special_order', compact('order'));
    }

    public function updateSpecialOrder(Request $request, $id)
    {
        $order = CustomSourcingOrder::where('user_id', Auth::id())->findOrFail($id);
        
        $request->validate([
            'title' => 'required|string|max:255',
            'category_type' => 'required',
            'description' => 'required',
        ]);

        $data = $request->except(['images', 'spec_file']);

        // Update Images if new ones provided
        if ($request->hasFile('images')) {
            $images = [];
            foreach ($request->file('images') as $image) {
                $path = $image->store('custom_orders/images', 'public');
                $images[] = $path;
            }
            $data['images'] = $images;
        }

        // Update Spec File if new one provided
        if ($request->hasFile('spec_file')) {
            $data['spec_file'] = $request->file('spec_file')->store('custom_orders/specs', 'public');
        }

        $order->update($data);

        return redirect()->route('client.special_orders.index')->with('success', 'تم تحديث الطلب بنجاح');
    }

    public function deleteSpecialOrder($id)
    {
        $order = CustomSourcingOrder::where('user_id', Auth::id())->findOrFail($id);
        $order->delete();
        return redirect()->back()->with('success', 'تم حذف الطلب بنجاح');
    }
}
