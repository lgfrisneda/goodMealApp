<?php

namespace Database\Factories;

use App\Models\Shop;
use Illuminate\Database\Eloquent\Factories\Factory;

class DeliveryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $shops = Shop::where('options', '<>', 'pick-up')->pluck('id')->toArray();
        return [
            'shop_id' => $this->faker->randomElement($shops),
            'percent' => rand(1, 20)
        ];
    }
}
