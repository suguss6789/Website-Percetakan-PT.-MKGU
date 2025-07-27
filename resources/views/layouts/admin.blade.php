<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel - MKGU')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .bg-brand-teal { background-color: #00A99D; }
        .text-brand-teal { color: #00A99D; }
        .border-brand-teal { border-color: #00A99D; }
        .ring-brand-teal { --tw-ring-color: #00A99D; }
        body { font-family: 'Roboto', sans-serif; }
        h1, h2, h3, h4, h5, h6 { font-family: 'Poppins', sans-serif; }
    </style>
    @stack('styles')
</head>
<body class="bg-gray-100 text-gray-800">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside class="w-64 bg-brand-teal text-white flex-shrink-0 flex flex-col min-h-screen sticky top-0">
            <div class="p-6 text-2xl font-bold tracking-wide border-b border-white/10">Admin MKGU</div>
            <nav class="flex-1 p-4 space-y-2">
                <a href="{{ route('admin.dashboard') }}" class="block py-2 px-4 rounded hover:bg-white hover:text-brand-teal transition">Dashboard</a>
                <a href="{{ route('admin.products.index') }}" class="block py-2 px-4 rounded hover:bg-white hover:text-brand-teal transition">Produk</a>
                <a href="{{ route('admin.categories.index') }}" class="block py-2 px-4 rounded hover:bg-white hover:text-brand-teal transition">Kategori</a>
                <a href="{{ route('admin.orders.index') }}" class="block py-2 px-4 rounded hover:bg-white hover:text-brand-teal transition">Order</a>
                <a href="{{ route('admin.customers.index') }}" class="block py-2 px-4 rounded hover:bg-white hover:text-brand-teal transition">Pelanggan</a>
            </nav>
            <form method="POST" action="{{ route('admin.logout') }}" class="p-4 border-t border-white/10">
                @csrf
                <button type="submit" class="w-full py-2 px-4 rounded bg-white text-brand-teal font-bold hover:bg-gray-200 transition">Logout</button>
            </form>
        </aside>
        <!-- Main Content -->
        <div class="flex-1 flex flex-col min-h-screen">
            <!-- Header -->
            <header class="bg-white shadow p-4 flex items-center justify-between sticky top-0 z-10">
                <h1 class="text-2xl font-bold text-brand-teal">@yield('page-title', 'Dashboard')</h1>
                <span class="text-gray-600 text-sm">{{ date('d M Y') }}</span>
            </header>
            <main class="flex-1 p-8">
                @yield('content')
            </main>
        </div>
    </div>
    @stack('scripts')
</body>
</html> 