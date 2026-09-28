<?php

namespace App\Providers;

use App\Models\Category;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Paginator::defaultView('components.pagination');

        // Daftar kategori untuk footer, diambil sekali per request.
        View::composer('layouts.app', function ($view) {
            static $categories = null;
            $categories ??= Schema::hasTable('categories') ? Category::ordered()->get(['name', 'slug']) : collect();
            $view->with('footerCategories', $categories);
        });
    }
}
