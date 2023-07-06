<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function createOrder(Request $request)
    {
        $order = new Order($request->all());
        dd($order);
        $order->save();
        if($request->ajax()) return response()->json(['order' => $order], 201);
        return back()->with('success','Producto agregado');
    }

    public function createOrder2(Order $order, Request $request)
    {
        dd($request);
        $order->save();
        if($request->ajax()) return response()->json(['order' => $order], 201);
        return back()->with('success','Producto agregado');
    }
/*
    public function createUser(Request $request)
    {
        $order  = new Order($request->all());
        $order->save();
        if($request->ajax()) return response()->json(['user'=>$user], 201);
        return back()->with('success','Usuario Creado');
    }
*/
    public function showCarts()
    {
        return view('carts.index');
    }
}
