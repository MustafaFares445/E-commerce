<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * @method static create(array $array)
 * @method static paginate(int $int)
 * @method static where(string $string, string $string1, mixed $id)
 */
class Category extends Model
{
    use HasFactory, HasFactory, SoftDeletes;


    public const STATUS_ACTIVE = "active";
    protected $fillable = [
        'name',
        'slug',
        'status',
        'description',
        'image',
        'parent_id'
    ];


//    public function scopeFilter(Builder $builder , $filters)
//    {
////        if ($filter['name'] ?? false){
////            $builder->where('name' , 'LIKE' , "%{$filter['name']}%");
////        }
////
////        if ($filter['status'] ?? false ){
////            $builder->where('status' , $filter['status']);
////        }
////
//////        $builder->when($filters['name'] ?? false , function ($builder , $value){
//////           $builder->where('name' , 'LIKE' , "%{$value}%");
//////        });
//////
//////        $builder->when($filters['status'] ?? false , function ($builder , $value){
//////            $builder->where('status' , $value);
//////        });
/////
/////
//
//    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }


    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class , 'parent_id' , 'id')
                ->withDefault();
        //when id maybe can be null you should but withDefault() method

    }

    public function childer(): HasMany
    {
        return $this->hasMany(Category::class , 'parent_id' , 'id');
    }

}
