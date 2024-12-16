<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeSubmission extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_task_id',
        'title',
        'description',
        'attachment'
    ];
    public function getAttachmentAttribute($attachment)
    {
        return json_decode($attachment);
    }
    public function employee_task(){
        return $this->belongsTo(EmployeeTask::class, 'employee_task_id');
    }
}
