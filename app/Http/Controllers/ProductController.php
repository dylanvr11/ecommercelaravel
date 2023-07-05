<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Requests\Product\CreateProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;

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

    public function saveProduct(CreateProductRequest $request){
        $product = new Product($request->all());
        //dd($request);
        $this->uploadImages($request, $product);  //despues carga la imagen
        $product->save();
        return response()->json(['product' => $product], 200);
    }

    public function getAProduct(Product $product){
        $product->load('Category');
        return response()->json(['product' => $product],200);
    }

    public function updateProduct(Product $product, UpdateProductRequest $request){

        $requestAll = $request->all();
        $this->uploadImages($request,$product);
        $requestAll['image'] = $product->image;
        $product->update($requestAll);
        return response()->json(['category' => $product->refresh()->load('Category')], 201);
        // acá imagen otra direccion
        /*
        $this->uploadImages($request, $product);
        $product->update($request->all());
        return response()->json(['product' => $product->refresh()->load('Category')],201);
        */
    }

    public function deleteProduct(Product $product){
        $product->delete();
        return response()->json([],204);
    }

    private function uploadImages($request, &$product){
        if(!isset($request->image)) return;
        $random = Str::random(20);
        $image_name = "{$random}.{$request->image->clientExtension()}";
        $request->image->move(storage_path('app/public/images'), $image_name);
        $product->image = $image_name;
    }
}
