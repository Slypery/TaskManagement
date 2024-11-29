<?php

namespace App\Http\Controllers;

use App\Models\ManagerTask;
use App\Models\User;
use Illuminate\Http\Request;

class CDirector extends Controller
{
    public function dashboard()
    {
        return view('Dashboard', [
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
        return view('manager_task', [
            'page_name' => 'Manager Task List',
            'manager_task' => ManagerTask::with('assigned_user', 'created_user')->orderBy('id', 'desc')->get()
        ]);
    }
    public function assign_task()
    {
        return view('assign_task', [
            'page_name' => 'Assign Task to Manager',
            'manager' => User::where('role', 'manager')->get()
        ]);
    }
    public function store_task(Request $request)
    {
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
        return view('edit_task', [
            'page_name' => 'Manager Task',
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

        $fileNames = $managertask->attachment ?? [];
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
        $managertask->update($data);

        return redirect()->route('director.manager_task.index')->with('success', 'Task successfully updated!');
    }
    public function destroy_task(Request $request)
    {
        $managertask = ManagerTask::find($request->id);
        $files = $managertask->attachment ?? [];
        foreach ($files as $file) {
            $filePath = storage_path(path: 'app/public/uploads/' . $file);
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }
        $managertask->delete();

        return redirect()->route('director.manager_task.index')->with('success', 'Task successfully deleted!');
    }
}
