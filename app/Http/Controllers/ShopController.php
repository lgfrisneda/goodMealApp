<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ShopController extends Controller
{
    public function index()
    {
        $shops = Shop::all()->load('products');
        return $this->view('Shops.Index', compact('shops'));
    }

    public function show(Shop $shop)
    {
        $shop->load('products');
        return $this->view('Shops.Show', compact('shop'));
    }
}
