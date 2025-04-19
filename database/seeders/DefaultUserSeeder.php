<?php

namespace Database\Seeders;

use App\Models\Organization;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DefaultUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Use firstOrCreate to prevent duplicate entries
        $organization = Organization::firstOrCreate(
            ['name' => 'TechCorp'], // Check if an organization with this name exists
            ['description' => 'A technology company'] // Insert description if it doesn't exist
        );

        // Creating Super Admin User
        $superAdmin = User::firstOrCreate(
            ['email' => 'javed@allphptricks.com'], // Check for user uniqueness by email
            [
                'name' => 'Javed Ur Rehman',
                'password' => Hash::make('javed1234'),
            ]
        );
        $superAdmin->assignRole('Super Admin');
        $superAdmin->organizations()->attach($organization->id); // Attach to organization

        // Creating Admin User
        $admin = User::firstOrCreate(
            ['email' => 'ahsan@allphptricks.com'],
            [
                'name' => 'Syed Ahsan Kamal',
                'password' => Hash::make('ahsan1234'),
            ]
        );
        $admin->assignRole('Admin');
        $admin->organizations()->attach($organization->id);

        // Creating Product Manager User
        $productManager = User::firstOrCreate(
            ['email' => 'muqeet@allphptricks.com'],
            [
                'name' => 'Abdul Muqeet',
                'password' => Hash::make('muqeet1234'),
            ]
        );
        $productManager->assignRole('Product Manager');
        $productManager->organizations()->attach($organization->id);

        // Creating Application User
        $user = User::firstOrCreate(
            ['email' => 'naghman@allphptricks.com'],
            [
                'name' => 'Naghman Ali',
                'password' => Hash::make('naghman1234'),
            ]
        );
        $user->assignRole('User');
        $user->organizations()->attach($organization->id);
    }
}
