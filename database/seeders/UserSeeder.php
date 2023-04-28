<?php

namespace Database\Seeders;

use App\Jobs\SendEmailJob;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $roleUSerData = [
            'name' => 'User',
            'is_system_generated'=>1
        ];

        $roleSuperAdminData = [
            'name' => 'Super Admin',
            'is_system_generated'=>1
        ];

        $permission = [
            ['guard_name' => 'web','name' => 'list-user'],
            ['guard_name' => 'web','name' => 'create-user'],
            ['guard_name' => 'web','name' => 'update-user'],
            ['guard_name' => 'web','name' => 'delete-user'],
            ['guard_name' => 'web','name' => 'list-role'],
            ['guard_name' => 'web','name' => 'create-role'],
            ['guard_name' => 'web','name' => 'update-role'],
            ['guard_name' => 'web','name' => 'delete-role'],
            ['guard_name' => 'web','name' => 'list-cms'],
            ['guard_name' => 'web','name' => 'create-cms'],
            ['guard_name' => 'web','name' => 'update-cms'],
            ['guard_name' => 'web','name' => 'delete-cms'],
            ['guard_name' => 'web','name' => 'list-faq'],
            ['guard_name' => 'web','name' => 'create-faq'],
            ['guard_name' => 'web','name' => 'update-faq'],
            ['guard_name' => 'web','name' => 'delete-faq'],
            ['guard_name' => 'web','name' => 'list-support'],
            ['guard_name' => 'web','name' => 'create-support'],
            ['guard_name' => 'web','name' => 'update-support'],
            ['guard_name' => 'web','name' => 'delete-support'],
        ];
        
        $roleSuperAdmin = Role::create($roleSuperAdminData);
        Role::create($roleUSerData);
        Permission::insert($permission);

       $user = User::create([
            'name' => 'Super Admin',
            'email' => config('const.superAdminEmail'),
            'password' => Hash::make('Moon@123$$!!'),
            'email_verified_at' => now(),
        ]);

        $user->assignRole($roleSuperAdmin); 
               
    }
}
