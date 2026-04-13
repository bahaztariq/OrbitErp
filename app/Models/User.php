<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function memberships()
    {
        return $this->hasMany(Membership::class);
    }

    public function roleInCompany(Company $company)
    {
        return $this->memberships()
            ->where('company_id', $company->id)
            ->first()?->role;
    }

    public function hasPermission(string $permission, $company = null): bool
    {
        // Try to get company from route if not provided
        $company = $company ?? request()->route('company');

        if (!$company) {
            return false;
        }
        

        if (is_string($company)) {
            $company = Company::where('slug', $company)->first();
        }

        if (!$company instanceof Company) {
            return false;
        }

        $role = $this->roleInCompany($company);
        
        return $role?->permissions()->where('name', $permission)->exists() ?? false;
    }

    public function companies()
    {
        return $this->belongsToMany(Company::class, 'membership', 'user_id', 'company_id');
    }

    public function conversations()
    {
        return $this->belongsToMany(Conversation::class, 'conversation_participants', 'user_id', 'conversation_id');
    }

    public function trashedCompanies()
    {
        return $this->companies()->onlyTrashed()->get();
    }

    public function messages()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }
}
