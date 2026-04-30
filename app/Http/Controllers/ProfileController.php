<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $user = $request->user();
        $viewPath = 'profile.edit'; // Default

        $typeMapping = [
            'admin'           => 'admin.profile.edit',
            'client'          => 'client.profile.edit',
            'company'         => 'company.profile.edit',
            'factory'         => 'factory.profile.edit',
            'regional_office' => 'regional.profile.edit',
            'china'           => 'china.profile.edit',
        ];

        if (isset($typeMapping[$user->type])) {
            $viewPath = $typeMapping[$user->type];
        } elseif ($user->hasRole('admin')) {
            $viewPath = 'admin.profile.edit';
        }

        return view($viewPath, [
            'user' => $user,
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request): RedirectResponse
    {
        $user = $request->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'document_pdf' => 'nullable|mimes:pdf|max:10000',
            'passport' => 'nullable|mimes:jpeg,png,jpg,gif,pdf|max:5120',
            'certificates.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = \Illuminate\Support\Facades\Hash::make($request->password);
        }

        if ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $path;
        }

        if ($request->hasFile('document_pdf')) {
            $path = $request->file('document_pdf')->store('documents', 'public');
            $user->document_pdf = $path;
        }

        if ($request->hasFile('passport')) {
            $path = $request->file('passport')->store('passports', 'public');
            $user->passport = $path;
        }

        if ($request->hasFile('certificates')) {
            $certs = $user->certificates ?? [];
            foreach ($request->file('certificates') as $file) {
                $path = $file->store('certificates', 'public');
                $certs[] = $path;
            }
            $user->certificates = $certs;
        }

        $user->save();

        return Redirect::route('profile.edit')->with('success', __('dashboard.success') ?? 'Profile Updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
