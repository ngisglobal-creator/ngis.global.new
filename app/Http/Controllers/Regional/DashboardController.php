<?php

namespace App\Http\Controllers\Regional;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderPayment;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    private function getOfficeCountryId()
    {
        return auth()->user()->country_id;
    }

    public function index()
    {
        $countryId = $this->getOfficeCountryId();

        $clients = Order::where('assigned_to_regional', true)
            ->whereHas('user', fn($q) => $q->where('country_id', $countryId))
            ->with(['user.country', 'product.images'])
            ->latest()->take(10)->get();

        $invoices = Order::where('assigned_to_regional', true)
            ->whereNotNull('invoice_file')
            ->whereHas('user', fn($q) => $q->where('country_id', $countryId))
            ->with(['user.country', 'product.images'])
            ->latest()->take(10)->get();

        return view('regional.home', compact('clients', 'invoices'));
    }

    public function showDetails()
    {
        $user = auth()->user()->load(['country', 'geographicZone.countries']);
        return view('regional.details', compact('user'));
    }

    public function clients()
    {
        $countryId = $this->getOfficeCountryId();
        $orders = Order::where('assigned_to_regional', true)
            ->whereHas('user', fn($q) => $q->where('country_id', $countryId))
            ->with(['user.country', 'product.images', 'product.user', 'payments'])
            ->latest()->get();
        return view('regional.clients.index', compact('orders'));
    }

    public function createContract(Order $order)
    {
        $order->load(['user.country', 'product.images', 'product.user', 'payments']);
        return view('regional.clients.contract', compact('order'));
    }

    public function storeContract(Request $request, Order $order)
    {
        $request->validate([
            'contract_file'  => 'nullable|mimes:pdf,jpg,jpeg,png|max:10240',
            'invoice_file'   => 'nullable|mimes:pdf,jpg,jpeg,png|max:10240',
            'paid_amount'    => 'nullable|numeric|min:0',
            'payment_status' => 'nullable|in:unpaid,partial,paid',
            'payment_date'   => 'nullable|date',
            'notes'          => 'nullable|string',
        ]);

        $data = [];
        if ($request->hasFile('contract_file')) {
            $data['contract_file'] = $request->file('contract_file')->store('contracts', 'public');
        }
        if ($request->hasFile('invoice_file')) {
            $data['invoice_file'] = $request->file('invoice_file')->store('invoices', 'public');
        }
        if ($request->filled('payment_status')) {
            $data['payment_status'] = $request->payment_status;
        }
        if ($request->filled('paid_amount') && $request->paid_amount > 0) {
            // ACCUMULATE, not overwrite
            $data['paid_amount'] = $order->paid_amount + $request->paid_amount;
        }

        $order->update($data);

        // Record a payment history entry if amount was entered
        if ($request->filled('paid_amount') && $request->paid_amount > 0) {
            OrderPayment::create([
                'order_id'     => $order->id,
                'amount'       => $request->paid_amount,
                'status'       => $request->payment_status ?? 'partial',
                'notes'        => $request->notes,
                'payment_date' => $request->payment_date ?? now()->toDateString(),
            ]);
        }

        return redirect()->route('regional.clients.show', $order)->with('success', 'تم حفظ بيانات العقد والدفع بنجاح!');
    }

    public function showOrder(Order $order)
    {
        $order->load(['user.country', 'product.images', 'product.user', 'product.sector', 'payments']);
        return view('regional.clients.show', compact('order'));
    }

    // ─── Invoices Page ─────────────────────────────────────────────────────────
    public function invoices()
    {
        $countryId = $this->getOfficeCountryId();
        $orders = Order::where('assigned_to_regional', true)
            ->whereNotNull('invoice_file')
            ->whereHas('user', fn($q) => $q->where('country_id', $countryId))
            ->with(['user.country', 'product.images', 'product.user'])
            ->latest()->get();
        return view('regional.invoices.index', compact('orders'));
    }

    // ─── Payment Status Page ────────────────────────────────────────────────────
    public function paymentStatus()
    {
        $countryId = $this->getOfficeCountryId();
        $orders = Order::where('assigned_to_regional', true)
            ->whereHas('user', fn($q) => $q->where('country_id', $countryId))
            ->with(['user.country', 'product.images', 'product.user', 'payments'])
            ->latest()->get();
        return view('regional.invoices.payment_status', compact('orders'));
    }

    // ─── Edit Payment (add new payment entry) ──────────────────────────────────
    public function editPayment(Order $order)
    {
        $order->load(['user.country', 'product.images', 'product.user', 'payments']);
        return view('regional.invoices.edit_payment', compact('order'));
    }

    public function storePayment(Request $request, Order $order)
    {
        $request->validate([
            'amount'         => 'required|numeric|min:0',
            'status'         => 'required|in:unpaid,partial,paid',
            'payment_date'   => 'required|date',
            'notes'          => 'nullable|string',
        ]);

        // Accumulate total paid
        $newTotal = $order->paid_amount + $request->amount;

        OrderPayment::create([
            'order_id'     => $order->id,
            'amount'       => $request->amount,
            'status'       => $request->status,
            'notes'        => $request->notes,
            'payment_date' => $request->payment_date,
        ]);

        $order->update([
            'paid_amount'    => $newTotal,
            'payment_status' => $request->status,
        ]);

        return redirect()->route('regional.invoices.payment_status')->with('success', 'تم تسجيل دفعة جديدة بنجاح!');
    }
}
