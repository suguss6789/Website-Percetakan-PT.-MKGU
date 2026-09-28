<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'activeCount' => Product::active()->count(),
            'hiddenCount' => Product::where('is_active', false)->count(),
            'categoryCount' => Category::count(),
            'featuredCount' => Product::active()->featured()->count(),
            'recent' => Product::with('category')->latest('updated_at')->take(5)->get(),
            'noImage' => Product::whereNull('cover_image')->orderBy('name')->get(['id', 'name']),
            'noPrice' => Product::doesntHave('sizes')->orderBy('name')->get(['id', 'name']),
        ]);
    }
}
