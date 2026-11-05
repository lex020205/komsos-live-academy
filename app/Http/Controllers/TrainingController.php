<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TrainingController extends Controller
{
    /**
     * Halaman latihan - simulator kabel, ATEM, kuis
     */
    public function index()
    {
        return view('pages.training');
    }
}
