<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ManagementController extends Controller
{
    /**
     * Display Auction Management page.
     */
    public function auctions()
    {
        return view('client.auctions.index');
    }

    /**
     * Display Risk Management page.
     */
    public function riskManagement()
    {
        return view('client.risk_management.index');
    }

    /**
     * Display Supplier Evaluation page.
     */
    public function supplierEvaluation()
    {
        return view('client.supplier_evaluation.index');
    }
}
