<?php

namespace Database\Factories;

use App\Models\category;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Task;
use App\Models\User;

class TaskFactory extends Factory
{
    protected $model = Task::class;

    public function definition()
    {
        $userId = User::factory()->create()->id;
        $categoryId = category::factory()->create()->id;

        return [
            'description' => $this->faker->sentence,
            'user_id' => $userId,
            'category_id' => $categoryId,
            'created_by' => $userId,
            'updated_by' => $userId,
        ];
    }
}
