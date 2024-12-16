<?php

namespace App\Http\Controllers;

use App\Models\EmployeeSubmission;
use App\Models\EmployeeTask;
use App\Models\ManagerSubmission;
use Illuminate\Http\Request;
use App\Models\ManagerTask;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CManager extends Controller
{
    public function dashboard()
    {
        return view('manager_dashboard', [
            'page_name' => 'Dashboard'
        ]);
    }
    public function task_list()
    {
        return view('manager_task_list', [
            'page_name' => 'Assignments',
            'manager_task' => ManagerTask::with(['created_user:id,username', 'employee_task:id,manager_task_id', 'employee_task.employee_submission:id,employee_task_id'])->where('assigned_to', Auth::user()->id)->orderBy('id', 'desc')->get()
        ]);
    }
    public function task_detail($id)
    {
        $managerTask = ManagerTask::with(['assigned_user:id,username', 'manager_submission'])->find($id);
        if (!$managerTask) {
            return abort(404);
        }
        if ($managerTask->assigned_to != Auth::user()->id) {
            return abort(403);
        }
        if ($managerTask->status == 'not viewed') {
            $managerTask->update(['status' => 'viewed']);
        }
        session(['manager_task_origin' => $managerTask]);
        return view('manager_task_detail', [
            'page_name' => 'Assignment Detail',
            'manager_task' => $managerTask,
            'employee_task_min' => EmployeeTask::with('assigned_user:id,username')->where('manager_task_id', $id)->select('id', 'title', 'assigned_to', 'status')->get(),
            'employee_submissions_min' => EmployeeSubmission::with(['employee_task:id,assigned_to', 'employee_task.assigned_user:id,username'])->get()
        ]);
    }
    public function forward_task($manager_task_id)
    {
        if ($manager_task_id != session('manager_task_origin')->id) {
            return abort(403);
        }
        if (session('manager_task_origin')->status == 'viewed') {
            session('manager_task_origin')->update(['status' => 'in progress']);
        }
        return view('manager_forward_task', [
            'page_name' => 'Forward Assignment',
            'task_origin' => session('manager_task_origin'),
            'employee' => User::where('role', 'employee')->get()
        ]);
    }
    public function store_task(Request $request)
    {
        if ($request->manager_task_id != session('manager_task_origin')->id) {
            return abort(403);
        }
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

                $file->storeAs('uploads', $modifiedName, 'public');

                $fileNames[] = $modifiedName;
            }
        }

        $data = $request->all();
        $data['attachment'] = json_encode($fileNames);
        $data['status'] = 'not viewed';
        EmployeeTask::create($data);
        return redirect()->route('manager.task_list.detail', $request->manager_task_id)->with('success', 'Assignment successfully Forwarded!');
    }
    public function edit_task($id)
    {
        $employeeTask = EmployeeTask::find($id);
        if (!$employeeTask) {
            return abort(404);
        }
        if ($employeeTask->created_by != Auth::user()->id) {
            return abort(403);
        }
        return view('manager_edit_task', [
            'page_name' => 'Edit Forwarded Assignment',
            'task_origin' => session('manager_task_origin'),
            'employee_task' => $employeeTask,
            'employee' => User::where('role', 'employee')->get()
        ]);
    }
    public function update_task(Request $request, $employeeTaskId)
    {
        $employeeTask = EmployeeTask::find($employeeTaskId);
        $request->validate([
            'assigned_to' => 'required|integer',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'required|date',
        ]);

        $fileNames = (array) $employeeTask->attachment ?? [];
        foreach ($request->attachment_to_delete ?? [] as $item) {
            unset($fileNames[array_search($item, $fileNames)]);
            Storage::disk('public')->delete('uploads/' . $item);
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
        $employeeTask->update($data);

        return redirect()->route('manager.task_list.detail', $employeeTask->manager_task_id)->with('success', 'Forwarded Assignment successfully updated!');
    }
    public function destroy_task($id, $managerTaskId)
    {
        EmployeeTask::destroy($id);
        return redirect()->route('manager.task_list.detail', $managerTaskId)->with('success', 'Forwarded Assignment successfully deleted!');
    }
    public function employee_submission_detail($id)
    {
        $employeeSubmissions = EmployeeSubmission::where('employee_task_id', $id)->with([
            'employee_task' => function ($query) {
                $query->select('id', 'assigned_to', 'created_by', 'manager_task_id');
            },
            'employee_task.assigned_user' => function ($query) {
                $query->select('id', 'username');
            }
        ])->first();

        $task_origin = EmployeeTask::find($id);
        if (!$task_origin) {
            return abort(404);
        }
        if ($task_origin->created_by != Auth::user()->id) {
            return abort(403);
        }

        return view('manager_employee_submission_detail', [
            'page_name' => 'Employee Submission Detail',
            'employee_submission' => $employeeSubmissions,
            'task_origin' => $task_origin
        ]);
    }
    public function create_submission($manager_task_id)
    {
        if (session('manager_task_origin')->id != $manager_task_id) {
            return abort(403);
        }
        return view('manager_create_submission', [
            'page_name' => 'Make Submission',
            'task_origin' => session('manager_task_origin'),
            'employee_submissions' => EmployeeSubmission::with(['employee_task:id,manager_task_id,assigned_to', 'employee_task.assigned_user:id,username'])->whereHas('employee_task', function ($query) {
                $query->where('manager_task_id', session('manager_task_origin')->id);
            })->get()
        ]);
    }
    public function store_submission(Request $request)
    {
        if (session('manager_task_origin')->id != $request->manager_task_id) {
            return abort(403);
        }
        session('manager_task_origin')->update(['status' => 'done']);
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);
        $fileNames = [];
        if ($request->hasFile('attachment')) {
            foreach ($request->file('attachment') as $file) {
                $originalName = $file->getClientOriginalName();
                $fileInfo = pathinfo($originalName);
                $modifiedName = $fileInfo['filename'] . '_' . mt_rand(10000, 99999) . '.' . $fileInfo['extension'];

                $file->storeAs('uploads', $modifiedName, 'public');

                $fileNames[] = $modifiedName;
            }
        }

        $data = $request->all();
        $data['attachment'] = json_encode($fileNames);
        ManagerSubmission::create($data);
        return redirect()->route('manager.task_list.detail', $request->manager_task_id)->with('success', 'Submission Successfull!');
    }
    public function submission_detail($manager_submission_id)
    {
        if (session('manager_task_origin')->manager_submission->id != $manager_submission_id) {
            return abort(403);
        }
        return view('manager_submission_detail', [
            'page_name' => 'Submission Detail',
            'task_origin' => session('manager_task_origin'),
            'employee_submissions' => EmployeeSubmission::with(['employee_task:id,manager_task_id,assigned_to', 'employee_task.assigned_user:id,username'])->whereHas('employee_task', function ($query) {
                $query->where('manager_task_id', session('manager_task_origin')->id);
            })->get()
        ]);
    }
    public function update_submission(Request $request)
    {
        if ($request->manager_submission_id != session('manager_task_origin')->manager_submission->id) {
            return abort(403);
        }
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);
        $fileNames = (array) session('manager_task_origin')->manager_submission->attachment ?? [];
        foreach ($request->attachment_to_delete ?? [] as $item) {
            unset($fileNames[array_search($item, $fileNames)]);
            Storage::disk('public')->delete('uploads/' . $item);
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
        session('manager_task_origin')->manager_submission->update($data);
        return redirect()->route('manager.task_list.detail', session('manager_task_origin')->id)->with('success', 'Submission successfully updated!');
    }
}
