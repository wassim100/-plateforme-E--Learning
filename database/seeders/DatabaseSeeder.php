<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
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
    User::updateOrCreate(
            ['email' => 'test@example.com'],
            $values
        );

        // Reset content tables, then seed realistic data using local images
    DB::statement('PRAGMA foreign_keys = ON'); // for SQLite safety; ignored by MySQL
        // Truncate in the right order to respect FKs
        foreach (['answers', 'questions', 'quizzes', 'courses', 'categories'] as $table) {
            if (Schema::hasTable($table)) {
                DB::table($table)->delete();
            }
        }

        $this->call(RealisticContentSeeder::class);
    }
}
