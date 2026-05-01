<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'users' => User::count(),
            'admins' => User::role('admin')->count(),
            // Add more stats as needed
        ];
        
        return view('admin.dashboard', compact('stats'));
    }
}
