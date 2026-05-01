<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Package;
use Illuminate\Http\Request;

class UserPackageController extends Controller
{
    /**
     * Display a listing of the users with their packages.
     */
    public function index()
    {
        $users = User::with('package')->where('type', '!=', 'admin')->get();
        return view('admin.user_packages.index', compact('users'));
    }

    /**
     * Show the form for editing the user's package and stars.
     */
    public function edit(User $user)
    {
        // Get packages based on user type (map new types to client)
        $typeForPackages = in_array($user->type, ['merchant', 'company_owner']) ? 'client' : $user->type;
        $packages = Package::where('type', $typeForPackages)->get();
        
        return view('admin.user_packages.edit', compact('user', 'packages'));
    }

    /**
     * Update the user's package and stars in storage.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'package_id' => 'nullable|exists:packages,id',
            'stars'      => 'required|integer|min:0|max:5',
        ]);

        $user->update([
            'package_id' => $request->package_id,
            'stars'      => $request->stars,
        ]);

        return redirect()->route('admin.user-packages.index')->with('success', 'تم تحديث باقة المستخدم والتقييم بنجاح');
    }
}
