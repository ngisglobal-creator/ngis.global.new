<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Auth::user()->notifications()->latest()->paginate(20);
        
        $viewPath = 'notifications.index';
        $userType = Auth::user()->type;
        
        // Map user types to their respective view locations if they differ
        // For now, using a unified view structure or role-prefixed ones
        if (view()->exists($userType . '.notifications.index')) {
            $viewPath = $userType . '.notifications.index';
        }

        return view($viewPath, compact('notifications'));
    }

    public function show($id)
    {
        $notification = Auth::user()->notifications()->findOrFail($id);
        
        if ($notification->unread()) {
            $notification->markAsRead();
        }

        $userType = Auth::user()->type;
        $viewPath = 'notifications.show';
        if (view()->exists($userType . '.notifications.show')) {
            $viewPath = $userType . '.notifications.show';
        }

        return view($viewPath, compact('notification'));
    }

    public function markAllAsRead()
    {
        Auth::user()->unreadNotifications->markAsRead();
        return back()->with('success', 'تم تحديد الكل كمقروء');
    }
}
