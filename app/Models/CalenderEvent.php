<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CalenderEvent extends Model
{
    /** @use HasFactory<\Database\Factories\CalenderEventFactory> */
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'start_date',
        'end_date',
        'company_id',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
