<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @method static paginate(int $int)
 * @method static create(array $all)
 */
class Order extends Model
{
    use HasFactory;

    protected $fillable = [
      'user_id',
      'number',
      'status',
    ];


    public function  user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function orderItem(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
}
