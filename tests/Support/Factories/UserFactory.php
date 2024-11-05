<?php

namespace Meops\Populate\Tests\Support\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Meops\Populate\Tests\Support\Models\User;

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