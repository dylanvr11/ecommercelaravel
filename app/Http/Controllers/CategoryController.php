<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Order;
use App\Http\Requests\Category\CreateCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;
use Yajra\DataTables\Facades\DataTables;

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

    public function getAllCategoriesForDataTable()
    {
        $categories = Category::get();
        return DataTables::of($categories)
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

    public function getACategory(Category $category){
        //$product->load('Category');
        return response()->json(['category' => $category],200);
    }


    public function saveCategory(CreateCategoryRequest $request){
        $category = new Category($request->all());
        $category->save();
        return response()->json(['category' => $category], 200);
    }

    public function updateCategory(Category $category, UpdateCategoryRequest $request){

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
        return response()->json(['category' => $products ], 200);
    }

    public function getAllProductsByCategories()
    {
        $categories = Category::get();
        $products = $categories->load('Products');
        return response()->json(['categories' => $products ], 200);
    }

    public function getFiveProductsByCategories()
    {
        $categories = Category::with(['products' => function ($query) {
            $query->where('stock', '>', 0)->take(5);
        }])->get();
        return response()->json(['categories' => $categories], 200);
    }


    public function showCategoryWithProducts(Category $category)
    {
        $products = $this->getAllProductsByCategory($category);
        return view('home.index', compact('category'));
    }

    public function showHomeCategoriesWithProducts()
    {
        $categories = $this->getAllProductsByCategories()->original['categories'];
        //cosas nuevas
        $order = new Order();
        //dd($categories);
        return view('home', compact('categories', 'order'));
    }
}
