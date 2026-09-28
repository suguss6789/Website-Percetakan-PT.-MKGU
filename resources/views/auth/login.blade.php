<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex">
    <title>Masuk · Admin MKGU</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-paper">
    <div class="brand-bar"></div>
    <main class="grid min-h-[calc(100vh-6px)] place-items-center px-4 py-12">
        <div class="w-full max-w-sm">
            <a href="{{ route('home') }}" class="mb-10 block"><img src="{{ asset('assets/image/logo-transparan.png') }}" alt="MKGU" class="mx-auto h-14 w-auto"></a>
            <div class="crop-frame border border-ink/80 bg-white p-7">
                <span class="crop-b"></span>
                <p class="label-mono">Panel admin</p>
                <h1 class="mt-2 text-3xl font-bold">Masuk</h1>
                <form method="POST" action="{{ route('admin.login.submit') }}" class="mt-6 space-y-5">
                    @csrf
                    <div>
                        <label for="email" class="field-label">Email</label>
                        <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus autocomplete="username" class="field-input">
                        @error('email')<p class="field-error">{{ $message }}</p>@enderror
                    </div>
                    <div x-data="{ show: false }">
                        <label for="password" class="field-label">Password</label>
                        <div class="relative">
                            <input id="password" name="password" :type="show ? 'text' : 'password'" type="password" required autocomplete="current-password" class="field-input pr-12">
                            <button type="button" @click="show = !show" class="absolute right-2 top-1/2 inline-flex h-9 w-9 -translate-y-1/2 items-center justify-center text-ink-muted" :aria-label="show ? 'Sembunyikan password' : 'Tampilkan password'">
                                <x-icon name="eye" class="h-5 w-5" x-show="!show" /><x-icon name="eye-off" class="h-5 w-5" x-show="show" x-cloak />
                            </button>
                        </div>
                    </div>
                    <label class="flex items-center gap-2 text-sm text-ink-muted"><input type="checkbox" name="remember" class="h-4 w-4 accent-[#067A35]"> Ingat saya</label>
                    <button class="btn-primary w-full">Masuk</button>
                </form>
            </div>
            <p class="mt-6 text-center text-sm"><a href="{{ route('home') }}" class="text-ink-muted hover:text-ink">← Kembali ke website</a></p>
        </div>
    </main>
</body>
</html>
