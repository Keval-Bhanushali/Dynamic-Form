<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Formsubmission>
 */
class FormsubmissionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'form_id' => \App\Models\Form::factory(),
            'data' => json_encode([
                'field_1' => $this->faker->word(),
                'field_2' => $this->faker->numberBetween(1, 100),
            ]),
        ];
    }
}
