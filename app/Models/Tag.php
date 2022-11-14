<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['name'];

    public function products()
    {
        return $this->belongsToMany(
            Product::class,
            'products_tags', //the pivot table
            'tag_id', //this modal id in pivot table
            'product_id', //anthor id for second table
            'id', //id for this table 
            'id' // id for anthor table
        );
    }
}
