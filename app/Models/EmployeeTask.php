<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeTask extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'manager_task_id',
        'created_by',
        'assigned_to',
        'title',
        'description',
        'attachment',
        'due_date',
        'status',
    ];
    public function getAttachmentAttribute($attachment)
    {
        return json_decode($attachment);
    }
}
