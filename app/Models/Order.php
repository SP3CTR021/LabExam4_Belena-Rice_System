<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_name',
        'rice_type_id',
        'quantity',
        'total_cost',
        'status',
        'payment_status',
        'amount_paid',
        'balance',
    ];

    public function riceType()
    {
        return $this->belongsTo(RiceType::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
