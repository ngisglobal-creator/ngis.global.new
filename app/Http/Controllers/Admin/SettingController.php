<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\App;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::all()->pluck('value', 'key');
        return view('admin.settings.index', compact('settings'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'site_name' => 'nullable|string|max:255',
            'site_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->has('site_name')) {
            Setting::set('site_name', $request->site_name);
        }

        if ($request->hasFile('site_logo')) {
            $path = $request->file('site_logo')->store('logos', 'public');
            Setting::set('site_logo', $path);
        }

        return redirect()->back()->with('success', __('dashboard.success'));
    }

    /**
     * Update user language preference
     */
    public function setLanguage(Request $request, $locale = null)
    {
        $newLocale = $locale ?? $request->locale;

        if (!in_array($newLocale, ['ar', 'en', 'zh'])) {
            return redirect()->back();
        }

        if (auth()->check()) {
            $user = auth()->user();
            $user->locale = $newLocale;
            $user->save();
        }

        session(['locale' => $newLocale]);
        App::setLocale($newLocale);

        return redirect()->back()->with('success', __('dashboard.success'));
    }
}
