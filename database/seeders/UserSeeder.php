<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::beginTransaction();
        
        try {
        
        // Role::create(['name' => 'user']);

        // // Create User
        // $user = User::create([   
        //     'name' => 'Admin',
        //     'email' => 'admin@gmail.com',
        //     'password' => bcrypt('admin123')
        // ]);
        // $user->assignRole('admin');
        $adminRole = Role::where('name', 'admin')->first();

        $permission = Permission::create(['name' => 'manage admin portal']); // Membuat izin 'manage admin portal'

        $adminRole->givePermissionTo('manage admin portal'); // Memberikan izin 'manage admin portal' kepada peran 'admin'

                DB::commit();
        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollback();
        }

    }
}
