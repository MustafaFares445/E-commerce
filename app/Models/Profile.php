<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static create(array $all)
 */
class Profile extends Model
{
    use HasFactory;
    protected $primaryKey = 'user_id';

    public function user()
    {
        return $this->belongsTo(User::class , 'user_id' , 'id');
    }
}
