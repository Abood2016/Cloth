<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;
    protected $guarded = [];


    public function countries_ar()
    {
        return $this->belongsTo(Country::class , 'country_id' ,'id');
    }
    
     public function cities_ar()
    {
        return $this->belongsTo(City::class , 'city_id' ,'id');
    }

    public function countries_en()
    {
        return $this->belongsTo(Country_en::class , 'country_en_id' ,'id');
    }
    
     public function cities_en()
    {
        return $this->belongsTo(City_en::class , 'city_en_id' ,'id');
    }

}
