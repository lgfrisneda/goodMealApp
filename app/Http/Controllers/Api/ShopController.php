<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ShopStoreRequest;
use App\Http\Requests\ShopUpdateRequest;
use App\Models\Shop;
use Illuminate\Http\Request;

use function GuzzleHttp\Promise\all;

class ShopController extends Controller
{
    /**
     * @OA\Get(
     *      path="/api/shops",
     *      operationId="getShopsList",
     *      tags={"Shops"},
     *      summary="Get list of shops",
     *      description="Returns list of shops",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/Shops"),
     *       ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     *     )
     */
    public function index()
    {
        $shops = Shop::all();
        return response()->json($shops);
    }

    /**
     * @OA\Post(
     *      path="/api/shops",
     *      operationId="storeShop",
     *      tags={"Shops"},
     *      summary="Store new shop",
     *      description="Returns shop data",
     *      @OA\RequestBody(
     *       required=true,
     *       @OA\JsonContent(
     *         required={"name","description","image","options","address","lon","lat"},
     *         @OA\Property(property="name", type="string", example="Nuevo shop"),
     *         @OA\Property(property="description", type="string", example="Descripcion de nuevo shop"),
     *         @OA\Property(property="image", type="string", example="https://via.placeholder.com/640x480.png/005522?text=alias"),
     *         @OA\Property(property="options", type="string", example="pick-up | delivery | both"),
     *         @OA\Property(property="address", type="string", example="Lorem ipsum dolor sit, amet consectetur adipisicing elit. Deserunt provident recusandae laboriosam rem, ratione id inventore tempora"),
     *         @OA\Property(property="lon", type="string", example="-66.83921109896633"),
     *         @OA\Property(property="lat", type="string", example="10.49215828524248"),
     *       ),
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/Shops"),
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     * )
     */
    public function store(ShopStoreRequest $request)
    {
        $dataValidated = $request->validated();
        $newShop = Shop::create($dataValidated);

        return response()->json($newShop);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * @OA\Put(
     *      path="/api/shops/{shop}",
     *      operationId="updateShop",
     *      tags={"Shops"},
     *      summary="Update existing shop",
     *      description="Returns updated shop data",
     *      @OA\Parameter(
     *          name="shop",
     *          description="Shop id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *        @OA\JsonContent(
     *         required={"name","description","image","options","address","lon","lat"},
     *         @OA\Property(property="name", type="string", example="Nuevo shop"),
     *         @OA\Property(property="description", type="string", example="Descripcion de nuevo shop"),
     *         @OA\Property(property="image", type="string", example="https://via.placeholder.com/640x480.png/005522?text=alias"),
     *         @OA\Property(property="options", type="string", example="pick-up | delivery | both"),
     *         @OA\Property(property="address", type="string", example="Lorem ipsum dolor sit, amet consectetur adipisicing elit. Deserunt provident recusandae laboriosam rem, ratione id inventore tempora"),
     *         @OA\Property(property="lon", type="string", example="-66.83921109896633"),
     *         @OA\Property(property="lat", type="string", example="10.49215828524248"),
     *       ),
     *      ),
     *      @OA\Response(
     *          response=202,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/Shops"),
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Resource Not Found"
     *      )
     * )
     */
    public function update(ShopUpdateRequest $request, Shop $shop)
    {
        $dataValidated = $request->validated();
        $shop->update($dataValidated);

        return response()->json($shop->fresh());
    }

    /**
     * @OA\Delete(
     *  path="/api/shops/{shop}",
     *  summary="Delete a Shop",
     *  description="Delete a Shop",
     *  operationId="destroyShop",
     *  tags={"Shops"},
     *  @OA\Parameter(ref="#/components/parameters/Shop--id"),
     *  @OA\Response(response=204,description="No content"),
     *  @OA\Response(response=404,description="Shop not found"),
     * )
     *
     * @param Shop $Shop
     * @return Response|JsonResponse
     */
    public function destroy(Shop $shop)
    {
        $shop->delete();
        return response()->json(['message' => 'Shop Borrado exitosamente'], 204);
    }
}
