<?php

namespace App\Http\Controllers;

use App\Models\EmployeeTask;
use App\Models\EmployeeTaskReturn;
use App\Models\ManagerTask;
use App\Models\ManagerTaskReturn;
use App\Models\User;
use Illuminate\Http\Request;

class Tes extends Controller
{
    public function index(){
        dump(User::get()->toArray());
        dump(ManagerTask::get()->toArray());
        dump(ManagerTaskReturn::get()->toArray());
        dump(EmployeeTask::get()->toArray());
        dump(EmployeeTaskReturn::get()->toArray());
    }
    //
}
