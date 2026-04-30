<?php

namespace App\Http\Controllers\Ngis;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return view('ngis.dashboard');
    }

    // ============================================================
    // قسم الأول (مكتب إقليمي داخلي)
    // ============================================================
    public function internalClients() { return view('ngis.internal.clients'); }
    public function internalOrders() { return view('ngis.internal.orders'); }
    public function internalAuctions() { return view('ngis.internal.auctions'); }
    public function internalTreasury() { return view('ngis.internal.treasury'); }
    public function internalCampaigns() { return view('ngis.internal.campaigns'); }
    public function internalShipping() { return view('ngis.internal.shipping'); }
    public function internalSuppliers() { return view('ngis.internal.suppliers'); }
    public function internalBi() { return view('ngis.internal.bi'); }
    public function internalClientAuth() { return view('ngis.internal.client_auth'); }
    public function internalContracts() { return view('ngis.internal.contracts'); }
    public function internalRisk() { return view('ngis.internal.risk'); }
    public function internalCompliance() { return view('ngis.internal.compliance'); }
    public function internalSupport() { return view('ngis.internal.support'); }

    // ============================================================
    // قسم الثاني (مكتب توريد دولي)
    // ============================================================
    public function internationalContracts() { return view('ngis.international.contracts'); }
    public function internationalFactories() { return view('ngis.international.factories'); }
    public function internationalOrders() { return view('ngis.international.orders'); }
    public function internationalTreasury() { return view('ngis.international.treasury'); }
    public function internationalShipping() { return view('ngis.international.shipping'); }
    public function internationalInvestments() { return view('ngis.international.investments'); }
    public function internationalAuctions() { return view('ngis.international.auctions'); }
    public function internationalLegalRisk() { return view('ngis.international.legal_risk'); }
    public function internationalSupplyChain() { return view('ngis.international.supply_chain'); }
    public function internationalCompliance() { return view('ngis.international.compliance'); }
    public function internationalSupport() { return view('ngis.international.support'); }
}
