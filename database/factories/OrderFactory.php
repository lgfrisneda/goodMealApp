<?php

namespace Database\Factories;

use App\Models\Shop;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $shops = Shop::pluck('id')->toArray();
        $users = User::pluck('id')->toArray();

        return [
            'shop_id' => $this->faker->randomElement($shops),
            'user_id' => $this->faker->randomElement($users),
            'status' => 'paid',
        ];
    }
}
