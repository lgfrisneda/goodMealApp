<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class OrderController extends Controller
{
    public function generate()
    {
        // $request = new Request(session('cart'));
        $dataCart = session('cart');
        $productId = array_key_first($dataCart);
        $product = Product::find($productId);

        $orderCreated = Order::create([
            'user_id' => auth()->user()->id,
            'shop_id' => $product->shop_id,
            'status' => 'paid',
        ]);

        $dataCart = array_map(function(array $element){
            unset($element['amount_unit']);
            return $element;
        }, $dataCart);
        $orderCreated->details()->createMany($dataCart);

        session()->forget('cart');

        return redirect()->route('orders.show', $orderCreated)->with('success', 'Compra exitosa, su orden ha sido generada');

    }

    public function myOrders()
    {
        $myOrders = auth()->user()->orders->load('shop.delivery', 'details');
        return $this->view('User.Orders.Index', compact('myOrders'));
    }

    public function show(Order $order)
    {
        // dd([$order->user_id, auth()->user()->id]);
        $myOrder = $order->load('shop.delivery', 'details');
        return $this->view('User.Orders.Show', compact('myOrder'));
    }
}
