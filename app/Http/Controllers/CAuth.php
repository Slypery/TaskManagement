<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CAuth extends Controller
{
    public function index()
    {
        return view('login', ['page_name' => 'Login']);
    }
    public function login(Request $request)
    {
        $userdata = User::getUserByUsernameOrEmail($request->usernameOrEmail);
        if ($userdata) {
            $credential = [
                'username' => $userdata->username,
                'password' => $request->password
            ];
            if (Auth::attempt($credential)) {
                switch ($userdata->role) {
                    case 'director':
                        return redirect()->route('director.dashboard');
                        break;
                    case 'manager':
                        return redirect()->route('manager.dashboard');
                        break;
                    case 'employee':
                        return redirect()->route('employee.dashboard');
                        break;
                    default:
                        break;
                }
            }
        }
        return back()->withErrors(['auth_error' => '*the provided credential does not match our record']);
    }
    public function logout(){
        Auth::logout();
    }
}
