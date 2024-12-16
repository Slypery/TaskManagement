<?php

namespace App\Http\Controllers;

use App\Models\EmployeeSubmission;
use App\Models\EmployeeTask;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CEmployee extends Controller
{
    public function dashboard()
    {
        return view('employee_dashboard', [
            'page_name' => 'Dashboard'
        ]);
    }
    public function task_list()
    {
        return view('employee_task_list', [
            'page_name' => 'Assignments',
            'employee_task' => EmployeeTask::where('assigned_to', Auth::user()->id)->with('created_user:id,username')->get()
        ]);
    }
    public function task_detail($id)
    {
        $employee_task = EmployeeTask::with('employee_submission')->find($id);
        if (!$employee_task) {
            return abort(404);
        }
        if ($employee_task->assigned_to != Auth::user()->id) {
            return abort(403);
        }
        if ($employee_task->status == 'not viewed') {
            $employee_task->update(['status' => 'viewed']);
        }
        session(['employee_task_origin' => $employee_task]);
        return view('employee_task_detail', [
            'page_name' => 'Assignment Detail',
            'employee_task' => $employee_task
        ]);
    }
    public function create_submission($employee_task_id)
    {
        if (session('employee_task_origin')->id != $employee_task_id) {
            return abort(403);
        }
        session('employee_task_origin')->update(['status' => 'in progress']);
        return view('employee_create_submission', [
            'page_name' => 'Make Submission',
            'task_origin' => session('employee_task_origin')
        ]);
    }
    public function store_submission(Request $request)
    {
        if (session('employee_task_origin')->id != $request->employee_task_id) {
            return abort(403);
        }
        session('employee_task_origin')->update(['status' => 'done']);
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
        EmployeeSubmission::create($data);
        return redirect()->route('employee.task_list.detail', $request->employee_task_id)->with('success', 'Submission Successfull!');
    }
    public function submission_detail($employee_submission_id)
    {
        if (session('employee_task_origin')->employee_submission->id != $employee_submission_id) {
            return abort(403);
        }
        return view('employee_submission_detail', [
            'page_name' => 'Submission Detail',
            'task_origin' => session('employee_task_origin')
        ]);
    }
    public function update_submission(Request $request, $employee_submission_id)
    {
        if ($employee_submission_id != session('employee_task_origin')->employee_submission->id) {
            return abort(403);
        }
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);
        $fileNames = (array) session('employee_task_origin')->employee_submission->attachment ?? [];
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
        session('employee_task_origin')->employee_submission->update($data);
        return redirect()->route('employee.task_list.detail', session('employee_task_origin')->id)->with('success', 'Submission successfully updated!');
    }
}
