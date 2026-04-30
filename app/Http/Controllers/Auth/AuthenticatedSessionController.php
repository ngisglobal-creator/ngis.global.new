<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Middleware\CheckDashboardType;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    public function create_factory(): View
    {
        return view('auth.login-factory');
    }

    public function create_company(): View
    {
        return view('auth.login-company');
    }

    public function create_client(): View
    {
        return view('auth.login-client');
    }

    /**
     * Handle an incoming authentication request.
     * يقوم بتوجيه المستخدم إلى لوحة التحكم المناسبة حسب النوع
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        $user = Auth::user();

        // توجيه المستخدم حسب نوعه (type)
        $dashboardUrl = CheckDashboardType::getDashboardUrl($user->type);

        return redirect($dashboardUrl);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
