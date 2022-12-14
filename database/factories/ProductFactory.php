<?php

namespace Database\Factories;

use App\Models\Shop;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $shops = Shop::pluck('id')->toArray();
        return [
            'shop_id' => $this->faker->randomElement($shops),
            'name' => $this->faker->word,
            'description' => $this->faker->sentence($nbWords = 6, $variableNbWords = true),
            'image' => $this->faker->imageUrl($width = 640, $height = 480),
            'stock' => rand(0, 50),
            'price' => $this->faker->randomFloat(2, 0, 100),
            'discount_percent' => $this->faker->randomNumber(2)
        ];
    }
}
