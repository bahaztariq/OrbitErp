<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model
{
    /** @use HasFactory<\Database\Factories\InvoiceFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'invoice_number',
        'order_id',
        'client_id',
        'issue_date',
        'due_date',
        'total_amount',
        'status',
        'company_id',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
