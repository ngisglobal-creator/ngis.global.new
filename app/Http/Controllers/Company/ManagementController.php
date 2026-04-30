<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ManagementController extends Controller
{
    /**
     * إدارة المزادات
     */
    public function auctions()
    {
        return view('company.auctions.index');
    }

    /**
     * إدارة المنتجات التجارية
     */
    public function commercialProducts()
    {
        return view('company.commercial_products.index');
    }

    /**
     * إدارة المخزون
     */
    public function inventory()
    {
        return view('company.inventory.index');
    }

    /**
     * التقارير التشغيلية
     */
    public function operationalReports()
    {
        return view('company.reports.index');
    }

    /**
     * التوثيق والتعاقد
     */
    public function contracts()
    {
        return view('company.contracts.index');
    }

    /**
     * نظام تقييم المورد
     */
    public function supplierEvaluation()
    {
        return view('company.supplier_evaluation.index');
    }

    /**
     * إدارة المخاطر
     */
    public function riskManagement()
    {
        return view('company.risk_management.index');
    }

    /**
     * الدعم والمتابعة
     */
    public function support()
    {
        return view('company.support.index');
    }
}
