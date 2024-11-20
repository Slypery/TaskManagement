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

    public function user_list()
    {
        return view('user_list', [
            'page_name' => 'User List',
            'user_list' => User::get()
        ]);
    }
    public function store_user(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'email' => 'required|email',
            'role' => 'required',
            'password' => 'required'
        ]);
        User::create($request->all());
        return redirect()->route('director.user_list.index');
    }
    public function update_user(Request $request, User $user)
    {
        $request->validate([
            'username' => 'required',
            'email' => 'required|email',
            'role' => 'required'
        ]);
        $user->update($request->all());
        return redirect()->route('director.user_list.index');
    }
    public function destroy_user(Request $request, User $user)
    {
        $user->delete();
        return redirect()->route('director.user_list.index');
    }
}
