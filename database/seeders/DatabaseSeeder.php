<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Faker\Factory as FakerFactory;
use Illuminate\Support\Facades\Hash;
use App\Models\Quiz;
use App\Models\Question;
use App\Models\QuizResult;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // Create a baseline user (no factories to avoid IDE analyzer false-positives)
        $values = [
            'name' => 'Test User',
            'password' => Hash::make('password'),
        ];
        if (\Schema::hasColumn('users', 'role')) {
            $values['role'] = 'admin';
        }
        User::query()->updateOrCreate(
            ['email' => 'test@example.com'],
            $values
        );

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

        // Create a handful of quizzes with questions
        Quiz::factory()
            ->count(3)
            ->create()
            ->each(function (Quiz $quiz) use ($faker) {
                // Attach questions
                Question::factory()->count(8)->create(['quiz_id' => $quiz->id]);

                // Create some results for a few users
                $users = User::factory()->count(3)->create();
                foreach ($users as $user) {
                    QuizResult::factory()->create([
                        'user_id' => $user->id,
                        'quiz_id' => $quiz->id,
                    ]);
                }
            });
    }
}
