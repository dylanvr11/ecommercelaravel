<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function showProducts()
    {
        return view('products.index');
    }

    public function showHomeWithProducts()
    {
        $products = $this->getAllProducts()->original['products'];
        return view('index',compact('products'));
    }

    public function getAllProducts()
	{
		$products = Product::get();
		return response()->json(['products' => $products], 200);
	}

    public function saveProduct(Request $request){
        $product = new Product($request->all());
        //dd($request);
        $product->save();
        return response()->json(['product' => $product], 201);
    }

    public function getAProduct(Product $product){
        $product->load('Category');
        return response()->json(['product' => $product],200);
    }

    public function updateProduct(Product $product, Request $request){
        $product->update($request->all());
        return response()->json(['product' => $product->refresh()->load('Category')],201);
    }
}
