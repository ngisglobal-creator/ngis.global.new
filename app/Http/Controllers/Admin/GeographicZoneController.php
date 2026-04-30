<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GeographicZone;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GeographicZoneController extends Controller
{
    public function index()
    {
        $zones = GeographicZone::with('countries')->get();
        return view('admin.geographic-zones.index', compact('zones'));
    }

    public function create()
    {
        $countries = Country::orderBy('name_ar')->get();
        return view('admin.geographic-zones.create', compact('countries'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name_ar'    => 'required|string|max:255',
            'name_en'    => 'required|string|max:255',
            'name_zh'    => 'required|string|max:255',
            'image'      => 'nullable|image|mimes:jpg,jpeg,png,svg,webp|max:2048',
            'countries'  => 'nullable|array',
            'countries.*'=> 'exists:countries,id',
        ]);

        $data = $request->only(['name_ar', 'name_en', 'name_zh']);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('geographic-zones', 'public');
        }

        $zone = GeographicZone::create($data);

        if ($request->has('countries')) {
            $zone->countries()->sync($request->countries);
        }

        return redirect()->route('admin.geographic-zones.index')
            ->with('success', 'تم إضافة نطاق العمل الجغرافي بنجاح');
    }

    public function edit(GeographicZone $geographicZone)
    {
        $countries = Country::orderBy('name_ar')->get();
        $selectedCountries = $geographicZone->countries->pluck('id')->toArray();
        return view('admin.geographic-zones.edit', compact('geographicZone', 'countries', 'selectedCountries'));
    }

    public function update(Request $request, GeographicZone $geographicZone)
    {
        $request->validate([
            'name_ar'    => 'required|string|max:255',
            'name_en'    => 'required|string|max:255',
            'name_zh'    => 'required|string|max:255',
            'image'      => 'nullable|image|mimes:jpg,jpeg,png,svg,webp|max:2048',
            'countries'  => 'nullable|array',
            'countries.*'=> 'exists:countries,id',
        ]);

        $data = $request->only(['name_ar', 'name_en', 'name_zh']);

        if ($request->hasFile('image')) {
            // Delete old image
            if ($geographicZone->image) {
                Storage::disk('public')->delete($geographicZone->image);
            }
            $data['image'] = $request->file('image')->store('geographic-zones', 'public');
        }

        $geographicZone->update($data);
        $geographicZone->countries()->sync($request->countries ?? []);

        return redirect()->route('admin.geographic-zones.index')
            ->with('success', 'تم تحديث نطاق العمل الجغرافي بنجاح');
    }

    public function destroy(GeographicZone $geographicZone)
    {
        if ($geographicZone->image) {
            Storage::disk('public')->delete($geographicZone->image);
        }
        $geographicZone->countries()->detach();
        $geographicZone->delete();

        return redirect()->route('admin.geographic-zones.index')
            ->with('success', 'تم حذف نطاق العمل الجغرافي بنجاح');
    }
}
