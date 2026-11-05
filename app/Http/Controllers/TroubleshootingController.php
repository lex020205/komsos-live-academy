<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TroubleshootingController extends Controller
{
    /**
     * Halaman bantuan - troubleshooting dengan filter tag
     */
    public function index()
    {
        return view('pages.academy', ['initialView' => 'bantuan']);
    }
}
