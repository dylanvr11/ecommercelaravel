<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Requests\Product\CreateProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use Yajra\DataTables\Facades\DataTables;

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
/*
    public function getAllBooksForDataTable()
    {
        $products = Product::get();
        return DataTables::of($products)->make();
    }
    sin las acciones
*/
    public function getAllProductsForDataTable()
    {
        $products = Product::get();
        return DataTables::of($products)
        ->addColumn('action', function($row) {
            return "<a
            href='#'
            onclick='event.preventDefault();'
            data-id='{$row->id}'
            role='edit'
            class='btn btn-warning btn-sm'>Edit</a>
            <a
            href='#'
            onclick='event.preventDefault();'
            data-id='{$row->id}'
            role='delete'
            class='btn btn-danger btn-sm'>Delete</a>";
        })
        ->rawColumns(['action'])
        ->make();
    }
    public function saveProduct(CreateProductRequest $request){
        $product = new Product($request->all());
        //dd($request);
        $this->uploadImages($request, $product);  //despues carga la imagen
        $product->save();
        return response()->json(['product' => $product], 200);
    }

    public function getAProduct(Product $product){
        //$product->load('Category');
        return response()->json(['product' => $product],200);
    }


    public function getAProductWithCategory(Product $product){
        $product->load('Category')->Category();
        return response()->json(['product' => $product],200);
    }

    public function showProductWithCategory(Product $product){
        $product=$this->getAProductWithCategory($product)->original['product'];
        //dd($product);
        return view('product.index',compact('product'));
    }

    public function updateProduct(Product $product, UpdateProductRequest $request){

        $requestAll = $request->all();
        $this->uploadImages($request,$product);
        $requestAll['image'] = $product->image;
        $product->update($requestAll);
        return response()->json(['category' => $product->refresh()->load('Category')], 201);
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
