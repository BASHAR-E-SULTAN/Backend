<?php

namespace Database\Factories;

use App\Models\c_user;
use Hash;
use Illuminate\Database\Eloquent\Factories\Factory;


class CUserFactory extends Factory
{

    protected $model = c_user::class;

    public function definition(): array
    {
        $data = [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'phone' => $this->faker->phoneNumber(),
            'password' => Hash::make('password123'),
            'is_banned' => $this->faker->boolean(30),
            'ban_reason' => null,
            'banned_at' => null,
        ];
        if ($data['is_banned']) {
            $data['ban_reason'] = $this->faker->sentence();
            $data['banned_at'] = $this->faker->dateTimeBetween('-1 years', 'now');
        }
        return $data;
    }
}