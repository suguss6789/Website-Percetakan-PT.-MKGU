<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Order;

class DashboardController extends Controller
{
    public function index()
    {
        $totalProducts = Product::count();
        $totalCategories = Category::count();
        $totalOrders = Order::count();
        $totalCustomers = Order::distinct('customer_email')->count('customer_email');
        $recentOrders = Order::orderByDesc('created_at')->limit(5)->get();
        return view('admin.dashboard', compact('totalProducts', 'totalCategories', 'totalOrders', 'totalCustomers', 'recentOrders'));
    }
} 