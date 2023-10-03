<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Account;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        foreach (['09367287143', '09368961831'] as $mobile) {
            $user = \App\Models\User::factory()->create([
                'mobile' => $mobile,
            ]);

            Account::factory()->count(3)->for($user)->create();
        }
    }
}
