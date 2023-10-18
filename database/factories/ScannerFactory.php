<?php

namespace Database\Factories;

use App\Models\Scanner;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class ScannerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Scanner::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'amount' => $this->faker->randomNumber(1),
            'mode' => 'pay',
            'user_id' => \App\Models\User::factory(),
        ];
    }
}
