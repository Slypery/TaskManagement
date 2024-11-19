<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class CDirector extends Controller
{
    public function dashboard()
    {
        return view('dashboard', [
            'page_name' => 'Dashboard'
        ]);
    }

    public function user_list() {
        return view('user_list', [
            'page_name' => 'User List',
            'user_list' => User::get()
        ]);
    }
    public function store_user(Request $request) {}
    public function update_user(Request $request) {}
    public function destroy_user(Request $request) {}
}
