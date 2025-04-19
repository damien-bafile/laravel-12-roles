<?php

namespace Database\Seeders;

use App\Models\Organization;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrganizationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $organization = Organization::firstOrCreate([
            'name' => 'TechCorp',
            'description' => 'A technology company',
        ]);

        User::factory(5)->create(['organization_id' => $organization->id]); // Create 5 users for the organization
    }
}
