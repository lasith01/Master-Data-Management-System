<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        $brands = $user->is_admin
            ? MasterBrand::latest()->paginate(5)
            : $user->brands()->latest()->paginate(5);
        return view('brands.index', compact('brands'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('brands.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|unique:master_brands|max:255',
            'name' => 'required|max:255',
        ]);

        return redirect()->route('brands.index')->with('success', 'Brand created successfully.');   
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MasterBrand $brand)
    {
        if (!auth()->user()->is_admin && auth()->id() !== $brand->user_id) {
            abort(403, 'Unauthorized action.');
        }

        return view('brands.edit', compact('brand'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MasterBrand $brand)
    {
        if (!auth()->user()->is_admin && auth()->id() !== $brand->user_id) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'code' => 'required|max:255|unique:master_brands,code,' . $brand->id,
            'name' => 'required|max:255',
            'status' => 'required|in:Active,Inactive',
        ]);

        $brand->update([
            'code' => $request->code,
            'name' => $request->name,
            'status' => $request->status,
        ]);

        return redirect()->route('brands.index')->with('success', 'Brand updated successfully.');
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MasterBrand $brand)
    {
        if (!auth()->user()->is_admin && auth()->id() !== $brand->user_id) {
            abort(403, 'Unauthorized action.');
        }

        $brand->delete();

        return redirect()->route('brands.index')->with('success', 'Brand deleted successfully.');
    }
   
    
}
