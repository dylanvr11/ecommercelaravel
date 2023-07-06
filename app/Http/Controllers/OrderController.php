<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function createOrder(Request $request)
    {
        $order = new Order($request->all());
        $order->save();
        return response()->json(['order' => $order], 201);
    }

    public function showCarts()
    {
        return view('carts.index');
    }
}
