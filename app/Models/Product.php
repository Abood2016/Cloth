<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Product extends Model
{
    use HasFactory;
    protected $table = 'products';
    // protected $fillable = ['name', 'description', 'image', 'price', 'category_id ', 'admin_id', 'status'];
    protected $guarded = [];
    protected $appends = ['image_url'];


    public function media()
    {
        return $this->hasMany(product_images::class, 'product_id', 'id');
    }


    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(Admin::class, 'admin_id', 'id');
    }

    public function tags()
    {
        return $this->belongsToMany(
            Tag::class,
            'products_tags', //the pivot table
            'product_id', //this modal id in pivot table
            'tag_id', //anthor id for second table
            'id', //id for this table 
            'id' // id for anthor table
        );
    }

    public function comments()
    {
        return $this->morphMany(
            Comment::class,
            'commentable',
        );
    }
    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_products');
    }

    public function getUrlAttribute()
    {
        return route('product.show', $this->id);
    }

    public function getImageUrlAttribute()
    {
        if ($this->image) {
            if (strpos($this->image, 'http') === 0) {
                return $this->image;
            }
            return asset('images/products/cover_image/' . $this->image);
        }
    }

  

}
