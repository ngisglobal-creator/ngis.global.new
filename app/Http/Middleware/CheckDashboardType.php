<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckDashboardType
{
    /**
     * مسح نوع المستخدم وتحديد إذا كان مسموحاً بالدخول
     * المدير يمكنه دخول كل اللوحات
     *
     * @param string $allowedType - النوع المسموح له بهذه اللوحة
     */
    public function handle(Request $request, Closure $next, string $allowedType): Response
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        // المدير يدخل كل لوحة
        if ($user->type === 'admin' || $user->hasRole('admin')) {
            return $next($request);
        }

        // Aliasing merchant and company_owner as client for dashboard access purposes
        $userTypeForCheck = in_array($user->type, ['merchant', 'company_owner']) ? 'client' : $user->type;

        // التحقق من نوع المستخدم
        if ($userTypeForCheck !== $allowedType) {
            // إعادة التوجيه للوحة الصحيحة
            return redirect($this->getDashboardUrl($user->type))
                ->with('error', 'غير مسموح لك بالدخول إلى هذه اللوحة.');
        }

        return $next($request);
    }

    /**
     * الحصول على رابط لوحة التحكم الخاصة بكل نوع
     */
    public static function getDashboardUrl(?string $type): string
    {
        return match($type) {
            'client',
            'merchant',
            'company_owner'   => '/client/dashboard',
            'company'         => '/company/dashboard',
            'factory'         => '/factory/dashboard',
            'regional_office' => '/regional/dashboard',
            'china'           => '/china/dashboard',
            'ngis'            => '/ngis/dashboard',
            'global_forwarding' => '/global-forwarding/dashboard',
            'admin'           => '/admin/users',
            default           => '/dashboard',
        };
    }
}
