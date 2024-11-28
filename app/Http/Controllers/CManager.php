<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CManager extends Controller
{
    public function dashboard()
    {
        return view('dashboard', [
            'page_name' => 'Dashboard'
        ]);
    }
}
