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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Shop $shop)
    {
        $products = $shop->products;

        return response()->json($products);
    }

    /**
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

        return response()->json($newProduct);
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
        return response()->json($product->fresh());
    }

    /**
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
