<?php

namespace Tests\Feature\Web;

use App\Models\Product;
use App\Models\Shop;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class ShoppingCartTest extends TestCase
{
    use RefreshDatabase;
    
    /**
     * Test user can see your shopping cart
     *
     * @return void
     */
    public function test_user_can_see_your_shopping_cart()
    {
        $this->withoutExceptionHandling();

        $user = User::factory()->withPersonalTeam()->create();
        $this->actingAs($user);

        $myCart = session('cart') ?? [];

        $this->get(route('shoppingCart.show'))
                ->assertInertia(fn (Assert $page) => $page
                    ->component('User/ShoppingCart/Show')
                    ->has('myCart', fn (Assert $page) => $page)
                );
    }

    /**
     * Test user can add produts to shopping cart
     *
     * @return void
     */
    public function test_user_can_add_products_to_shopping_cart()
    {
        $this->withoutExceptionHandling();

        $user = User::factory()->withPersonalTeam()->create();
        $this->actingAs($user);

        Shop::factory(1)->create();

        Product::factory(1)->create();

        $product = Product::latest()->first();

        $response = $this->get(route('shoppingCart.add', $product));
        $this->assertCount(1, session('cart'));
    }
}
