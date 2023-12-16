<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Achievement;
use App\Models\Company;
use App\Models\Staff;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(5)->afterCreating(function (User $user) {
            Company::factory()->afterCreating(function (Company $company) {
                Achievement::factory(3)->create([
                    'company_id' => $company->id,
                ]);
                Staff::factory(5)->create([
                    'company_id' => $company->id,
                ]);
            })->create([
                'user_id' => $user->id
            ]);
        })->create();
    }
}
