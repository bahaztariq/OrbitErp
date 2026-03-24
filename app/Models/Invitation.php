<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invitation extends Model
{
    /** @use HasFactory<\Database\Factories\InvitationFactory> */
    use HasFactory;

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
