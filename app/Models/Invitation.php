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
        'status',
        'sent_at',
        'responded_at',
        'expired_at',
    ];

    protected $casts = [
        'sent_at' => 'datetime',
        'responded_at' => 'datetime',
        'expired_at' => 'datetime',
    ];

    /**
     * Check if the invitation has expired.
     */
    public function isExpired()
    {
        return $this->expired_at && $this->expired_at->isPast();
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
