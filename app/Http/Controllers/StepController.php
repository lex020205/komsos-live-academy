<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StepController extends Controller
{
    /**
     * Halaman langkah - wizard 12 langkah SOP
     */
    public function index()
    {
        return view('pages.steps');
    }
}
