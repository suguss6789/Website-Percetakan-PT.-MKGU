<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public const RULES = [
        'company_name' => ['required', 'string', 'max:100'],
        'company_parent' => ['nullable', 'string', 'max:100'],
        'tagline' => ['nullable', 'string', 'max:200'],
        'about_short' => ['nullable', 'string', 'max:600'],
        'about_full' => ['nullable', 'string', 'max:5000'],
        'vision' => ['nullable', 'string', 'max:500'],
        'mission' => ['nullable', 'string', 'max:1500'],
        'founded_year' => ['nullable', 'digits:4'],
        'address' => ['required', 'string', 'max:255'],
        'maps_embed_url' => ['nullable', 'url', 'max:1000'],
        'maps_link' => ['nullable', 'url', 'max:500'],
        'whatsapp' => ['required', 'regex:/^[0-9+\-\s]{9,20}$/'],
        'phone' => ['nullable', 'string', 'max:30'],
        'email' => ['required', 'email', 'max:100'],
        'hours_weekday' => ['nullable', 'string', 'max:60'],
        'hours_saturday' => ['nullable', 'string', 'max:60'],
        'instagram' => ['nullable', 'url', 'max:200'],
        'facebook' => ['nullable', 'url', 'max:200'],
        'tiktok' => ['nullable', 'url', 'max:200'],
    ];

    public function edit()
    {
        return view('admin.settings.edit', ['s' => Setting::all_cached()]);
    }

    public function update(Request $request)
    {
        $data = $request->validate(self::RULES, [
            'whatsapp.regex' => 'Nomor WhatsApp hanya boleh berisi angka, contoh 081234567890.',
        ]);

        // Jika yang ditempel adalah kode <iframe> utuh, ambil src-nya saja.
        if ($request->filled('maps_embed_raw') && preg_match('/src="([^"]+)"/', $request->input('maps_embed_raw'), $m)) {
            $data['maps_embed_url'] = html_entity_decode($m[1]);
        }

        $number = preg_replace('/\D/', '', $data['whatsapp']);
        $data['whatsapp'] = str_starts_with($number, '0') ? '62' . substr($number, 1) : $number;

        Setting::putMany($data);

        return back()->with('status', 'Profil & kontak tersimpan. Perubahan langsung tampil di website.');
    }
}
