<?php

namespace App\Http\Controllers;

use App\Models\Sector;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserSectorController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $sectors = $user->sectors()->get();

        $viewPath = $user->panel_type . '.user_sectors.index';

        return view($viewPath, compact('user', 'sectors'));
    }

    public function create()
    {
        $user = Auth::user();
        $allSectors = Sector::all();
        $userSectorsIds = $user->sectors()->pluck('sectors.id')->toArray();

        $viewPath = $user->panel_type . '.user_sectors.create';

        return view($viewPath, compact('allSectors', 'userSectorsIds'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'sector_ids' => 'required|array',
            'sector_ids.*' => 'exists:sectors,id',
        ]);

        $user = Auth::user();
        $user->sectors()->sync($request->sector_ids);

        return redirect()->route('user-sectors.index')->with('success', __('Sectors updated successfully.'));
    }

    public function destroy($sector_id)
    {
        Auth::user()->sectors()->detach($sector_id);
        return redirect()->route('user-sectors.index')->with('success', __('Sector removed successfully.'));
    }
}
