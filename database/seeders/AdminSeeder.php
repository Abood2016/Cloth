<?php

namespace Database\Seeders;

use App\Models\Admin;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = Admin::create([
        'name' => 'admin',
        'email' => 'admin@admin.com',
        'password' => Hash::make('123456'),
        'type' => 'super-admin',
        'created_at' => Carbon::now(),    
        ]);
    }
}
