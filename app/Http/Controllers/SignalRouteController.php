<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SignalRouteController extends Controller
{
    /**
     * Halaman alur sinyal - pilih rute koneksi
     */
    public function index()
    {
        return view('pages.academy', ['initialView' => 'alur-sinyal']);
    }
}
