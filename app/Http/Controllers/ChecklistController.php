<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ChecklistController extends Controller
{
    /**
     * Halaman hari-h - checklist pelaksanaan
     */
    public function index()
    {
        return view('pages.academy', ['initialView' => 'hari-h']);
    }
}
