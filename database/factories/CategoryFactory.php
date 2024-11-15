<?php

namespace Database\Factories;

use App\Models\category;
use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\User;

class CategoryFactory extends Factory
{
    protected $model = category::class;

    public function definition()
    {
        $userId = User::factory()->create()->id;
        

        return [
            'name' => $this->faker->sentence,
            'created_by' => $userId,
            'updated_by' => $userId,
        ];
    }
}
