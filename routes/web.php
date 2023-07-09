<?php

use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ConfirmPasswordController;

Route::get('/test', function(){
    /*
    Role::create(['name'=>'admin']); //primer ejecucion
    Role::create(['name'=>'user']); //segundo role

    //Asignarle roles

    $users = User::get();
    foreach ($users as $user){
        if($user->number_id == 1122334455) $user->assignRole('admin');
        else $user->assignRole('user');
    }
*/
});

Route::get('/',[CategoryController::class, 'showHomeCategoriesWithProducts'])->name('home');

// Users
Route::group(['prefix' => 'Users', 'middleware' => ['auth'], 'controller' => UserController::class], function(){

    Route::get('/GetAllOrdersByUser/{user}', 'getAllOrdersByUser');
    Route::get('/GetAllOrdersByUserAuth', 'getAllOrdersByUserAuth');

    Route::group(['middleware' => ['auth','role:admin']],function(){
        Route::get('/','showAllUsers')->name('users');
        //Route::get('/GetAllUsersDataTable', 'getAllProducts');
        Route::get('/GetAllUsers', 'getAllUsers');
        Route::get('/GetAllRoles', 'getAllRoles');
        Route::post('/CreateUser', 'createUser');
        Route::get('/GetAnUser/{user}', 'getAnUser');
        Route::delete('/DeleteAUser/{user}','deleteUser');
        Route::post('/UpdateUser/{user}', 'updateUser');
        Route::get('/GetAllRoles', 'getAllRoles');
        Route::get('/GetAllUsersDataTable', 'getAllUsersForDataTable'); //renderizado del datatable
        Route::get('/CreateUser','showCreateUser')->name('user.create');
        Route::get('/EditUser/{user}','showEditUser')->name('user.edit');
        Route::post('/CreateUser','createUser')->name('user.create.post');
        Route::put('/EditUser/{user}','updateUser')->name('user.edit.put');
        Route::delete('/DeleteUser/{user}','deleteUser')->name('user.delete');
    });

});

// Products
Route::group(['prefix' => 'Products', 'controller' => ProductController::class], function(){


    Route::get('/GetAProductWithCategory/{product}','getAProductWithCategory');
    Route::get('/GetAProductWithCategory/{product}','showProductWithCategory')->name('product.get');;




    Route::group(['middleware' => ['auth','role:admin']], function(){
        Route::get('/','showProducts')->name('products');
        //viene de la API
        Route::get('/GetAllProducts', 'getAllProducts');
        Route::get('/GetAllProductsDataTable', 'getAllProducts');
        Route::post('/SaveProduct', 'saveProduct');
        Route::get('/GetAProduct/{product}', 'getAProduct');

        Route::post('/UpdateProduct/{product}', 'updateProduct');
        Route::delete('/DeleteAProduct/{product}', 'deleteProduct');

        Route::get('/GetAllProductsDataTable', 'getAllProductsForDataTable'); //renderizado del datatable
        Route::get('/GetABook/{book}', 'getABook');
        Route::post('/UpdateBook/{book}', 'updateBook');
        Route::delete('/DeleteABook/{book}', 'deleteBook');

    });

});

//Categories
Route::group(['prefix' => 'Categories', 'controller' => CategoryController::class], function(){


    Route::get('/GetAllProductsByCategory/{category}', 'getAllProductsByCategory');
    Route::get('/GetAllProductsByCategory/{category}', 'showCategoryWithProducts')->name('category.get');

    Route::group(['middleware' => ['auth','role:admin']], function(){
        Route::get('/','showCategories')->name('categories');
        //Viene de la API
        Route::get('/GetACategory/{category}', 'getACategory');
        Route::get('/GetAllCategories', 'getAllCategories');
        Route::get('/GetAllCategoriesDataTable', 'getAllCategories');
        Route::get('/GetAllCategoriesDataTable','getAllCategoriesForDataTable');
        Route::post('/SaveCategory', 'saveCategory');

        Route::get('/GetAllProductsByCategories', 'getAllProductsByCategories');
        Route::get('/GetFiveProductsByCategories', 'getFiveProductsByCategories');
        Route::post('/UpdateCategory/{category}', 'updateCategory');
        Route::delete('/DeleteACategory/{category}', 'deleteCategory');
    });

});

//Orders
Route::group(['prefix' => 'Order', 'middleware' => ['auth'], 'controller' => OrderController::class], function(){
    Route::get('/','showCarts')->name('carts');
    //Viene de la API
    Route::post('/CreateOrder/{product}', 'createOrder')->name('add.cart.post');
});

// Auth -------------------
Route::group(['controller' => LoginController::class], function(){
    // Login Routes ...
    Route::get('login', 'showLoginForm')->name('login');
    Route::post('login', 'login');

    // Logout Routes ...
    Route::post('logout', 'logout')->name('logout');
});

// Regiter Routes ...
Route::group(['controller' => RegisterController::class], function(){
    Route::get('register', 'showRegistrationForm')->name('register');
    Route::post('register', 'register');
});


// Password reset Routes ...
Route::group(['controller' => ForgotPasswordController::class], function(){
    // Password Forgot Routes ...
    Route::get('password/reset', 'showLinkRequestForm')
    ->name('password.request');
    Route::post('password/email', 'sendResetLinkEmail')
        ->name('password.email');
});

Route::group(['controller' => ResetPasswordController::class], function(){
    // Password reset Routes ...
    Route::get('password/reset/{token}', 'showResetForm')
        ->name('password.reset');
    Route::post('password/reset', 'reset')
        ->name('password.update');
});

Route::group(['controller' => ConfirmPasswordController::class], function(){
    // Password Confirmation Routes ...
    Route::get('password/confirm', 'showConfirmForm')
        ->name('password.confirm');
    Route::post('password/confirm', 'confirm');
});

Route::group(['controller' => VerificationController::class], function(){
    // Email Verification Routes ...
    Route::get('email/verify', 'show')
        ->name('verification.notice');
    Route::get('email/verify/{id}/{hash}', 'verify')
        ->name('verification.verify');
    Route::post('email/resend', 'resend')
        ->name('verification.resend');
});
