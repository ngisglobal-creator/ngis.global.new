<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    public function create_factory(): View
    {
        return view('auth.register-factory');
    }

    public function create_company(): View
    {
        return view('auth.register-company');
    }

    public function create_client(): View
    {
        return view('auth.register-client');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'type' => ['nullable', 'string', 'in:factory,company,client'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'type' => $request->type ?? 'client',
        ]);

        event(new Registered($user));

        Auth::login($user);

        // Redirect based on type
        if ($user->type === 'factory') {
            return redirect(route('factory.dashboard'));
        } elseif ($user->type === 'company') {
            return redirect(route('company.dashboard'));
        }

        return redirect(route('client.dashboard'));
    }
}
