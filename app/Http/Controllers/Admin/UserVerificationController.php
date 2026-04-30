<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Verification;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Http\Request;

class UserVerificationController extends Controller
{
    public function index()
    {
        $users = User::where('type', '!=', 'admin')->with(['package', 'verifications'])->latest()->get();
        $types = UserController::userTypes();
        return view('admin.user_verifications.index', compact('users', 'types'));
    }

    public function edit(User $user)
    {
        // Get verifications that match the user's type
        $availableVerifications = Verification::where('type', $user->type)->get();
        $assignedIds = $user->verifications->pluck('id')->toArray();
        
        return view('admin.user_verifications.edit', compact('user', 'availableVerifications', 'assignedIds'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'verification_ids' => 'nullable|array',
            'verification_ids.*' => 'exists:verifications,id',
        ]);

        $user->verifications()->sync($request->verification_ids ?? []);

        return redirect()->route('admin.user-verifications.index')->with('success', 'تم تحديث التوثيقات للمستخدم بنجاح');
    }
}
