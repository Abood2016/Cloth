<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country_en extends Model
{
    use HasFactory;
    protected $table = 'countries_en';
    protected $guarded = [];

    public function address()
    {
        return $this->belongsTo(Address::class , 'country_en_id','id');
    }

}
