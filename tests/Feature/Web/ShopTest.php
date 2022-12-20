<?php

namespace Tests\Feature\Web;

use App\Models\Product;
use App\Models\Shop;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class ShopTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test if list all shops registered
     *
     * @return void
     */
    public function test_list_all_shops_registered_view()
    {
        $this->withoutExceptionHandling();

        $user = User::factory()->withPersonalTeam()->create();
        $this->actingAs($user);

        Shop::factory(3)->create();
        
        $this->get(route('shops.index'))
                ->assertInertia(fn (Assert $page) => $page
                    ->component('Shops/Index')
                    ->has('shops', 3)
                );
    }

    /**
     * Test if shop can be show
     *
     * @return void
     */
    public function test_shop_can_be_show_view()
    {
        $this->withoutExceptionHandling();

        $user = User::factory()->withPersonalTeam()->create();
        $this->actingAs($user);

        Shop::factory(1)->create();

        Product::factory(3)->create();

        $shop = Shop::latest()->first();
        
        $this->get(route('shops.show', $shop->id))
                ->assertInertia(fn (Assert $page) => $page
                    ->component('Shops/Show')
                    ->has('shop', fn (Assert $page) => $page
                        ->where('id', $shop->id)
                        ->where('name', $shop->name)
                        ->etc()
                        ->has('products', 3)
                    )
                );
    }
}
