<?php

namespace Database\Factories;

use App\Models\QuizResult;
use App\Models\Quiz;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class QuizResultFactory extends Factory
{
    protected $model = QuizResult::class;

    public function definition(): array
    {
        $quiz = Quiz::factory();
        $score = $this->faker->numberBetween(0, 10);
        $percentage = $score * 10;
        $started = now()->subDays($this->faker->numberBetween(1, 30));
        $completed = (clone $started)->addMinutes($this->faker->numberBetween(5, 60));

        return [
            'user_id' => User::factory(),
            'quiz_id' => $quiz,
            'score' => $score,
            'percentage' => $percentage,
            'time_taken' => $this->faker->numberBetween(5, 60),
            'answers' => [],
            'started_at' => $started,
            'completed_at' => $completed,
        ];
    }
}
