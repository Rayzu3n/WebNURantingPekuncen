<?php

namespace Database\Factories;

use App\Models\Member;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Member>
 */
class MemberFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'member_number' => fake()->unique()->bothify('NU-########'),
            'nik' => fake()->unique()->numerify('################'),
            'birth_place' => fake()->city(),
            'birth_date' => fake()->date(),
            'gender' => fake()->randomElement(['L', 'P']),
            'phone' => fake()->numerify('08##########'),
            'address' => fake()->address(),
            'photo' => null,
            'status' => 'active',
        ];
    }
}
