<?php

namespace App\Http\Controllers\GlobalForwarding;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\CustomSourcingOrder;
use App\Models\Sector;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * الصفحة الرئيسية للوحة تحكم شركة الشحن الدولية
     */
    public function index()
    {
        return view('global_forwarding.dashboard');
    }

    /**
     * مسار الطلبات العامة (Standard Orders)
     */
    public function standardOrders()
    {
        return view('global_forwarding.orders.standard');
    }

    /**
     * مسار الطلبات الخاصة (Custom Sourcing Orders)
     */
    public function customOrders()
    {
        $orders = CustomSourcingOrder::with('user')->latest()->get();
        return view('global_forwarding.orders.custom', compact('orders'));
    }

    /**
     * عرض جميع المنتجات التي تمت مطابقتها مع الطلبات الخاصة
     */
    public function matchedProducts()
    {
        $products = Product::whereNotNull('custom_order_id')
            ->with(['customOrder.user', 'images', 'sector', 'branch', 'category'])
            ->latest()
            ->get();
            
        return view('global_forwarding.orders.matched_products', compact('products'));
    }

    /**
     * عرض تفاصيل الطلب المخصص
     */
    public function showCustomOrder($id)
    {
        $order = CustomSourcingOrder::with('user')->findOrFail($id);
        
        // التحديث التلقائي للحالة عند العرض لأول مرة
        if ($order->status == 'pending') {
            $order->update(['status' => 'processing']);
        }

        return view('global_forwarding.orders.show_custom', compact('order'));
    }

    /**
     * صفحة رفع المنتج المطابق لطلب خاص
     */
    public function showUploadMatch($id)
    {
        $order = CustomSourcingOrder::with('user')->findOrFail($id);
        return view('global_forwarding.orders.upload_match', compact('order'));
    }

    /**
     * صفحات الرفع المتخصصة للمطابقة
     */
    public function uploadCarton($id)
    {
        $order = CustomSourcingOrder::findOrFail($id);
        $user = Auth::user();
        $sectors = Sector::all();
        $allSectors = $sectors;
        
        return view('global_forwarding.orders.upload_types.carton', compact('order', 'sectors', 'allSectors', 'user'))->with('mode', 'carton');
    }

    public function uploadSpecial($id)
    {
        $order = CustomSourcingOrder::findOrFail($id);
        $user = Auth::user();
        $sectors = Sector::all();
        $allSectors = $sectors;
        
        return view('global_forwarding.orders.upload_types.special', compact('order', 'sectors', 'allSectors', 'user'))->with('mode', 'special');
    }

    public function uploadCarLight($id)
    {
        $order = CustomSourcingOrder::findOrFail($id);
        $user = Auth::user();
        $sectors = Sector::all();
        $allSectors = $sectors;
        
        return view('global_forwarding.orders.upload_types.car_light', compact('order', 'sectors', 'allSectors', 'user'))->with('mode', 'light');
    }

    public function uploadCarHeavy($id)
    {
        $order = CustomSourcingOrder::findOrFail($id);
        $user = Auth::user();
        $sectors = Sector::all();
        $allSectors = $sectors;
        
        return view('global_forwarding.orders.upload_types.car_heavy', compact('order', 'sectors', 'allSectors', 'user'))->with('mode', 'heavy');
    }

    /**
     * حذف طلب مخصص
     */
    public function deleteCustomOrder($id)
    {
        $order = CustomSourcingOrder::findOrFail($id);
        $order->delete();
        return redirect()->back()->with('success', 'تم حذف الطلب بنجاح');
    }

    /**
     * تحديث حالة الطلب أو ملاحظات الإدارة
     */
    public function updateCustomOrder(Request $request, $id)
    {
        $order = CustomSourcingOrder::findOrFail($id);
        $order->update($request->only(['status', 'admin_notes']));
        return redirect()->back()->with('success', 'تم تحديث بيانات الطلب بنجاح');
    }

    /**
     * التوثيق الرقمي والوسم (Digital QR Passport)
     */
    public function qrPassport()
    {
        return view('global_forwarding.qr_passport.index');
    }

    /**
     * التأمين والامتثال (Insurance & Compliance)
     */
    public function insurance()
    {
        return view('global_forwarding.insurance.index');
    }

    /**
     * المسؤولية وإدارة المخاطر (Liability & Risk Control)
     */
    public function liabilityRisk()
    {
        return view('global_forwarding.liability_risk.index');
    }

    /**
     * الربط اللوجستي الإقليمي (Regional Integration Bridge)
     */
    public function regionalIntegration()
    {
        return view('global_forwarding.regional_integration.index');
    }
}
