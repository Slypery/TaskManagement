<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ManagerSubmission extends Model
{
    use HasFactory;

    protected $fillable = [
        'manager_task_id',
        'title',
        'description',
        'attachment'
    ];
    
    public function getAttachmentAttribute($attachment)
    {
        return json_decode($attachment);
    }
    public function manager_task()
    {
        return $this->belongsTo(ManagerTask::class, 'manager_task_id');
    }
}
