<?php

namespace Database\Factories;

use App\Models\Question;
use App\Models\Quiz;
use Illuminate\Database\Eloquent\Factories\Factory;

class QuestionFactory extends Factory
{
    protected $model = Question::class;

    public function definition(): array
    {
        $type = $this->faker->randomElement(['multiple_choice', 'true_false', 'short_answer']);
        $answers = null;
        $correct = null;
        if ($type === 'multiple_choice') {
            $answers = [
                $this->faker->words(3, true),
                $this->faker->words(3, true),
                $this->faker->words(3, true),
                $this->faker->words(3, true),
            ];
            $correct = $answers[array_rand($answers)];
        } elseif ($type === 'true_false') {
            $answers = ['true', 'false'];
            $correct = $this->faker->randomElement($answers);
        } else {
            $correct = $this->faker->word();
        }

        return [
            'quiz_id' => Quiz::factory(),
            'type' => $type,
            'question_text' => $this->faker->sentence() . '?',
            'answers' => $answers,
            'correct_answer' => $correct,
            'explanation' => $this->faker->optional()->sentence(),
            'category' => $this->faker->optional()->word(),
            'points' => $this->faker->numberBetween(1, 5),
            'image' => null,
        ];
    }
}
