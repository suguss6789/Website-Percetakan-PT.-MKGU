@php
    $menu = [
        ['admin.dashboard', 'Dashboard', 'home', 'admin.dashboard'],
        ['admin.products.index', 'Produk', 'box', 'admin.products.*'],
        ['admin.categories.index', 'Kategori', 'folder', 'admin.categories.*'],
        ['admin.partners.index', 'Partner', 'star', 'admin.partners.*'],
        ['admin.settings.edit', 'Profil & Kontak', 'settings', 'admin.settings.*'],
        ['admin.account.edit', 'Akun Saya', 'user', 'admin.account.*'],
    ];
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex">
    <title>@yield('title', 'Admin') · Admin MKGU</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-paper" x-data="{ nav: false }">
    <div class="brand-bar"></div>
    <div class="flex min-h-screen">
        {{-- Sidebar --}}
        <aside class="fixed inset-y-0 left-0 z-40 flex w-64 -translate-x-full flex-col border-r border-line bg-white transition-transform lg:static lg:translate-x-0" :class="nav && 'translate-x-0'">
            <div class="flex h-20 items-center justify-between border-b border-line px-5">
                <a href="{{ route('admin.dashboard') }}"><img src="{{ asset('assets/image/logo-transparan.png') }}" alt="MKGU" class="h-10 w-auto"></a>
                <button class="lg:hidden" @click="nav = false" aria-label="Tutup menu"><x-icon name="x" /></button>
            </div>
            <nav class="flex-1 space-y-1 p-3">
                @foreach ($menu as [$route, $label, $icon, $pattern])
                    <a href="{{ route($route) }}" @class([
                        'flex items-center gap-3 rounded px-3 py-2.5 text-[15px] font-semibold transition',
                        'bg-brand-green-deep text-white' => request()->routeIs($pattern),
                        'text-ink-muted hover:bg-paper hover:text-ink' => ! request()->routeIs($pattern),
                    ])><x-icon :name="$icon" class="h-[18px] w-[18px]" /> {{ $label }}</a>
                @endforeach
            </nav>
            <div class="space-y-1 border-t border-line p-3">
                <a href="{{ route('home') }}" target="_blank" class="flex items-center gap-3 rounded px-3 py-2.5 text-[15px] font-semibold text-ink-muted hover:bg-paper hover:text-ink"><x-icon name="external" class="h-[18px] w-[18px]" /> Lihat website</a>
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button class="flex w-full items-center gap-3 rounded px-3 py-2.5 text-[15px] font-semibold text-ink-muted hover:bg-paper hover:text-brand-orange-deep"><x-icon name="log-out" class="h-[18px] w-[18px]" /> Keluar</button>
                </form>
            </div>
        </aside>
        <div x-cloak x-show="nav" @click="nav = false" class="fixed inset-0 z-30 bg-ink/40 lg:hidden"></div>

        <div class="flex min-w-0 flex-1 flex-col">
            <header class="flex h-16 items-center justify-between gap-4 border-b border-line bg-paper px-4 sm:px-8">
                <div class="flex items-center gap-3">
                    <button class="inline-flex h-10 w-10 items-center justify-center rounded border border-line lg:hidden" @click="nav = true" aria-label="Buka menu"><x-icon name="menu" /></button>
                    <p class="label-mono">@yield('crumb', 'Admin')</p>
                </div>
                <p class="text-sm text-ink-muted">Masuk sebagai <span class="font-semibold text-ink">{{ auth()->user()->name }}</span></p>
            </header>

            <main class="flex-1 px-4 py-8 sm:px-8">
                @if (session('status'))
                    <div class="mb-6 flex items-start gap-3 border-l-[3px] border-brand-green bg-white px-4 py-3 text-[15px]" role="status">
                        <x-icon name="check" class="mt-0.5 h-5 w-5 text-brand-green-deep" /> {{ session('status') }}
                    </div>
                @endif
                @if (session('error'))
                    <div class="mb-6 flex items-start gap-3 border-l-[3px] border-brand-orange bg-white px-4 py-3 text-[15px]" role="alert">
                        <x-icon name="alert" class="mt-0.5 h-5 w-5 text-brand-orange-deep" /> {{ session('error') }}
                    </div>
                @endif
                @if ($errors->any())
                    <div class="mb-6 border-l-[3px] border-brand-orange bg-white px-4 py-3 text-[15px]" role="alert">
                        <p class="font-semibold">Ada {{ $errors->count() }} isian yang perlu diperbaiki:</p>
                        <ul class="mt-1 list-inside list-disc text-sm text-ink-muted">
                            @foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach
                        </ul>
                    </div>
                @endif
                @yield('content')
            </main>
        </div>
    </div>
    @stack('scripts')
</body>
</html>
