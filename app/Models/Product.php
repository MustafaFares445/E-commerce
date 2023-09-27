<?php

namespace App\Models;

use App\Models\Scopes\StoreScope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\OrderItem;
/**
 * @method static paginate(int $int)
 * @method static create(array $all)
 * @method static where(string $string, mixed $param)
 * @method static find(mixed $id)
 */
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
    //    static::addGlobalScope('store' ,new StoreScope());
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class , 'product_tag');
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class);
    }
}
