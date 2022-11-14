<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;
    protected $fillable = ['name'];
    
    
    public function admins()
    {
    return $this->belongsToMany(
    Admin::class,
    'admins_permissions', //the pivot table
    'permission_id', //this modal id in pivot table
    'admin_id', //anthor id for second table
    'id', //id for this table
    'id' // id for anthor table
    );
    }
}
