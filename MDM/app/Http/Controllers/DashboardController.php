<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $brands =$user->brands()->latest()->paginate(5);    
        $categories = $user->categories()->latest()->paginate(5);
        $items = $user->items()->with(['brand', 'category'])->latest()->paginate(5);
    
        return view('dashboard', compact('brands', 'categories', 'items'));
    }
}


