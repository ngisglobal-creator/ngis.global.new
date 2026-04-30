<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Verification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VerificationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $verifications = Verification::latest()->get();
        return view('admin.verifications.index', compact('verifications'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $types = $this->getTypes();
        return view('admin.verifications.create', compact('types'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'type'  => 'required|in:client,company,factory,china,regional_office',
            'description_ar' => 'nullable|string',
            'description_en' => 'nullable|string',
            'description_zh' => 'nullable|string',
        ]);

        $path = $request->file('image')->store('verifications', 'public');

        Verification::create([
            'image' => $path,
            'type'  => $request->type,
            'description_ar' => $request->description_ar,
            'description_en' => $request->description_en,
            'description_zh' => $request->description_zh,
        ]);

        return redirect()->route('admin.verifications.index')->with('success', 'تم إضافة التوثيق بنجاح');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Verification $verification)
    {
        $types = $this->getTypes();
        return view('admin.verifications.edit', compact('verification', 'types'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Verification $verification)
    {
        $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'type'  => 'required|in:client,company,factory,china,regional_office',
            'description_ar' => 'nullable|string',
            'description_en' => 'nullable|string',
            'description_zh' => 'nullable|string',
        ]);

        $data = [
            'type' => $request->type,
            'description_ar' => $request->description_ar,
            'description_en' => $request->description_en,
            'description_zh' => $request->description_zh,
        ];

        if ($request->hasFile('image')) {
            // Delete old image
            Storage::disk('public')->delete($verification->image);
            $path = $request->file('image')->store('verifications', 'public');
            $data['image'] = $path;
        }

        $verification->update($data);

        return redirect()->route('admin.verifications.index')->with('success', 'تم تحديث التوثيق بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Verification $verification)
    {
        Storage::disk('public')->delete($verification->image);
        $verification->delete();

        return redirect()->route('admin.verifications.index')->with('success', 'تم حذف التوثيق بنجاح');
    }

    private function getTypes()
    {
        return [
            'client'          => 'عميل',
            'company'         => 'شركة',
            'factory'         => 'مصنع',
            'china'           => 'الصين',
            'regional_office' => 'مكتب اقليمي',
        ];
    }
}
