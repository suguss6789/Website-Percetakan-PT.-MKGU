@php
    $siteName = setting('company_name', 'Multi Karya Grafika Utama');
    $pageTitle = trim($__env->yieldContent('title'));
    $fullTitle = $pageTitle ? "{$pageTitle} — {$siteName}" : "{$siteName} · Percetakan di Jakarta Timur";
    $metaDescription = trim($__env->yieldContent('description')) ?: setting('tagline');
    $ogImage = trim($__env->yieldContent('og_image')) ?: asset('assets/image/logo_bg.png');
    $nav = [
        ['home', 'Beranda'],
        ['about', 'Tentang'],
        ['services', 'Layanan'],
        ['products.index', 'Produk'],
        ['contact', 'Kontak'],
    ];
    $isActive = fn ($route) => request()->routeIs($route) || ($route === 'products.index' && request()->routeIs('products.*'));
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $fullTitle }}</title>
    <meta name="description" content="{{ \Illuminate\Support\Str::limit($metaDescription, 160) }}">
    <link rel="canonical" href="{{ url()->current() }}">
    <meta name="theme-color" content="#067A35">

    <meta property="og:type" content="website">
    <meta property="og:site_name" content="{{ $siteName }}">
    <meta property="og:title" content="{{ $fullTitle }}">
    <meta property="og:description" content="{{ \Illuminate\Support\Str::limit($metaDescription, 160) }}">
    <meta property="og:image" content="{{ $ogImage }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:locale" content="id_ID">

    <link rel="icon" href="{{ asset('favicon.ico') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('head')
