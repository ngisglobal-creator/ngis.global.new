<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Notifications\RegionalOrderAssignmentNotification;
use Illuminate\Support\Facades\Notification;

class ManagementController extends Controller
{
    public function factories()
    {
        $factories = User::where('type', 'factory')->latest()->get();
        return view('admin.management.factories', compact('factories'));
    }

    public function companies()
    {
        $companies = User::where('type', 'company')->latest()->get();
        return view('admin.management.companies', compact('companies'));
    }

    public function clients()
    {
        $clients = User::where('type', 'client')->latest()->get();
        return view('admin.management.clients', compact('clients'));
    }

    public function regional()
    {
        $offices = User::where('type', 'regional_office')->latest()->get();
        return view('admin.management.regional', compact('offices'));
    }

    public function china()
    {
        $china = User::where('type', 'china')->latest()->get();
        return view('admin.management.china', compact('china'));
    }

    public function productsByRole($type)
    {
        $products = Product::whereHas('user', function($q) use ($type) {
            $q->where('type', $type);
        })->with(['user', 'sector'])->latest()->get();
        
        $typeName = $type == 'factory' ? 'المصانع' : 'الشركات';
        return view('admin.management.products', compact('products', 'typeName'));
    }

    public function clientOrders()
    {
        $orders = Order::with(['user', 'product', 'product.user'])->latest()->get();
        return view('admin.management.orders', compact('orders'));
    }

    public function showOrder(Order $order)
    {
        $order->load(['user', 'product', 'product.user', 'product.images', 'product.sector', 'product.branch', 'product.category']);
        return view('admin.management.order_details', compact('order'));
    }

    public function deleteOrder(Order $order)
    {
        $order->delete();
        return back()->with('success', 'تم حذف الطلب بنجاح');
    }

    public function sendToRegional(Order $order)
    {
        if ($order->status !== 'accepted') {
            return back()->with('error', 'يجب أن يكون الطلب مقبولاً ليتم إرساله للمكتب الإقليمي');
        }

        $order->update(['assigned_to_regional' => true]);

        // Find regional office that matches the client's country directly
        $client = $order->user;
        if (!$client->country_id) {
            return back()->with('error', 'تعذر العثور على دولة العميل');
        }

        $regionalOffice = User::where('type', 'regional_office')
            ->where('country_id', $client->country_id)
            ->first();

        if ($regionalOffice) {
            Notification::send($regionalOffice, new RegionalOrderAssignmentNotification($order, $client));
            return back()->with('success', 'تم إرسال الطلب بنجاح إلى المكتب الإقليمي لـ ' . ($client->country->name_ar ?? 'هذه الدولة'));
        }

        return back()->with('warning', 'تم تمييز الطلب كإقليمي، ولكن لم يتم العثور على مكتب إقليمي مخصص لدولة العميل (' . ($client->country->name_ar ?? $client->country_id) . ')');
    }

    public function invoices()
    {
        $orders = Order::where('assigned_to_regional', true)
            ->whereNotNull('invoice_file')
            ->with(['user.country', 'product.images', 'product.user'])
            ->latest()->get();
        return view('admin.management.invoices.index', compact('orders'));
    }

    public function paymentStatus()
    {
        $orders = Order::where('assigned_to_regional', true)
            ->with(['user.country', 'product.images', 'product.user', 'payments'])
            ->latest()->get();
        return view('admin.management.invoices.payment_status', compact('orders'));
    }

    public function invoiceDetails(Order $order)
    {
        $order->load(['user.country', 'product.images', 'product.user', 'product.sector', 'payments']);
        return view('admin.management.invoices.show', compact('order'));
    }

    public function editInvoice(Order $order)
    {
        $order->load(['user.country', 'product.images', 'product.user', 'product.sector']);
        return view('admin.management.invoices.edit', compact('order'));
    }

    public function updateInvoice(Request $request, Order $order)
    {
        $request->validate([
            'paid_amount'    => 'required|numeric|min:0',
            'payment_status' => 'required|in:unpaid,partial,paid',
            'contract_file'  => 'nullable|mimes:pdf,jpg,jpeg,png|max:10240',
            'invoice_file'   => 'nullable|mimes:pdf,jpg,jpeg,png|max:10240',
        ]);

        $data = $request->only(['paid_amount', 'payment_status']);

        if ($request->hasFile('contract_file')) {
            $data['contract_file'] = $request->file('contract_file')->store('contracts', 'public');
        }
        if ($request->hasFile('invoice_file')) {
            $data['invoice_file'] = $request->file('invoice_file')->store('invoices', 'public');
        }

        $order->update($data);

        return redirect()->route('admin.invoices.show', $order)->with('success', 'تم تحديث البيانات المالية بنجاح');
    }

    public function paidInvoices()
    {
        $orders = Order::where('payment_status', 'paid')
            ->with(['user.country', 'product.images', 'product.user', 'payments'])
            ->latest()->get();
        return view('admin.management.invoices.paid', compact('orders'));
    }

    public function forwardToChina(Order $order)
    {
        $order->update(['forward_to_china' => true]);
        return redirect()->back()->with('success', 'تم توجيه الفاتورة إلى مكتب الصين بنجاح');
    }
}
