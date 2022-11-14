<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    //must to be the same name of database
    public function commentable()
    {
        return $this->morphTo();
    }
}
