<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City_en extends Model
{
    use HasFactory;
    protected $table = 'cities_en';
    protected $guarded = [];


    public function country_en()
    {
        return $this->belongsTo(Country_en::class);
    }

}
