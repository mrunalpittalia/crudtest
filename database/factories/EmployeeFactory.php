<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class EmployeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $this->faker->addProvider(new \Faker\Provider\en_US\Address($this->faker));

        return [
            'first_name'    => $this->faker->firstname(),
            'last_name'     => $this->faker->lastname(),
            'email_address' => $this->faker->unique()->safeEmail(),
            'position'      => $this->faker->jobTitle(),
            'city'          => $this->faker->city(),
            'country'       => $this->faker->country(),
            'status'        => $this->faker->randomElement([0,1]),
        ];
    }
}
