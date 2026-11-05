<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Halaman beranda - landing page aplikasi
     */
    public function index()
    {
        return view('pages.academy', ['initialView' => 'beranda']);
    }
}