</head>
<body class="flex min-h-screen flex-col">
    <a href="#konten" class="sr-only focus:not-sr-only focus:fixed focus:left-4 focus:top-4 focus:z-[60] focus:bg-brand-yellow focus:px-4 focus:py-2 focus:font-semibold">Lewati ke konten</a>

    {{-- Strip info ala job ticket --}}
    <div class="hidden border-b border-line bg-paper-dark lg:block">
        <div class="container-page flex h-9 items-center justify-between gap-6 whitespace-nowrap font-mono text-[0.6875rem] uppercase tracking-[0.12em] text-ink-muted">
            <span class="flex items-center gap-2"><x-icon name="map-pin" class="h-3.5 w-3.5" /> {{ \Illuminate\Support\Str::before(setting('address', ''), ',') }}, Jakarta Timur</span>
            <span class="flex items-center gap-5">
                <span class="flex items-center gap-2"><x-icon name="clock" class="h-3.5 w-3.5" /> {{ setting('hours_weekday') }}</span>
                <a href="mailto:{{ setting('email') }}" class="hover:text-ink">{{ setting('email') }}</a>
            </span>
        </div>
    </div>

    <header data-header x-data="{ open: false }" @keydown.escape.window="open = false"
        class="group sticky top-0 z-40 border-b border-transparent bg-paper transition-colors data-[scrolled]:border-line">
        <div class="container-page flex h-[76px] items-center justify-between gap-6 transition-all group-data-[scrolled]:h-16">
            <a href="{{ route('home') }}" class="shrink-0" aria-label="{{ $siteName }} — beranda">
                <img src="{{ asset('assets/image/logo-transparan.png') }}" alt="{{ $siteName }}" width="274" height="108" class="h-11 w-auto transition-all group-data-[scrolled]:h-9">
            </a>

            <nav class="hidden items-center gap-8 lg:flex" aria-label="Menu utama">
                @foreach ($nav as [$route, $label])
                    <a href="{{ route($route) }}" @class([
                        'relative py-1 text-[0.9375rem] font-semibold transition-colors',
                        'text-ink after:absolute after:inset-x-0 after:-bottom-0.5 after:h-[3px] after:bg-brand-yellow' => $isActive($route),
                        'text-ink-muted hover:text-ink' => ! $isActive($route),
                    ]) @if($isActive($route)) aria-current="page" @endif>{{ $label }}</a>
                @endforeach
            </nav>

            <div class="flex items-center gap-2">
                <a href="{{ wa_link('Halo MKGU, saya ingin konsultasi cetak.') }}" target="_blank" rel="noopener" class="btn-primary hidden sm:inline-flex">
                    <x-icon name="whatsapp" class="h-4 w-4" /> Hubungi Kami
                </a>
                <button type="button" class="inline-flex h-11 w-11 items-center justify-center rounded border border-line lg:hidden" @click="open = true" aria-label="Buka menu" :aria-expanded="open">
                    <x-icon name="menu" />
                </button>
            </div>
        </div>

        {{-- Menu HP: layar penuh --}}
        <div x-cloak x-show="open" x-transition.opacity class="fixed inset-0 z-50 flex flex-col bg-paper lg:hidden" role="dialog" aria-modal="true" aria-label="Menu">
            <div class="brand-bar"></div>
            <div class="container-page flex h-[76px] items-center justify-between">
                <img src="{{ asset('assets/image/logo-transparan.png') }}" alt="" class="h-10 w-auto">
                <button type="button" class="inline-flex h-11 w-11 items-center justify-center rounded border border-line" @click="open = false" aria-label="Tutup menu">
                    <x-icon name="x" />
                </button>
            </div>
            <nav class="container-page mt-4 flex flex-1 flex-col" aria-label="Menu utama">
                @foreach ($nav as $i => [$route, $label])
                    <a href="{{ route($route) }}" class="flex items-baseline gap-4 border-b border-line py-4">
                        <span class="font-mono text-xs text-ink-soft">0{{ $i + 1 }}</span>
                        <span @class(['font-display text-[clamp(2rem,1.4rem+4vw,2.75rem)] font-bold', 'text-brand-green-deep' => $isActive($route)])>{{ $label }}</span>
                    </a>
                @endforeach
            </nav>
            <div class="container-page pb-8 pt-6">
                <a href="{{ wa_link('Halo MKGU, saya ingin konsultasi cetak.') }}" target="_blank" rel="noopener" class="btn-wa w-full">
                    <x-icon name="whatsapp" class="h-5 w-5" /> Chat WhatsApp · {{ wa_display() }}
                </a>
            </div>
        </div>
    </header>

    <main id="konten" class="flex-1">
        @yield('content')
    </main>

    <footer class="mt-auto bg-ink text-paper">
        <div class="brand-bar"></div>
        <div class="container-page grid gap-12 py-16 md:grid-cols-12">
            <div class="md:col-span-5">
                <div class="inline-block rounded bg-paper p-3">
                    <img src="{{ asset('assets/image/logo-transparan.png') }}" alt="{{ $siteName }}" class="h-12 w-auto" loading="lazy">
                </div>
                <p class="mt-6 max-w-sm text-[0.9375rem] leading-relaxed text-paper/70">{{ setting('tagline') }}</p>
                <p class="mt-4 font-mono text-[0.6875rem] uppercase tracking-[0.14em] text-paper/50">Member of {{ setting('company_parent', 'PT. Mulia Idola Utama') }}</p>
            </div>

            <div class="md:col-span-3">
                <h2 class="font-mono text-[0.6875rem] font-medium uppercase tracking-[0.14em] text-brand-yellow">Produk</h2>
                <ul class="mt-4 space-y-2.5 text-[0.9375rem]">
                    @foreach ($footerCategories as $cat)
                        <li><a href="{{ route('products.index', ['kategori' => $cat->slug]) }}" class="text-paper/80 hover:text-white hover:underline">{{ $cat->name }}</a></li>
                    @endforeach
                    <li><a href="{{ route('products.index') }}" class="text-paper/80 hover:text-white hover:underline">Semua produk</a></li>
                </ul>
            </div>

            <div class="md:col-span-4">
                <h2 class="font-mono text-[0.6875rem] font-medium uppercase tracking-[0.14em] text-brand-yellow">Kontak</h2>
                <ul class="mt-4 space-y-3 text-[0.9375rem] text-paper/80">
                    <li class="flex gap-3"><x-icon name="map-pin" class="mt-0.5 h-4 w-4 shrink-0 text-paper/50" /><a href="{{ setting('maps_link', '#') }}" target="_blank" rel="noopener" class="hover:text-white">{{ setting('address') }}</a></li>
                    <li class="flex gap-3"><x-icon name="whatsapp" class="mt-0.5 h-4 w-4 shrink-0 text-paper/50" /><a href="{{ wa_link() }}" target="_blank" rel="noopener" class="hover:text-white">{{ wa_display() }}</a></li>
                    <li class="flex gap-3"><x-icon name="mail" class="mt-0.5 h-4 w-4 shrink-0 text-paper/50" /><a href="mailto:{{ setting('email') }}" class="hover:text-white">{{ setting('email') }}</a></li>
                    <li class="flex gap-3"><x-icon name="clock" class="mt-0.5 h-4 w-4 shrink-0 text-paper/50" /><span>{{ setting('hours_weekday') }}<br>{{ setting('hours_saturday') }}</span></li>
                </ul>
                @php $socials = array_filter(['instagram' => setting('instagram'), 'facebook' => setting('facebook'), 'music' => setting('tiktok')]); @endphp
                @if ($socials)
                    <div class="mt-5 flex gap-2">
                        @foreach ($socials as $icon => $url)
                            <a href="{{ $url }}" target="_blank" rel="noopener" class="inline-flex h-10 w-10 items-center justify-center rounded border border-paper/20 hover:border-paper/60" aria-label="{{ $icon === 'music' ? 'TikTok' : ucfirst($icon) }}"><x-icon :name="$icon" class="h-4 w-4" /></a>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
        <div class="border-t border-paper/10">
            <div class="container-page flex flex-col gap-2 py-5 text-xs text-paper/50 sm:flex-row sm:items-center sm:justify-between">
                <span>© {{ date('Y') }} {{ $siteName }}. Hak cipta dilindungi.</span>
                <span class="font-mono uppercase tracking-[0.12em]">Dicetak dengan teliti di Jakarta Timur</span>
            </div>
        </div>
    </footer>

    {{-- Tombol WhatsApp melayang --}}
    <a href="{{ wa_link('Halo MKGU, saya ingin konsultasi cetak.') }}" target="_blank" rel="noopener"
        class="fixed bottom-5 right-5 z-30 inline-flex h-14 items-center gap-2 rounded-full bg-brand-orange px-4 text-ink shadow-[0_6px_20px_-6px_rgba(27,31,26,.45)] transition hover:-translate-y-0.5 sm:px-5"
        aria-label="Chat WhatsApp">
        <x-icon name="whatsapp" class="h-6 w-6" />
        <span class="hidden text-[0.9375rem] font-semibold sm:inline">Chat</span>
    </a>

    @stack('scripts')
</body>
</html>
