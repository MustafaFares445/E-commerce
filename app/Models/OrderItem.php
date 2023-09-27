<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static create(string[] $array)
 */
class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'order_id',
    ];

    public function order()
    {
        return $this->belongTo(Order::class);
    }

    public function product()
    {
        return $this->hasOne(Product::class);
    }
}
