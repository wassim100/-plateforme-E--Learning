<?php

namespace Database\Factories;

use App\Models\Course;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CourseFactory extends Factory
{
    protected $model = Course::class;

    public function definition(): array
    {
        $title = $this->faker->unique()->sentence(3);
        return [
            'title' => $title,
            'description' => $this->faker->optional()->paragraph(),
            'category_id' => Category::factory(),
        ];
    }
}
