<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    /** @use HasFactory<\Database\Factories\CompanyFactory> */
    use HasFactory, SoftDeletes;
    protected $guarded = [];

    public function users()
    {
        return $this->belongsToMany(User::class, 'membership', 'company_id', 'user_id');
    }

    public function roles()
    {
        return $this->hasMany(Role::class);
    }

    public function suppliers()
    {
        return $this->hasMany(Supplier::class);
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function categories()
    {
        return $this->hasMany(Category::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    public function calenderEvents()
    {
        return $this->hasMany(CalenderEvent::class);
    }

    public function conversations()
    {
        return $this->hasMany(Conversation::class);
    }

    public function invitations()
    {
        return $this->hasMany(Invitation::class);
    }

    public function permissions()
    {
        return $this->hasManyThrough(Permission::class, Role::class);
    }

    public function memberships()
    {
        return $this->hasMany(Membership::class);
    }

    public function messages()
    {
        return $this->hasManyThrough(Message::class, Conversation::class);
    }
 
    public function clients()
    {
        return $this->hasMany(Client::class);
    }
 
    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function isMember($userId)
    {
        return $this->users()->where('user_id', $userId)->exists();
    }

}
