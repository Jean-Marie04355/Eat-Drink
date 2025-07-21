<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EntrepreneurController extends Controller
{
     public function dashboard()
    {
        return view('entrepreneur.dashboard');
    }
}
