<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        foreach (['09367287143', '09368961831'] as $mobile) {
            \App\Models\User::factory()->create([
                'mobile' => $mobile,
            ]);
        }
    }
}
