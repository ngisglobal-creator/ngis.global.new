<?php

namespace App\Http\Controllers\Regional;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ManagementController extends Controller
{
    /**
     * الطلبات الموكلة من العملاء
     */
    public function assignedOrders()
    {
        return view('regional.management.assigned_orders');
    }

    /**
     * الخزينة المالية
     */
    public function financialTreasury()
    {
        return view('regional.management.financial_treasury');
    }

    /**
     * إدارة الشحن
     */
    public function shippingManagement()
    {
        return view('regional.management.shipping_management');
    }

    /**
     * تحديث الحالة التشغيلية
     */
    public function operationalStatus()
    {
        return view('regional.management.operational_status');
    }

    /**
     * إدارة العملاء المرتبطين
     */
    public function linkedClients()
    {
        return view('regional.management.linked_clients');
    }

    /**
     * الحملات التشغيلية
     */
    public function operationalCampaigns()
    {
        return view('regional.management.operational_campaigns');
    }

    /**
     * التقارير التشغيلية
     */
    public function operationalReports()
    {
        return view('regional.management.operational_reports');
    }

    /**
     * التوثيق والتعاقد
     */
    public function documentation()
    {
        return view('regional.management.documentation');
    }

    /**
     * إدارة المخاطر اللوجستية
     */
    public function logisticsRisk()
    {
        return view('regional.management.logistics_risk');
    }

    /**
     * إدارة SLA
     */
    public function slaManagement()
    {
        return view('regional.management.sla_management');
    }

    /**
     * تقييم الأداء التشغيلي (KPI)
     */
    public function performanceKpi()
    {
        return view('regional.management.performance_kpi');
    }
}
