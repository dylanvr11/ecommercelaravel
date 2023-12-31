<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function getAllProducts()
	{
		$products = Product::get();
		return response()->json(['products' => $products], 200);
	}
}
