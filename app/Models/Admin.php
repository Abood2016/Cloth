<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\HasApiTokens;


class Admin extends Authenticatable
{
    use Notifiable , HasApiTokens;
    
    protected $guarded = [];

    public function hasPermission($name){
        return DB::table('admins_permissions')
        ->Join('permissions', 'permissions.id', '=', 'admins_permissions.permission_id')
        ->select('permissions.id','permissions.name as permission')
        ->where('admin_id',$this->id)
        ->where('name',$name)
        ->count();
    }

    public function permissions()
    {
      return $this->belongsToMany(
      Permission::class,
      'admins_permissions', //the pivot table
      'admin_id', //this modal id in pivot table
      'permission_id', //anthor id for second table
      'id', //id for this table
      'id' // id for anthor table
      );
    }
}
