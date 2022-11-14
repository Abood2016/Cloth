<?php

namespace App\Providers;

use App\Models\Admin;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::before(function(Admin $admin,$ability){
            if($admin->type == "super-admin"){
            return true;
            }
        });

        $permissions =  DB::table('admins_permissions')
        ->Join('permissions', 'permissions.id', '=', 'admins_permissions.permission_id')
        ->select('permissions.id','permissions.name as permission')
        ->get();
       
        foreach ($permissions as $name) {
            Gate::define($name->permission,function(Admin $admin) use ($name){
              return $admin->hasPermission($name->permission);
              });
        }

        // Gate::define('products.delete',function(Admin $admin){
        //     return $admin->hasPermission('products.delete');
        //     return false;
        // });

        // Gate::define('products.edit',function(Admin $admin){
        //     return $admin->hasPermission('products.edit');
        //     return false;
        // });
        
    }
}
