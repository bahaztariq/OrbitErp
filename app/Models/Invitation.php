<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class Invitation extends Model
{
    /** @use HasFactory<\Database\Factories\InvitationFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'email',
        'token',
        'company_id',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
