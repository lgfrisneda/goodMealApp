<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\Shop;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class OrderTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test list all user's orders registered
     *
     * @return void
     */
    public function test_list_all_users_orders_registered()
    {
        $this->withoutExceptionHandling();

        $user = User::factory()->withPersonalTeam()->create();
        $this->actingAs($user);

        $shop = Shop::factory(3)->create();

        Order::factory(3)->create();
      
        $this->get(route('orders.myOrders'))
                ->assertInertia(fn (Assert $page) => $page
                    ->component('User/Orders/Index')
                    ->has('myOrders', 3)
                );
    }

    /**
     * Test order with product can be show
     *
     * @return void
     */
    public function test_order_with_products_can_be_show()
    {
        $this->withoutExceptionHandling();

        $user = User::factory()->withPersonalTeam()->create();
        $this->actingAs($user);

        Shop::factory(1)->create();

        Product::factory(1)->create();

        Order::factory(1)->create();
        OrderDetail::factory(1)->create();

        $myOrder = Order::latest()->first();
        
        $this->get(route('orders.show', $myOrder->id))
                ->assertInertia(fn (Assert $page) => $page
                    ->component('User/Orders/Show')
                    ->has('myOrder', fn (Assert $page) => $page
                        ->etc()
                        ->has('details')
                    )
                );
    }
}
