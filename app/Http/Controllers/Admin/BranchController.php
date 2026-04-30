<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use Illuminate\Http\Request;

use App\Models\Sector;

class BranchController extends Controller
{
    public function index()
    {
        $branches = Branch::with('sector')->get();
        return view('admin.branches.index', compact('branches'));
    }

    public function create()
    {
        $sectors = Sector::all();
        return view('admin.branches.create', compact('sectors'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'sector_id' => 'required|exists:sectors,id',
            'name_ar'   => 'required|string|max:255',
            'name_en'   => 'required|string|max:255',
            'name_zh'   => 'required|string|max:255',
        ]);

        Branch::create($request->all());

        return redirect()->route('admin.branches.index')->with('success', 'Branch created successfully');
    }

    public function edit(Branch $branch)
    {
        $sectors = Sector::all();
        return view('admin.branches.edit', compact('branch', 'sectors'));
    }

    public function update(Request $request, Branch $branch)
    {
        $request->validate([
            'sector_id' => 'required|exists:sectors,id',
            'name_ar'   => 'required|string|max:255',
            'name_en'   => 'required|string|max:255',
            'name_zh'   => 'required|string|max:255',
        ]);

        $branch->update($request->all());

        return redirect()->route('admin.branches.index')->with('success', 'Branch updated successfully');
    }

    public function destroy(Branch $branch)
    {
        $branch->delete();
        return redirect()->route('admin.branches.index')->with('success', 'Branch deleted successfully');
    }
}
