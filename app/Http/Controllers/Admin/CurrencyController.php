<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Currency;
use Illuminate\Http\Request;

class CurrencyController extends Controller
{
    public function index()
    {
        $currencies = Currency::orderBy('code')->get();
        return view('admin.currencies.index', compact('currencies'));
    }

    public function create()
    {
        return view('admin.currencies.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'code'    => 'required|string|max:10|unique:currencies,code',
            'name_ar' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'symbol'  => 'required|string|max:10',
            'is_active' => 'boolean',
        ]);

        Currency::create([
            'code'      => strtoupper($request->code),
            'name_ar'   => $request->name_ar,
            'name_en'   => $request->name_en,
            'symbol'    => $request->symbol,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.currencies.index')->with('success', 'تم إضافة العملة بنجاح');
    }

    public function edit(Currency $currency)
    {
        return view('admin.currencies.edit', compact('currency'));
    }

    public function update(Request $request, Currency $currency)
    {
        $request->validate([
            'code'    => 'required|string|max:10|unique:currencies,code,' . $currency->id,
            'name_ar' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'symbol'  => 'required|string|max:10',
            'is_active' => 'boolean',
        ]);

        $currency->update([
            'code'      => strtoupper($request->code),
            'name_ar'   => $request->name_ar,
            'name_en'   => $request->name_en,
            'symbol'    => $request->symbol,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.currencies.index')->with('success', 'تم تعديل العملة بنجاح');
    }

    public function destroy(Currency $currency)
    {
        $currency->delete();
        return redirect()->route('admin.currencies.index')->with('success', 'تم حذف العملة بنجاح');
    }
}
