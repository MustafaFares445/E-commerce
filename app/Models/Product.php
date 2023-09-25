<?php

namespace App\Models;

use App\Models\Scopes\StoreScope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory , SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'image',
        'price',
        'compare_price',
        'featured',
        'category_id',
        'store_id',
    ];

    public static function booted()
    {
        static::addGlobalScope('store' ,new StoreScope());
    }

}
