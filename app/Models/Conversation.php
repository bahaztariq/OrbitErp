<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    /** @use HasFactory<\Database\Factories\ConversationFactory> */
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'company_id',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'conversation_user', 'conversation_id', 'user_id');
    }

    public function participants()
    {
        return $this->belongsToMany(User::class, 'conversation_participants', 'conversation_id', 'user_id');
    }
}
