<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ManagerTaskReturn extends Model
{
    use HasFactory;

    protected $fillable = [
        'manager_task_id',
        'description',
        'attachment',
        'return_date'
    ];
    
    public function getAttachmentAttribute($attachment)
    {
        return json_decode($attachment);
    }
    public function mtask()
    {
        return $this->belongsTo(ManagerTask::class, 'manager_task_id');
    }
}
