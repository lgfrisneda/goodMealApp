<?php

namespace Tests\Feature\Api;

use App\Models\Shop;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;
use Tests\TestCase;

class ShopApiTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test if list all shops registered (API)
     *
     * @return void
     */
    public function test_list_all_shops_registered_api()
    {
        $this->withoutExceptionHandling();

        Shop::factory(3)->create();

        $this->json('get', route('api.shops.index'))
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure(
                [
                    'data' => [
                        '*' => [
                            'id',
                            'name',
                            'description',
                            'image',
                            'options',
                            'address',
                            'lon',
                            'lat',
                            'created_at',
                            'updated_at',
                        ]
                    ]
                ]
            )->assertJsonCount(3, 'data');
    }

    /**
     * Test shop can be created (API)
     *
     * @return void
     */
    public function test_shop_can_be_created_api()
    {
        $this->withoutExceptionHandling();

        $newData = [
            'name' => 'Nuevo shop',
            'description' => 'Descripcion de nuevo shop',
            'image' => 'https://via.placeholder.com/640x480.png/005522?text=alias',
            'options' => Arr::random(['pick-up', 'delivery', 'both']),
            'address' => 'Lorem ipsum dolor sit, amet consectetur adipisicing elit. Deserunt provident recusandae laboriosam rem, ratione id inventore tempora',
            'lon' => rand($min = -180, $max = 180) / 10,
            'lat' => rand($min = -90, $max = 90) / 10
        ];

        $this->json('post', route('api.shops.store'), $newData)
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure(
                [
                    'data' => [
                        'id',
                        'name',
                        'description',
                        'image',
                        'options',
                        'address',
                        'lon',
                        'lat',
                        'created_at',
                        'updated_at',
                    ]
                ]
            );
        $this->assertDatabaseHas('shops', $newData);
    }

    /**
     * Test shop can be updated (API)
     *
     * @return void
     */
    public function test_shop_can_be_updated_api()
    {
        $this->withoutExceptionHandling();

        Shop::factory(1)->create();

        $shop = Shop::latest()->first();

        $editData = [
            'name' => 'Nuevo shop editado',
            'description' => 'Descripcion de nuevo shop editado',
            'image' => 'https://via.placeholder.com/640x480.png/005522?text=alias',
            'options' => Arr::random(['pick-up', 'delivery', 'both']),
            'address' => 'Lorem ipsum dolor sit, amet consectetur adipisicing elit. Deserunt provident recusandae laboriosam rem, ratione id inventore tempora editado',
            'lon' => rand($min = -180, $max = 180) / 10,
            'lat' => rand($min = -90, $max = 90) / 10
        ];

        $this->json('put', route('api.shops.update', $shop->id), $editData)
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure(
                [
                    'data' => [
                        'id',
                        'name',
                        'description',
                        'image',
                        'options',
                        'address',
                        'lon',
                        'lat',
                        'created_at',
                        'updated_at',
                    ]
                ]
            );
    }

    /**
     * Test shop can be deleted (API)
     *
     * @return void
     */
    public function test_shop_can_be_deleted_api()
    {
        $this->withoutExceptionHandling();

        Shop::factory(1)->create();

        $shop = Shop::latest()->first();

        $this->json('delete', route('api.shops.destroy', $shop->id))
            ->assertStatus(Response::HTTP_NO_CONTENT);
        $this->assertCount(0, Shop::all());
    }
}
