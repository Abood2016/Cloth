<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class product_images extends Model
{
    use HasFactory;
    protected $table = 'product_images';
    protected $guarded;
    protected $appends = ['image_url'];


    public function Product()
    {
        return $this->belongsTo(Product::class,'product_id','id');
    }

    public function getImageUrlAttribute()
    {
        if ($this->image_name) {
            if (strpos($this->image_name, 'http') === 0) {
                return $this->image_name;
            }
            return asset('images/products/' . $this->image_name);
        }
    }
}
