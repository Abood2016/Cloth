<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Builder;

class Cart extends Pivot
{
    use HasFactory;

    protected $table = 'carts';
    protected $keyType = 'string';
    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    protected function setKeysForSaveQuery($query)
    {
        return $query->where('id', '=', $this->attributes['id'])
            ->where('product_id', '=', $this->attributes['product_id']);
    }

    // protected function incrementOrDecrement($column, $amount, $extra, $method)
    // {
    //     $query = $this->newQueryWithoutRelationships();
    //     if (!$this->exists) {
    //         return $query->{$method}($column, $amount, $extra);
    //     }

    //     $this->incrementOrDecrementAttributeValue($column, $amount, $extra, $method);
    //     $query = $this->setKeysForSaveQuery($query);
    //     return $query->{$method}($column, $amount, $extra);
    // }
}
