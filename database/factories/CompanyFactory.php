<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CompanyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'company_name'        => $this->faker->name(),
            'company_type'        => $this->faker->randomElement([1,2,3]),
            'website'             => $this->faker->url(),
            'company_description' => $this->faker->text()
        ];
    }
}
