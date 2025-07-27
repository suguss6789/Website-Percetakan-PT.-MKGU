<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     * Menampilkan halaman layanan.
     */
    public function layanan()
    {
        return view('pages.layanan');
    }

    /**
     * Menampilkan halaman tentang kami.
     * (Jika Anda ingin membuatnya nanti)
     */
    public function tentang()
    {
        return view('pages.tentang');
    }
}