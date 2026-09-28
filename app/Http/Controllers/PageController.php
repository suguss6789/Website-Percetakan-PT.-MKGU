<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Response;

class PageController extends Controller
{
    public function home()
    {
        $featured = Product::active()->featured()->with(['category', 'sizes'])->ordered()->take(8)->get();
        // Grid 4 kolom: tampilkan kelipatan 4 supaya baris terakhir tidak bolong.
        if ($featured->count() > 4) {
            $featured = $featured->take(intdiv($featured->count(), 4) * 4);
        }
        $categories = Category::ordered()->withCount(['products' => fn ($q) => $q->active()])->get();

        return view('pages.home', compact('featured', 'categories'));
    }

    public function about()
    {
        return view('pages.about');
    }

    public function services()
    {
        $categories = Category::ordered()
            ->with(['products' => fn ($q) => $q->active()->ordered()->with('sizes')])
            ->get();

        return view('pages.services', compact('categories'));
    }

    public function contact()
    {
        return view('pages.contact');
    }

    public function sitemap(): Response
    {
        $products = Product::active()->get(['slug', 'updated_at']);

        return response()
            ->view('sitemap', compact('products'))
            ->header('Content-Type', 'application/xml');
    }
}
