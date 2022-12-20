<?php

namespace Tests\Feature\Api;

use App\Models\Product;
use App\Models\Shop;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;
use Tests\TestCase;

class ProductApiTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test if list all products from shop (API)
     *
     * @return void
     */
    public function test_list_all_products_from_shop_api()
    {
        $this->withoutExceptionHandling();

        Shop::factory(1)->create();

        $shop = Shop::latest()->first();

        Product::factory(10)->create();

        $this->json('get', route('api.products.index', $shop->id))
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure(
                [
                    'data' => [
                        '*' => [
                            'id',
                            'shop_id',
                            'name',
                            'description',
                            'image',
                            'stock',
                            'price',
                            'discount_percent',
                            'created_at',
                            'updated_at',
                        ]
                    ]
                ]
            )->assertJsonCount(10, 'data');
    }

    /**
     * Test product can be created (API)
     *
     * @return void
     */
    public function test_product_can_be_created_api()
    {
        $this->withoutExceptionHandling();

        Shop::factory(1)->create();

        $shop = Shop::latest()->first();

        $newData = [
            'name' => 'Nuevo producto',
            'description' => 'Descripcion de nuevo producto',
            'image' => 'https://via.placeholder.com/640x480.png/006655?text=beatae',
            'stock' => rand(0, 50),
            'price' => rand(0, 100) / 10,
            'discount_percent' => rand(0, 100)
        ];

        $this->json('post', route('api.products.store', $shop->id), $newData)
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure(
                [
                    'data' => [
                        'id',
                        'shop_id',
                        'name',
                        'description',
                        'image',
                        'stock',
                        'price',
                        'discount_percent',
                        'created_at',
                        'updated_at',
                    ]
                ]
            );
        $this->assertDatabaseHas('products', $newData);
    }

    /**
     * Test product can be updated (API)
     *
     * @return void
     */
    public function test_product_can_be_updated_api()
    {
        $this->withoutExceptionHandling();

        Shop::factory(1)->create();
        Product::factory(1)->create();

        $shop = Shop::latest()->first();
        $product = Product::latest()->first();

        $editData = [
            'name' => 'Nuevo producto editado',
            'description' => 'Descripcion de nuevo producto editado',
            'image' => 'https://via.placeholder.com/640x480.png/006655?text=beatae',
            'stock' => rand(0, 50),
            'price' => rand(0, 100) / 10,
            'discount_percent' => rand(0, 100)
        ];

        $this->json('put', route('api.products.update', [$shop->id, $product->id]), $editData)
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure(
                [
                    'data' => [
                        'id',
                        'shop_id',
                        'name',
                        'description',
                        'image',
                        'stock',
                        'price',
                        'discount_percent',
                        'created_at',
                        'updated_at',
                    ]
                ]
            );
    }

    /**
     * Test product can be deleted (API)
     *
     * @return void
     */
    public function test_product_can_be_deleted_api()
    {
        $this->withoutExceptionHandling();

        Shop::factory(1)->create();
        Product::factory(1)->create();

        $shop = Shop::latest()->first();
        $product = Product::latest()->first();

        $this->json('delete', route('api.products.destroy', [$shop->id, $product->id]))
            ->assertStatus(Response::HTTP_NO_CONTENT);
        $this->assertCount(0, Product::all());
    }
}
