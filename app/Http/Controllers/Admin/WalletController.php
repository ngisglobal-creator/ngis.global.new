<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class WalletController extends Controller
{
    /**
     * Display a listing of user wallets.
     */
    public function index()
    {
        $users = User::with(['country'])->get();
        $totalBalance = $users->sum('wallet_balance');
        
        return view('admin.wallets.index', compact('users', 'totalBalance'));
    }

    /**
     * Show the form for editing the specified user's wallet.
     */
    public function edit(User $user)
    {
        return view('admin.wallets.edit', compact('user'));
    }

    /**
     * Update the specified user's wallet in storage.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'wallet_balance' => 'required|numeric|min:0',
        ]);

        $user->update([
            'wallet_balance' => $request->wallet_balance,
        ]);

        return redirect()->route('admin.wallets.index')->with('success', 'تم تحديث رصيد المحفظة بنجاح');
    }

    /**
     * Display the logged-in user's wallet.
     */
    public function myWallet(Request $request)
    {
        $user = auth()->user();
        
        // Determine layout based on the URL prefix
        $segment = $request->segment(1);
        $layoutPrefix = in_array($segment, ['factory', 'company', 'client', 'regional', 'china']) ? $segment . '.' : '';

        return view('user.wallet', compact('user', 'layoutPrefix'));
    }
}
