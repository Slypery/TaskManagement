<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ManagerTask extends Model
{
    use HasFactory;

    protected $fillable = [
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
    public function assigned_user()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
    public function created_user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
