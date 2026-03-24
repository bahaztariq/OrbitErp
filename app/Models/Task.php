<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    /** @use HasFactory<\Database\Factories\TaskFactory> */
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'priority',
        'parent_id',
        'status',
        'assigned_to',
        'start_date',
        'end_date',
        'company_id',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function parent()
    {
        return $this->belongsTo(Task::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Task::class, 'parent_id');
    }

    public function assignedTo()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
}
