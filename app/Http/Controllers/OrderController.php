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

        foreach(array_values($dataCart) as $data){
            $orderCreated->details()->create(Arr::except($data, ['amount_unit']));
        }

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
