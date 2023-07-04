<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ConfirmPasswordController;

Route::view('/', 'home');

Route::get('/',[ProductController::class, 'showHomeWithProducts'])->name('home');

// Users
Route::group(['prefix' => 'Users', 'controller' => UserController::class], function(){
    Route::get('/','showAllUsers')->name('users');
    Route::get('/CreateUser','showCreateUser')->name('user.create');
    Route::get('/EditUser/{user}','showEditUser')->name('user.edit');

    Route::post('/CreateUser','createUser')->name('user.create.post');
    Route::put('/EditUser/{user}','updateUser')->name('user.edit.put');
    Route::delete('/DeleteUser/{user}','deleteUser')->name('user.delete');
});


// Products
Route::group(['prefix' => 'Products', 'controller' => ProductController::class], function(){
    Route::get('/','showProducts')->name('products');
    //viene de la API
    Route::get('/GetAllProducts', 'getAllProducts');
    Route::post('/SaveProduct', 'saveProduct');
    Route::get('/GetAProduct/{product}', 'getAProduct');
    // Route::put('/UpdateProduct/{product}', 'updateProduct');
    Route::post('/UpdateProduct/{product}', 'updateProduct');
    Route::delete('/DeleteAProduct/{product}', 'deleteProduct');


    Route::get('/GetAllBooksDataTable', 'getAllBooksForDataTable'); //renderizado del datatable
    Route::get('/GetABook/{book}', 'getABook');
    Route::post('/UpdateBook/{book}', 'updateBook');
    Route::delete('/DeleteABook/{book}', 'deleteBook');

});

//Categories
Route::group(['prefix' => 'Categories', 'controller' => CategoryController::class], function(){
    //Viene de la API
    Route::get('/GetAllCategories', 'getAllCategories');
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
