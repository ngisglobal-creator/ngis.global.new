<?php

namespace App\Http\Controllers\China;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        return view('china.home');
    }

    public function showDetails()
    {
        $user = auth()->user()->load(['country', 'geographicZone.countries']);
        return view('china.details', compact('user'));
    }
}
