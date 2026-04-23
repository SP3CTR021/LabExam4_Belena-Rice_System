<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'category',
        'price_per_kilo',
        'stock',
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
