<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *   description="Shop model",
 *   title="Shop",
 *   required={},
 *   @OA\Property(type="integer",description="id of Shop",title="id",property="id",example="1",readOnly="true"),
 *   @OA\Property(type="string",description="name of Shop",title="name",property="name",example="Nuevo shop"),
 *   @OA\Property(type="string",description="description of Shop",title="description",property="description",example="Descripcion de nuevo shop"),
 *   @OA\Property(type="string",description="image of Shop",title="image",property="image",example="https://via.placeholder.com/640x480.png/005522?text=alias"),
 *   @OA\Property(type="string",description="options of Shop",title="options",property="options",example="pick-up || delivery || both"),
 *   @OA\Property(type="string",description="address of Shop",title="address",property="address",example="Lorem ipsum dolor sit, amet consectetur adipisicing elit. Deserunt provident recusandae laboriosam rem, ratione id inventore tempora"),
 *   @OA\Property(type="string",description="lon of Shop",title="lon",property="lon",example="-66.83921109896633"),
 *   @OA\Property(type="string",description="lat of Shop",title="lat",property="lat",example="10.49215828524248"),
 *   @OA\Property(type="dateTime",title="created_at",property="created_at",example="2022-12-19T02:41:42.336Z",readOnly="true"),
 *   @OA\Property(type="dateTime",title="updated_at",property="updated_at",example="2022-12-19T02:41:42.336Z",readOnly="true"),
 * )
 * 
 * @OA\Schema(
 *   schema="Shops",
 *   title="Shops",
 *   @OA\Property(title="data",property="data",type="array",
 *     @OA\Items(type="object",ref="#/components/schemas/Shop"),
 *   )
 * )
 * 
 * @OA\Parameter(
 *      parameter="Shop--id",
 *      in="path",
 *      name="shop",
 *      required=true,
 *      description="Id of Shop",
 *      @OA\Schema(
 *          type="integer",
 *          example="1",
 *      )
 * ),
 */

class Shop extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function delivery()
    {
        return $this->hasOne(Delivery::class);
    }
}
