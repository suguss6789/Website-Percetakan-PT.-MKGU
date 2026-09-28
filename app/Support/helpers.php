<?php

use App\Models\Setting;

if (! function_exists('rupiah')) {
    function rupiah(?int $amount): string
    {
        return 'Rp' . number_format((int) $amount, 0, ',', '.');
    }
}

if (! function_exists('setting')) {
    function setting(string $key, ?string $default = null): ?string
    {
        return Setting::get($key, $default);
    }
}

if (! function_exists('wa_number')) {
    function wa_number(): string
    {
        $number = preg_replace('/\D/', '', (string) setting('whatsapp', '6281297279919'));

        return str_starts_with($number, '0') ? '62' . substr($number, 1) : $number;
    }
}

if (! function_exists('wa_link')) {
    function wa_link(?string $message = null): string
    {
        $url = 'https://wa.me/' . wa_number();

        return $message ? $url . '?text=' . rawurlencode($message) : $url;
    }
}

if (! function_exists('wa_display')) {
    /** 6281297279919 → 0812-9727-9919 */
    function wa_display(): string
    {
        $local = '0' . substr(wa_number(), 2);

        return trim(chunk_split($local, 4, '-'), '-');
    }
}

if (! function_exists('thumb_path')) {
    function thumb_path(string $path): string
    {
        $info = pathinfo($path);

        return ($info['dirname'] !== '.' ? $info['dirname'] . '/' : '') . 'thumbs/' . $info['basename'];
    }
}
