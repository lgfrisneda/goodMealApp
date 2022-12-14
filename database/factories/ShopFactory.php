<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ShopFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->company,
            'description' => $this->faker->sentence($nbWords = 6, $variableNbWords = true),
            'image' => $this->faker->imageUrl($width = 640, $height = 480),
            'options' => $this->faker->randomElement(['pick-up', 'delivery', 'both']),
            'address' => $this->faker->address,
            'lon' => $this->faker->longitude($min = -180, $max = 180),
            'lat' => $this->faker->latitude($min = -90, $max = 90)
        ];
    }
}
