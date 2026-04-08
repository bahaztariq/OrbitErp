<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class CalenderEvent extends Model
{
    /** @use HasFactory<\Database\Factories\CalenderEventFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'event_date',
        'company_id',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
