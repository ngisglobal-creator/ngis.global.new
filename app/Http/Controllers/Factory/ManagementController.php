<?php

namespace App\Http\Controllers\Factory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ManagementController extends Controller
{
    /**
     * إدارة المخزون
     */
    public function inventory()
    {
        return view('factory.management.inventory');
    }

    /**
     * تقارير الإنتاج والتوريد
     */
    public function productionSupplyReports()
    {
        return view('factory.management.production_supply_reports');
    }

    /**
     * مؤشرات الأداء الإنتاجي (KPI)
     */
    public function performanceKpi()
    {
        return view('factory.management.performance_kpi');
    }

    /**
     * إدارة المخاطر
     */
    public function riskManagement()
    {
        return view('factory.management.risk_management');
    }

    /**
     * الدعم والمتابعة
     */
    public function support()
    {
        return view('factory.management.support');
    }
}
