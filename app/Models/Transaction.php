<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Basket;


class Transaction extends Model
{
    use HasFactory;
    const STATUS_SUCCESS = 2;
    const STATUS_PENDING = 1;
    const STATUS_FAILED = 0;
    protected $fillable = [
        'payment_id',
        'user_id',
        'basket_id',
        'paid',
        'status',
        'invoice_details',
        'transaction_id',
        'transaction_result'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function basket()
    {
        return $this->belongsTo(Basket::class);
    }

    public function getInvoiceDetailsAttribute()
    {
        return unserialize($this->attributes['invoice_details']);
    }

    public function setInvoiceDetailsAttribute($value)
    {
        return $this->attributes['invoice_details'] = serialize($value);
    }

    public function getTransactionResultAttribute()
    {
        return unserialize($this->attributes['transaction_result']);
    }

    public function setTransactionResultAttribute($value)
    {
        return $this->attributes['transaction_result'] = serialize($value);   
    }
}
