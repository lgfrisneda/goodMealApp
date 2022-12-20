<?php

namespace Database\Seeders;

use App\Models\Delivery;
use App\Models\Shop;
use Illuminate\Database\Seeder;

class DeliverySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $shops = Shop::where('options', '<>', 'pick-up')->pluck('id')->toArray();

        foreach($shops as $shop){
            Delivery::create([
                'shop_id' => $shop,
                'percent' => rand(1, 20)
            ]);
        }
    }
}
