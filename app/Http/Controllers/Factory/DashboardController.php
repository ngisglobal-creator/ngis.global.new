<?php

namespace App\Http\Controllers\Factory;

use App\Http\Controllers\Controller;
use App\Models\Package;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $packages = Package::where('type', 'factory')->get();
        return view('factory.home', compact('user', 'packages'));
    }
}
