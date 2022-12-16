<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderDetailFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $orders = Order::pluck('id')->toArray();
        $products = Product::pluck('name')->toArray();

        return [
            'order_id' => $this->faker->randomElement($orders),
            'product_name' => $this->faker->randomElement($products),
            'quantity' => rand(1, 3),
            'amount' => $this->faker->randomFloat(2, 0, 100),
        ];
    }
}
