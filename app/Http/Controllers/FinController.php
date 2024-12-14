<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FinController extends Controller
{
    public function index()
    {
        return view('home');
    }
}
