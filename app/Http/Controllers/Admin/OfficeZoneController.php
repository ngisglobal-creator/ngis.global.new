<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\GeographicZone;
use Illuminate\Http\Request;

class OfficeZoneController extends Controller
{
    public function index()
    {
        $offices = User::whereIn('type', ['regional_office', 'china'])
            ->with(['country', 'geographicZone'])
            ->latest()
            ->get();
            
        return view('admin.office-zones.index', compact('offices'));
    }

    public function assign(User $user)
    {
        if (!in_array($user->type, ['regional_office', 'china'])) {
            abort(403);
        }

        $zones = GeographicZone::with('countries')->get();
        return view('admin.office-zones.assign', compact('user', 'zones'));
    }

    public function update(Request $request, User $user)
    {
        if (!in_array($user->type, ['regional_office', 'china'])) {
            abort(403);
        }

        $request->validate([
            'geographic_zone_id' => 'required|exists:geographic_zones,id'
        ]);

        $user->update([
            'geographic_zone_id' => $request->geographic_zone_id
        ]);

        return redirect()->route('admin.office-zones.index')
            ->with('success', 'تم تعيين نطاق العمل للمكتب بنجاح');
    }

    public function show(User $user)
    {
        if (!in_array($user->type, ['regional_office', 'china'])) {
            abort(403);
        }

        $user->load(['country', 'geographicZone.countries']);
        
        return view('admin.office-zones.show', compact('user'));
    }
}
