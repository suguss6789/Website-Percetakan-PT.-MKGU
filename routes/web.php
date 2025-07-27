<?php

use Illuminate\Support\Facades\Route;
use App\Models\Product;
use App\Models\Category;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route untuk halaman utama
Route::get('/', function () {
    $products = Product::latest()->take(4)->get(); // Ambil 4 produk terbaru
    $categories = Category::all();
    return view('welcome', compact('products', 'categories'));
})->name('home');

// Route untuk halaman statis
Route::get('/layanan', [PageController::class, 'layanan'])->name('layanan');
Route::get('/tentang-kami', [PageController::class, 'tentang'])->name('about');


// --- Grup Route untuk Produk ---

// Route untuk menampilkan halaman daftar semua produk
Route::get('/produk', [ProductController::class, 'index'])->name('products.index');

// Route untuk menampilkan halaman detail satu produk (method GET)
Route::get('/produk/{product:slug}', [ProductController::class, 'show'])->name('products.show');

// Route untuk menerima data dari form di halaman detail produk (method POST)
Route::post('/produk/{product:slug}', [ProductController::class, 'handleFormSubmission'])->name('products.submit');

// Route untuk menampilkan invoice dan mengupload konfirmasi pembayaran setelah order. Route: /invoice/{order_code} dan POST /invoice/{order_code}/confirm.
Route::get('/invoice/{order_code}', [ProductController::class, 'invoice'])->name('invoice.show');
Route::post('/invoice/{order_code}/confirm', [ProductController::class, 'confirmPayment'])->name('invoice.confirm');
Route::get('/invoice/{order_code}/download', [ProductController::class, 'downloadInvoice'])->name('invoice.download');


// ===== ROUTE LOGIN ADMIN ONLY =====
use App\Http\Controllers\Auth\LoginController;
Route::get('/admin/login', [LoginController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [LoginController::class, 'login']);
Route::post('/admin/logout', [LoginController::class, 'logout'])->name('admin.logout');

// ===== ADMIN PANEL ROUTES =====
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductAdminController;
use App\Http\Controllers\Admin\CategoryAdminController;
use App\Http\Controllers\Admin\OrderAdminController;
use App\Http\Controllers\Admin\CustomerAdminController;

Route::prefix('admin')->middleware(['auth', 'is_admin'])->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('products', ProductAdminController::class);
    Route::resource('categories', CategoryAdminController::class);
    Route::resource('orders', OrderAdminController::class);
    Route::get('orders/{order}/designs', [OrderAdminController::class, 'designs'])->name('orders.designs');
    Route::resource('customers', CustomerAdminController::class); // support all CRUD
    Route::post('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');
    Route::delete('products/{product}', [ProductAdminController::class, 'destroy'])->name('products.destroy');
});