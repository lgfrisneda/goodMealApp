<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Models\Product;
use App\Models\Shop;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * @OA\Get(
     *  path="/api/shops/{shop}/products",
     *  operationId="getProductsFromShop",
     *  tags={"Products"},
     *  @OA\Parameter(ref="#/components/parameters/Shop--id"),
     *  summary="Get list of Products from Shop",
     *  description="Returns list of Products from Shop",
     *  @OA\Response(response=200, description="Successful operation",
     *    @OA\JsonContent(ref="#/components/schemas/Products"),
     *  ),
     * )
     *
     * Display a listing of products from shop.
     * @return JsonResponse
     */
    public function index(Shop $shop)
    {
        $products = $shop->products;

        return response()->json(['data' => $products]);
    }

    /**
     * @OA\Post(
     *  operationId="storeProduct",
     *  summary="Insert a new Product",
     *  description="Insert a new Product",
     *  tags={"Products"},
     *  path="/api/shops/{shop}/products",
     *  @OA\Parameter(ref="#/components/parameters/Shop--id"),
     *  @OA\RequestBody(
     *       required=true,
     *       @OA\JsonContent(
     *         required={"name","description","image","stock","price","discount_percent"},
     *         @OA\Property(property="name", type="string", example="Nuevo producto"),
     *         @OA\Property(property="description", type="string", example="Descripcion de nuevo producto"),
     *         @OA\Property(property="image", type="string", example="https://via.placeholder.com/640x480.png/006655?text=beatae"),
     *         @OA\Property(property="stock", type="string", example="20"),
     *         @OA\Property(property="price", type="string", example="150.50"),
     *         @OA\Property(property="discount_percent", type="string", example="20"),
     *       ),
     *      ),
     *  @OA\Response(response="201",description="Product created",
     *     @OA\JsonContent(
     *      @OA\Property( title="data", property="data", type="object", ref="#/components/schemas/Product"),
     *    ),
     *  ),
     *  @OA\Response(response=422,description="Validation exception"),
     * )
     *
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\ProductStoreRequest $request
     * @param  \App\Models\Shop $shop
     * @return \Illuminate\Http\Response
     */
    public function store(ProductStoreRequest $request, Shop $shop)
    {
        $dataValidated = $request->validated();
        $newProduct = $shop->products()->create($dataValidated);

        return response()->json(['data' => $newProduct]);
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
     *   operationId="updateProduct",
     *   summary="Update an existing Product",
     *   description="Update an existing Product",
     *   tags={"Products"},
     *   path="/api/shops/{shop}/products/{product}",
     *   @OA\Parameter(ref="#/components/parameters/Shop--id"),
     *   @OA\Parameter(ref="#/components/parameters/Product--id"),
     *   @OA\Response(response="204",description="No content"),
     *   @OA\RequestBody(
     *       required=true,
     *       @OA\JsonContent(
     *         required={"name","description","image","stock","price","discount_percent"},
     *         @OA\Property(property="name", type="string", example="Nuevo producto"),
     *         @OA\Property(property="description", type="string", example="Descripcion de nuevo producto"),
     *         @OA\Property(property="image", type="string", example="https://via.placeholder.com/640x480.png/006655?text=beatae"),
     *         @OA\Property(property="stock", type="string", example="20"),
     *         @OA\Property(property="price", type="string", example="150.50"),
     *         @OA\Property(property="discount_percent", type="string", example="20"),
     *       ),
     *      ),
     *      @OA\Response(
     *          response=202,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/Product"),
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
     *
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\ProductUpdateRequest $request
     * @param  \App\Models\Shop $shop
     * @param  \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function update(ProductUpdateRequest $request, Shop $shop, Product $product)
    {
        $dataValidated = $request->validated();
        $product->update($dataValidated);
        return response()->json(['data' => $product->fresh()]);
    }

    /**
     * @OA\Delete(
     *  path="/api/shops/{shop}/products/{product}",
     *  summary="Delete a Product",
     *  description="Delete a Product",
     *  operationId="destroyProduct",
     *  tags={"Products"},
     *  @OA\Parameter(ref="#/components/parameters/Shop--id"),
     *  @OA\Parameter(ref="#/components/parameters/Product--id"),
     *  @OA\Response(response=204,description="Producto Borrado Exitoso"),
     *  @OA\Response(response=404,description="Product not found"),
     * )
     * 
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Shop $shop
     * @param  \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Shop $shop, Product $product)
    {
        $message = 'Fallido';
        if($shop->products->contains($product)){
            $product->delete();
            $message = 'Exitoso';
        }

        return response()->json(['message' => 'Producto Borrado '.$message], 204);
    }
}
