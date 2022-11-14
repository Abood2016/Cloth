<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'order_products')
            ->withPivot('quantity', 'price') //عشان ارجع بيانات كل جدول الوسيط
            ->as('Order_product_details_as_pivot'); // لو بدي اغير كلمة pivot ل كلمة تانيه
    }

    public function orderProducts()
    {
        return  $this->hasMany(OrderProduct::class);
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
