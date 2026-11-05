<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EquipmentController extends Controller
{
    /**
     * Halaman alat - katalog alat dengan filter kategori
     */
    public function index()
    {
        return view('pages.academy', ['initialView' => 'alat']);
    }
}
