<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Package;
use App\Models\Country;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public static function userTypes(): array
    {
        return [
            'client'          => 'عميل',
            'merchant'        => 'تاجر',
            'company_owner'   => 'صاحب شركة',
            'company'         => 'شركة',
            'factory'         => 'مصنع',
            'admin'           => 'مدير',
            'regional_office' => 'مكتب اقليم',
            'china'           => 'الصين',
            'ngis'            => 'مكتب NGIS',
            'global_forwarding' => 'شركة الشحن الدولية',
        ];
    }

    public function index()
    {
        $users = User::with(['roles', 'package', 'country'])->get();
        return view('users.index', compact('users'));
    }

    public function create()
    {
        $roles = Role::all();
        $permissions = Permission::all();
        $types = self::userTypes();
        $packages = Package::all();
        $countries = Country::orderBy('name_ar')->get();
        return view('users.create', compact('roles', 'permissions', 'types', 'packages', 'countries'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'email'       => 'required|email|unique:users,email',
            'password'    => 'required|string|min:6|confirmed',
            'type'        => 'nullable|string|in:' . implode(',', array_keys(self::userTypes())),
            'roles'       => 'nullable|array',
            'permissions' => 'nullable|array',
            'package_id'  => 'nullable|exists:packages,id',
            'stars'       => 'nullable|integer|min:0|max:5',
            'country_id'  => 'nullable|exists:countries,id',
            'avatar'      => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = [
            'name'       => $request->name,
            'email'      => $request->email,
            'password'   => Hash::make($request->password),
            'type'       => $request->type,
            'package_id' => $request->package_id,
            'stars'      => $request->stars ?? 0,
            'country_id' => $request->country_id,
        ];

        if ($request->hasFile('avatar')) {
            $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        $user = User::create($data);

        if ($request->roles) {
            $user->assignRole($request->roles);
        }
        if ($request->permissions) {
            $user->givePermissionTo($request->permissions);
        }

        return redirect()->route('admin.users.index')->with('success', 'تم إنشاء المستخدم بنجاح');
    }

    public function edit(User $user)
    {
        $roles = Role::all();
        $permissions = Permission::all();
        $types = self::userTypes();
        $packages = Package::all();
        $countries = Country::orderBy('name_ar')->get();
        return view('users.edit', compact('user', 'roles', 'permissions', 'types', 'packages', 'countries'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'email'       => 'required|email|max:255|unique:users,email,' . $user->id,
            'password'    => 'nullable|string|min:6|confirmed',
            'type'        => 'nullable|string|in:' . implode(',', array_keys(self::userTypes())),
            'roles'       => 'nullable|array',
            'permissions' => 'nullable|array',
            'package_id'  => 'nullable|exists:packages,id',
            'stars'       => 'nullable|integer|min:0|max:5',
            'country_id'  => 'nullable|exists:countries,id',
            'avatar'      => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user->name       = $request->name;
        $user->email      = $request->email;
        $user->type       = $request->type;
        $user->package_id = $request->package_id;
        $user->stars      = $request->stars ?? 0;
        $user->country_id = $request->country_id;

        if ($request->hasFile('avatar')) {
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }
            $user->avatar = $request->file('avatar')->store('avatars', 'public');
        }

        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }

        $user->save();
        $user->syncRoles($request->roles ?? []);
        $user->syncPermissions($request->permissions ?? []);

        return redirect()->route('admin.users.index')->with('success', 'تم تحديث بيانات المستخدم بنجاح');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'تم حذف المستخدم بنجاح');
    }
}
