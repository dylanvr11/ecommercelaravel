<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /*
    public function createOrder(Request $request, Product $product)
    {
        if($request->quantity>$product->stock){
            return back()->with('error','No hay la cantidad');
        }
        $order = new Order($request->all());
        $order->customer_user_id=Auth::user()->id;
        $order->product_id=$product->id;
        $order->price=$order->quantity*$product->price;
        $order->save();
        //if($request->ajax()) return response()->json(['order' => $order], 201);
        return back()->with('success','Producto agregado');
    }
    sirve
    */
    public function createOrder(Request $request, Product $product)
    {
        if($request->quantity>$product->stock){
            return back()->with('error','No hay la cantidad');
        }
        $order = new Order($request->all());
        $order->customer_user_id=Auth::user()->id;
        $order->product_id=$product->id;
        $order->price=$order->quantity*$product->price;
        $product->stock = ($product->stock)-($order->quantity);
        $product->update();
        $order->save();
        return back()->with('success','Producto agregado');
    }

    public function createOrder3(Request $request)
    {
        $order = new Order($request->all());
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

    public function deleteOrder(Order $order, Request $request)
    {
        $order->delete();
        return response()->json([], 204);
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
