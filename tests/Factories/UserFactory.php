<?php

namespace Meops\Populate\Tests\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Meops\Populate\Tests\Models\User;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'password' => $this->faker->password,
        ];
    }
}