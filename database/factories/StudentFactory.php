<?php

namespace Database\Factories;

use App\Models\Student;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class StudentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Student::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'date_of_birth' => $this->faker->date,
            'gender' => \Arr::random(['male', 'female', 'other']),
            'address' => $this->faker->address,
            'user_id' => \App\Models\User::factory(),
        ];
    }
}
