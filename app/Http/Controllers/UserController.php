<?php

namespace App\Http\Controllers;

use App\Models\User;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // الأنواع المتاحة
    public static function userTypes(): array
    {
        return [
            'client'          => 'عميل',
            'company'         => 'شركة',
            'factory'         => 'مصنع',
            'admin'           => 'مدير',
            'regional_office' => 'مكتب اقليم',
            'china'           => 'الصين',
        ];
    }

    // عرض جميع المستخدمين
    public function index()
    {
        $users = User::with('roles')->get();
        return view('users.index', compact('users'));
    }

    // صفحة إنشاء مستخدم جديد
    public function create()
    {
        $roles = Role::all();
        $permissions = Permission::all();
        $types = self::userTypes();
        return view('users.create', compact('roles', 'permissions', 'types'));
    }

    // حفظ مستخدم جديد
    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'email'       => 'required|email|unique:users,email',
            'password'    => 'required|string|min:6|confirmed',
            'type'        => 'nullable|string|in:' . implode(',', array_keys(self::userTypes())),
            'roles'       => 'nullable|array',
            'permissions' => 'nullable|array',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'type'     => $request->type,
        ]);

        if ($request->roles) {
            $user->assignRole($request->roles);
        }

        if ($request->permissions) {
            $user->givePermissionTo($request->permissions);
        }

        return redirect()->route('users.index')->with('success', 'تم إنشاء المستخدم بنجاح');
    }

    // صفحة تعديل المستخدم
    public function edit(User $user)
    {
        $roles = Role::all();
        $permissions = Permission::all();
        $types = self::userTypes();
        return view('users.edit', compact('user', 'roles', 'permissions', 'types'));
    }

    // تحديث بيانات المستخدم، الأدوار والصلاحيات
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'email'       => 'required|email|max:255|unique:users,email,' . $user->id,
            'password'    => 'nullable|string|min:6|confirmed',
            'type'        => 'nullable|string|in:' . implode(',', array_keys(self::userTypes())),
            'roles'       => 'nullable|array',
            'permissions' => 'nullable|array',
        ]);

        $user->name  = $request->name;
        $user->email = $request->email;
        $user->type  = $request->type;

        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }

        $user->save();

        $user->syncRoles($request->roles ?? []);
        $user->syncPermissions($request->permissions ?? []);

        return redirect()->route('users.index')->with('success', 'تم تحديث بيانات المستخدم بنجاح');
    }

    // حذف المستخدم
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'تم حذف المستخدم بنجاح');
    }
}
