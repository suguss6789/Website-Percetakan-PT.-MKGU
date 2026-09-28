@extends('layouts.admin')
@section('title', 'Profil & Kontak')
@section('crumb', 'Profil & Kontak')

@php
    $v = fn ($k) => old($k, $s[$k] ?? '');
    $groups = [
        'Identitas perusahaan' => [
            ['company_name', 'Nama usaha *', 'text'], ['company_parent', 'Induk perusahaan', 'text'],
            ['tagline', 'Tagline', 'text', 'Tampil di footer dan sebagai deskripsi Google.'], ['founded_year', 'Tahun berdiri', 'text', 'Kosongkan jika tidak ingin ditampilkan.'],
        ],
        'Tentang kami' => [
            ['about_short', 'Profil singkat (beranda)', 'textarea', null, 3], ['about_full', 'Profil lengkap (halaman Tentang)', 'textarea', 'Pisahkan paragraf dengan baris kosong.', 7],
            ['vision', 'Visi', 'textarea', null, 2], ['mission', 'Misi', 'textarea', 'Satu poin per baris.', 4],
        ],
        'Kontak & lokasi' => [
            ['whatsapp', 'Nomor WhatsApp *', 'text', 'Contoh: 081297279919. Dipakai di semua tombol WhatsApp.'], ['phone', 'Telepon', 'text'],
            ['email', 'Email *', 'email'], ['address', 'Alamat lengkap *', 'text'],
            ['maps_link', 'Link Google Maps (petunjuk arah)', 'url', 'Buka Google Maps → Bagikan → Salin link.'],
            ['maps_embed_url', 'Link embed peta', 'url', 'Google Maps → Bagikan → Sematkan peta → salin isi src="…". Atau tempel kode iframe utuh di kolom di bawahnya.'],
        ],
        'Jam operasional' => [['hours_weekday', 'Hari kerja', 'text'], ['hours_saturday', 'Sabtu', 'text']],
        'Media sosial' => [['instagram', 'Instagram', 'url'], ['facebook', 'Facebook', 'url'], ['tiktok', 'TikTok', 'url']],
    ];
@endphp

@section('content')
    <h1 class="text-3xl font-bold">Profil & kontak</h1>
    <p class="mt-1 text-ink-muted">Semua informasi di halaman ini langsung tampil di website setelah disimpan.</p>

    <form method="POST" action="{{ route('admin.settings.update') }}" class="mt-8 max-w-4xl space-y-6">
        @csrf @method('PUT')
        @foreach ($groups as $title => $fields)
            <section class="border border-line bg-white p-6">
                <h2 class="text-xl font-bold">{{ $title }}</h2>
                <div class="mt-5 grid gap-5 sm:grid-cols-2">
                    @foreach ($fields as $f)
                        @php [$key, $label, $type] = $f; $help = $f[3] ?? null; $rows = $f[4] ?? 3; @endphp
                        <div @class(['sm:col-span-2' => $type === 'textarea' || in_array($key, ['address', 'maps_embed_url', 'maps_link'])])>
                            <label class="field-label" for="{{ $key }}">{{ $label }}</label>
                            @if ($type === 'textarea')
                                <textarea id="{{ $key }}" name="{{ $key }}" rows="{{ $rows }}" class="field-input">{{ $v($key) }}</textarea>
                            @else
                                <input id="{{ $key }}" name="{{ $key }}" type="{{ $type }}" value="{{ $key === 'whatsapp' && $v($key) ? '0' . substr($v($key), 2) : $v($key) }}" class="field-input">
                            @endif
                            @error($key)<p class="field-error">{{ $message }}</p>@enderror
                            @if ($help)<p class="field-help">{{ $help }}</p>@endif
                            @if ($key === 'maps_embed_url')
                                <textarea name="maps_embed_raw" rows="2" class="field-input mt-2 font-mono text-xs" placeholder='Opsional: tempel kode <iframe src="…"></iframe> di sini'></textarea>
                            @endif
                        </div>
                    @endforeach
                </div>
            </section>
        @endforeach
        <div class="sticky bottom-0 -mx-4 border-t border-line bg-paper/95 px-4 py-4 backdrop-blur sm:mx-0 sm:px-0">
            <button class="btn-primary">Simpan profil & kontak</button>
        </div>
    </form>
@endsection
