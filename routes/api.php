<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::group(['prefix' => 'Users', 'controller' => UserController::class], function(){
    Route::get('/GetAllUsers', 'getAllUsers'); //GET -> traer data
    Route::get('/GetAnUser/{user}', 'getAnUser'); //GET -> traer data
    Route::get('/GetAllOrdersByUser/{user}', 'getAllOrdersByUser'); //traer los pedidos por usuario
    Route::get('/GetAllUsersWithOrders', 'getAllUsersWithOrders');

    Route::post('/CreateUser', 'createUser');  //POST -> Cread data
    Route::put('/UpdateUser/{user}', 'updateUser'); //PUT -> Actualiza data
    Route::delete('/DeleteUser/{user}', 'deleteUser'); //DELETE -> Elimina data
});

/*
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
*/

// Orders
Route::group(['prefix' => 'Orders', 'controller' => OrderController::class], function(){
    Route::post('/CreateOrder', 'createOrder');
});

//Products
Route::group(['prefix' => 'Products', 'controller' => ProductController::class], function(){
    Route::get('/GetAllProducts', 'getAllProducts');
});

//Categories
Route::group(['prefix' => 'Categories', 'controller' => CategoryController::class], function(){
    Route::get('/GetAllCategories', 'getAllCategories');
});
