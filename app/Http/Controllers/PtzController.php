<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PtzController extends Controller
{
    /**
     * Halaman PTZ - simulator kamera PTZ
     */
    public function index()
    {
        return view('pages.ptz');
    }
}
