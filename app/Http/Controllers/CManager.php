<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ManagerTask;
use Illuminate\Support\Facades\Auth;

class CManager extends Controller
{
    public function dashboard()
    {
        return view('manager_dashboard', [
            'page_name' => 'Dashboard'
        ]);
    }
    public function task_list(){
        return view('manager_task_list', [
            'page_name' => 'Task List',
            'manager_task' => ManagerTask::with('assigned_user', 'created_user')->where('assigned_to', Auth::user()->id)->orderBy('id', 'desc')->get()
        ]);
    }
    public function task_detail($id){
        $managerTask = ManagerTask::with('assigned_user', 'created_user')->find($id);
        if(!$managerTask){
            return abort(404);
        }
        if($managerTask->assigned_to != Auth::user()->id){
            return abort(403);
        }
        $managerTask->update(['status' => 'viewed']);
        return view('manager_task_detail', [
            'page_name' => 'Task Detail',
            'manager_task' => $managerTask
        ]);
    }
}
