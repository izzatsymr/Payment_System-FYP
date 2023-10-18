<?php

namespace Database\Factories;

use App\Models\Card;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class CardFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Card::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'rfid' => $this->faker->text(255),
            'security_key' => $this->faker->text(255),
            'balance' => $this->faker->randomFloat(2, 0, 9999),
            'status' => 'active',
            'student_id' => \App\Models\Student::factory(),
        ];
    }
}
