<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @method static create(array $array)
 */
class Category extends Model
{
    use HasFactory , HasFactory;


    public const STATUS_ACTIVE = "active";
    protected $fillable = [
        'name' ,
        'slug',
        'status',
        'description',
        'image',
        'parent_id'
    ];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
