<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    public function definition(): array
    {
        return [
            'id' => $this->faker->uuid,
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'document' => strval(fake()->numberBetween(11111111111, 99999999999)),
            'password' => Hash::make('password'), // password
            'role' => 'common'
        ];
    }
}
