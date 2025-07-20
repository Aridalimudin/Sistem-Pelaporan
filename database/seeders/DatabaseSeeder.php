<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Define an array of permissions to be created
        $permissions = [
            'dashboard',
            'user-list',
            'user-create',
            'user-edit',
            'user-delete',
            'role-create',
            'permission-create',
        ];

        // Create each permission if it doesn't already exist
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        $user = User::firstOrCreate(
            ['username' => 'diki'],
            [
                'name' => 'Diki Iskandar',
                'email' => 'diki@gmail.com',
                'password' => bcrypt('password')
            ]
        );

        $role = Role::firstOrCreate(['name' => 'Superadmin']);

     
        $allPermissions = Permission::pluck('id', 'id')->all();

        $role->syncPermissions($allPermissions);

      
        $user->assignRole([$role->id]);

     
        $userBk = User::firstOrCreate(
            ['username' => 'syifa'],
            [
                'name' => 'Syifa Zakiyah',
                'email' => 'syifa@gmail.com',
                'password' => bcrypt('password')
            ]
        );

        $roleBk = Role::firstOrCreate(['name' => 'GuruBK']);

        $permissionsBk = Permission::where("name", "dashboard")->pluck('id', 'id')->all();

        $roleBk->syncPermissions($permissionsBk);

        $userBk->assignRole([$roleBk->id]);

        $this->call(CrimeSeeder::class);
        $this->call(StudentSeeder::class);
    }
}
