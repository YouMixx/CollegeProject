<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Company>
 */
class CompanyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->company,
            'description' => $this->faker->text,
            'director' => $this->faker->name(),
            'inn' => $this->faker->numberBetween(000000, 9999999999),
            'kpp' => $this->faker->numberBetween(000000, 999999999),
            'ogrn' => $this->faker->numberBetween(000000, 9999999999999),
            'phone' => $this->faker->phoneNumber(),
            'email' => $this->faker->email(),
            'type' => $this->faker->randomElement(['individual', 'ooo']),
        ];
    }
}
