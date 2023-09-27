<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;

/**
 * @method static paginate(int $int)
 * @method static create(array $all)
 * @method static whereYear(string $string, string $string1, int $year)
 * @property int|mixed|string $number
 */
class Order extends Model
{
    use HasFactory;

    protected $fillable = [
      'user_id',
      'number',
      'status',
      'store_id',
      'payment_status',
        'shipping',
        'tax',
        'discount',
        'total',
    ];


    public function  user(): BelongsTo
    {
        return $this->belongsTo(User::class)->withDefault([
            'name' => 'Guest Customer'
        ]);
    }

    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class , 'order_items' , 'order_id' , 'product_id' , 'id' , 'id')
            ->using(OrderItem::class)
            ->withPivot([
                'product_name' , 'price' , 'quantity' , 'options'
            ]);
    }

    public function addresses(): HasMany
    {
        return $this->hasMany(OrderAddress::class);
    }

    public function billingAddress(): HasOne
    {
        return $this->hasOne(OrderAddress::class , 'order_id' , 'id')->where('type' , 'billing');
    }

    public function shippingAddress(): HasOne
    {
        return $this->hasOne(OrderAddress::class , 'order_id' , 'id')->where('type' , 'shipping');
    }
    protected static function booted()
    {
        static::creating(function (Order $order){
            $order->number = Order::getNextOrderNumber();
        });
    }

    public static function getNextOrderNumber()
    {
        $year = Carbon::now()->year;
        $number =  Order::whereYear('created_at' , '>=' , $year)->max('number');
       if ($number){
           return $number + 1;
       }
       return $year . '0001';
    }
}
