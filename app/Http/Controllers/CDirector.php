<?php

namespace App\Http\Controllers;

use App\Models\ManagerTask;
use App\Models\ManagerTaskReturn;
use App\Models\User;
use Illuminate\Console\View\Components\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CDirector extends Controller
{
    public function dashboard()
    {
        return view('director_dashboard', [
            'page_name' => 'Dashboard'
        ]);
    }

    public function user_list()
    {
        return view('user_list', [
            'page_name' => 'User List',
            'user_list' => User::orderBy('id', 'desc')->get()
        ]);
    }
    public function store_user(Request $request)
    {
        $request->validate([
            'username' => 'required|min:3|max:50|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'role' => 'required|in:director,manager,employee',
            'password' => 'required|min:8'
        ]);
        User::create($request->all());
        return redirect()->route('director.user_list.index')->with('success', 'User succesfuly stored!');
    }
    public function update_user(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'email' => 'required|email',
            'role' => 'required'
        ]);
        $user = User::find($request->id);
        $user->update($request->all());
        return redirect()->route('director.user_list.index')->with('success', 'User succesfuly updated!');
    }
    public function destroy_user(Request $request)
    {
        User::destroy($request->id);
        return redirect()->route('director.user_list.index')->with('success', 'User succesfuly deleted!');
    }
    public function manager_task()
    {
        return view('director_manager_task', [
            'page_name' => 'Manager Task List',
            'manager_task' => ManagerTask::with('assigned_user', 'created_user')->orderBy('id', 'desc')->get()
        ]);
    }
    public function assign_task()
    {
        return view('director_assign_task', [
            'page_name' => 'Assign Task to Manager',
            'manager' => User::where('role', 'manager')->get()
        ]);
    }
    public function store_task(Request $request)
    {
        $request->merge(['created_by' => Auth::user()->id]);
        $request->validate([
            'created_by' => 'required|integer',
            'assigned_to' => 'required|integer',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'required|date',
        ]);

        $fileNames = [];
        if ($request->hasFile('attachment')) {
            foreach ($request->file('attachment') as $file) {
                $originalName = $file->getClientOriginalName();
                $fileInfo = pathinfo($originalName);
                $modifiedName = $fileInfo['filename'] . '_' . mt_rand(10000, 99999) . '.' . $fileInfo['extension'];

                $path = $file->storeAs('uploads', $modifiedName, 'public');

                $fileNames[] = $modifiedName;
            }
        }

        $data = $request->all();
        $data['attachment'] = json_encode($fileNames);
        $data['status'] = 'not viewed';
        ManagerTask::create($data);

        return redirect()->route('director.manager_task.index')->with('success', 'Task successfully added!');
    }
    public function edit_task($id)
    {
        $managerTask = ManagerTask::find($id);
        if(!$managerTask){
            return abort(404);
        }
        return view('director_edit_task', [
            'page_name' => 'Manager Task Detail',
            'task' => ManagerTask::find($id),
            'manager' => User::where('role', 'manager')->get()
        ]);
    }
    public function update_task(Request $request, ManagerTask $managertask)
    {
        $request->validate([
            'assigned_to' => 'required|integer',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'required|date',
        ]);

        $fileNames = (array) $managertask->attachment ?? [];
        foreach ($request->attachment_to_delete ?? [] as $item) {
            unset($fileNames[array_search($item, $fileNames)]);
            Storage::disk('public')->delete('uploads/'. $item);
        }
        if ($request->hasFile('attachment')) {
            foreach ($request->file('attachment') as $file) {
                $originalName = $file->getClientOriginalName();
                $fileInfo = pathinfo($originalName);
                $modifiedName = $fileInfo['filename'] . '_' . mt_rand(10000, 99999) . '.' . $fileInfo['extension'];

                $file->storeAs('uploads', $modifiedName, 'public');
                $fileNames[] = $modifiedName;
            }
        }

        $data = $request->except('attachment_to_delete');
        $data['attachment'] = json_encode($fileNames);
        $managertask->update($data);

        return redirect()->route('director.manager_task.index')->with('success', 'Task successfully updated!');
    }
    public function destroy_task(Request $request)
    {
        $managertask = ManagerTask::find($request->id);
        $files = $managertask->attachment ?? [];
        foreach ($files as $file) {
            Storage::disk('public')->delete('uploads/'. $file);
        }
        $managertask->delete();

        return redirect()->route('director.manager_task.index')->with('success', 'Task successfully deleted!');
    }
    public function return_task()
    {
        return view('manager_task_return', [
            'page_name' => 'Manager Task Return',
            'manager_task_return' => ManagerTaskReturn::with('mtask')->get()
        ]);
    }
    public function destroy_task_return(ManagerTaskReturn $managertaskreturn)
    {
        $managertaskreturn->delete();
        return redirect()->route('director.manager_task_return.index')->with('success', 'Task return successfully deleted!');
    }
}
