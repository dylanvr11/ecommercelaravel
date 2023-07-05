<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function showCategories()
    {
        return view('categories.index');
    }

    public function getAllCategories()
	{
		$categories = Category::get();
		return response()->json(['categories' => $categories], 200);
	}

    public function saveCategory(Request $request){
        $category = new Category($request->all());
        $category->save();
        return response()->json(['category' => $category], 200);
    }

    public function updateCategory(Category $category, Request $request){

        $requestAll = $request->all();
        $category->update($requestAll);
        return response()->json(['category' => $category->refresh()], 201);
    }

    public function deleteCategory(Category $category)
	{
        $category->delete();
        return response()->json([],204);
	}

    public function getAllProductsByCategory(Category $category)
    {
        $products = $category->load('Products');
        return response()->json(['products' => $products ], 200);
    }

    public function getAllProductsByCategories()
    {
        $categories = Category::get();
        $products = $categories->load('Products');
        return response()->json(['categories' => $products ], 200);
    }

    public function showHomeCategoriesWithProducts()
    {
        $categories = $this->getAllProductsByCategories()->original['categories'];
        //dd($categories);
        return view('index2', compact('categories'));
    }
}
