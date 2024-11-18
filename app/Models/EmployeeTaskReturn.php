<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeTaskReturn extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_task_id',
        'description',
        'attachment',
        'return_date'
    ];
    public function getAttachmentAttribute($attachment)
    {
        return json_decode($attachment);
    }
}
