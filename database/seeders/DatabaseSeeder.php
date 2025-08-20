<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Faker\Factory as FakerFactory;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // Create a baseline user (no factories to avoid IDE analyzer false-positives)
        User::query()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
        ]);

        // Seed categories with Faker directly (keeps data realistic, avoids factory chain warnings)
        $faker = FakerFactory::create();
        for ($i = 0; $i < 12; $i++) {
            $name = Str::title($faker->unique()->words(2, true));
            \App\Models\Category::query()->create([
                'name' => $name,
                'slug' => Str::slug($name . '-' . Str::random(4)),
                'description' => $faker->optional()->sentence(10),
                'is_active' => $faker->boolean(85),
            ]);
        }
    }
}
