<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\PermissionRegistrar;
use Throwable;


class PermissionSeeder extends Seeder
{
    /**
     * Runs the seeding process for creating predefined permissions.
     *
     * This method clears the cache for permissions, starts a database transaction,
     * and inserts a predefined list of permissions into the Permission table.
     * @throws Throwable
     */
    public function run(): void
    {
        // Clear the cache for permissions
//        app()[PermissionRegistrar::class]->forgetCachedPermissions();
        // Start a database transaction
//        DB::beginTransaction();
        $permissions = [
            'create-role',
            'edit-role',
            'delete-role',
            'create-user',
            'edit-user',
            'delete-user',
            'view-product',
            'create-product',
            'edit-product',
            'delete-product',
        ];

        // Looping and Inserting Array's Permissions into Permission Table
        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission,'guard_name'=>'web']);
        }
    }
}
