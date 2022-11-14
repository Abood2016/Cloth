<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    use HasFactory;
    protected $table = 'stores';
    protected $guarded;


    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function products()
    {
        return $this->hasManyThrough(
            Product::class, //model want to access through users model => Product
            User::class, //throuable model
            'store_id', // foreign in throuable model => User
            'user_id', // foreign key in model want to access
            'id', // P. K Stores
            'id', // P . K Users
        );
    }
}
