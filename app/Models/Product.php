<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *   description="Product model",
 *   title="Product",
 *   required={},
 *   @OA\Property(type="integer",description="id of Product",title="id",property="id",example="1",readOnly="true"),
 *   @OA\Property(type="string",description="id of shop",title="shop_id",property="shop_id",example="1'"),
 *   @OA\Property(type="string",description="name of Product",title="name",property="name",example="Nuevo producto'"),
 *   @OA\Property(type="string",description="description of Product",title="description",property="description",example="Descripcion de nuevo producto'"),
 *   @OA\Property(type="string",description="image of Product",title="image",property="image",example="https://via.placeholder.com/640x480.png/006655?text=beatae'"),
 *   @OA\Property(type="string",description="stock of Product",title="stock",property="stock",example="45"),
 *   @OA\Property(type="string",description="price of Product",title="price",property="price",example="150.50"),
 *   @OA\Property(type="string",description="Discount (percent) of Product",title="discount_percent",property="discount_percent",example="20"),
 *   @OA\Property(type="dateTime",title="created_at",property="created_at",example="2022-07-04T02:41:42.336Z",readOnly="true"),
 *   @OA\Property(type="dateTime",title="updated_at",property="updated_at",example="2022-07-04T02:41:42.336Z",readOnly="true"),
 * )
 * 
 * @OA\Schema(
 *   schema="Products",
 *   title="Products",
 *   @OA\Property(title="data",property="data",type="array",
 *     @OA\Items(type="object",ref="#/components/schemas/Product"),
 *   )
 * )
 * 
 * @OA\Parameter(
 *      parameter="Product--id",
 *      in="path",
 *      name="product",
 *      required=true,
 *      description="Id of Product",
 *      @OA\Schema(
 *          type="integer",
 *          example="1",
 *      )
 * ),
 */

class Product extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }
}
