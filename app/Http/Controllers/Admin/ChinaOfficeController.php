<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;

class ChinaOfficeController extends Controller
{
    public function invoices()
    {
        $orders = Order::where('forward_to_china', true)
            ->with(['user.country', 'product.images', 'product.user', 'product.sector', 'payments'])
            ->latest()->get();
        return view('china.invoices', compact('orders'));
    }

    public function regionalOffices()
    {
        $orders = Order::where('forward_to_china', true)
            ->with(['product.user'])
            ->get();
        
        $regionalOffices = $orders->pluck('product.user')->unique('id');
        
        return view('china.regional_offices', compact('regionalOffices'));
    }

    public function customers()
    {
        $orders = Order::where('forward_to_china', true)
            ->with(['user.country'])
            ->get();
        
        $customers = $orders->pluck('user')->unique('id');
        
        return view('china.customers', compact('customers'));
    }

    public function productStatus()
    {
        $orders = Order::where('forward_to_china', true)
            ->with(['product.images', 'product.sector', 'product.user'])
            ->get();
            
        return view('china.product_status', compact('orders'));
    }

    public function showInvoice(Order $order)
    {
        $order->load(['user.country', 'product.images', 'product.user', 'product.sector', 'payments']);
        return view('china.details.invoice', compact('order'));
    }

    public function showRegionalOffice(User $user)
    {
        $orders = Order::where('forward_to_china', true)
            ->whereHas('product', function($q) use ($user) {
                $q->where('user_id', $user->id);
            })
            ->with(['product.images', 'user', 'payments'])
            ->get();
            
        return view('china.details.regional_office', compact('user', 'orders'));
    }

    public function showCustomer(User $user)
    {
        $orders = Order::where('forward_to_china', true)
            ->where('user_id', $user->id)
            ->with(['product.images', 'product.user', 'payments'])
            ->get();
            
        return view('china.details.customer', compact('user', 'orders'));
    }

    public function showProduct(Order $order)
    {
        $order->load(['product.images', 'product.user', 'product.sector', 'user.country', 'payments']);
        return view('china.details.product', compact('order'));
    }
}
