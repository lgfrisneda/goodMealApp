<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ShoppingCartController extends Controller
{    
    public function show()
    {
        $myCart = session('cart') ?? [];
        if(!$myCart){
            return redirect()->route('shops.index')->with('warning', 'Tu carrito de compras esta vacio');
        }
        $productId = array_key_first($myCart);
        $shop = Product::find($productId)->shop->load('delivery');
        return $this->view('User.ShoppingCart.Show', compact('myCart', 'shop'));
    }

    public function add(Request $request, Product $product)
    {
        if(!$product && !$request->amount_discount){
            return back()->with('warning', 'Este producto no existe');
        }

        $cart = session()->get('cart');
        if(!$cart){
            $cart = [
                    $product->id => [
                        'product_name' => $product->name,
                        'quantity' => 1,
                        'amount' => $request->amount_discount,
                    ]
            ];
        }else{
            if(isset($cart[$product->id])){
                $cart[$product->id]['quantity']++;
                $cart[$product->id]['amount'] = $request->amount_discount * $cart[$product->id]['quantity'];
            }else{
                $cart[$product->id] = [
                    'product_name' => $product->name,
                    'quantity' => 1,
                    'amount' => $request->amount_discount,
                ];
            }
        
        }
        
        session()->put('cart', $cart);

        return back()->with('success', 'Producto agregado al carrito');
    }

    public function update(Request $request)
    {
        if($request->id && $request->quantity){
            $cart = session()->get('cart');
            $cart[$request->id]['quantity'] = $request->quantity;
            session()->put('cart', $cart);
            return redirect()->back()->with('success', 'Carrito actualizado exitosamente');
        }
    }

    public function remove(Request $request)
    {
        if($request->id){
            $cart = session()->get('cart');

            if(isset($cart[$request->id])){
                unset($cart[$request->id]);
                session()->put('cart', $cart);
            }
            return redirect()->back()->with('success', 'Producto removido exitosamente');
        }
    }

}
