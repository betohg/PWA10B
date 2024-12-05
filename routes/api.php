<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\MovementController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TypeMovementController;



// Route::apiResource('categories', CategoryController::class);

// Route::apiResource('suppliers', SupplierController::class);

// Route::apiResource('products', ProductController::class);

// Route::apiResource('movements', MovementController::class);



Route::get('/categories', [CategoryController::class, 'index']);
Route::post('/categories', [CategoryController::class, 'store']); 
Route::get('/categories/{id}', [CategoryController::class, 'show']); 
Route::put('/categories/{category}', [CategoryController::class, 'update']); 
Route::delete('/categories/{category}', [CategoryController::class, 'destroy']);

Route::get('/suppliers', [SupplierController::class, 'index']); 
Route::post('/suppliers', [SupplierController::class, 'store']); 
Route::get('/suppliers/{id}', [SupplierController::class, 'show']); 
Route::put('/suppliers/{supplier}', [SupplierController::class, 'update']); 
Route::delete('/suppliers/{supplier}', [SupplierController::class, 'destroy']); 

Route::get('/products', [ProductController::class, 'index']); 
Route::post('/products', [ProductController::class, 'store']); 
Route::get('/products/{id}', [ProductController::class, 'show']); 
Route::put('/products/{id}', [ProductController::class, 'update']); 
Route::delete('/products/{id}', [ProductController::class, 'destroy']); 


Route::get('/typesmovements', [TypeMovementController::class, 'index']); 
Route::post('/typesmovements', [TypeMovementController::class, 'store']); 
Route::get('/typesmovements/{id}', [TypeMovementController::class, 'show']); 
Route::put('/typesmovements/{id}', [TypeMovementController::class, 'update']); 
Route::delete('/typesmovements/{id}', [TypeMovementController::class, 'destroy']); 




Route::get('/movements', [MovementController::class, 'index']);

Route::post('/movements', [MovementController::class, 'store']);

Route::get('/movements/{movement}', [MovementController::class, 'show']);

Route::put('/movements/{movement}', [MovementController::class, 'update']);

Route::delete('/movements/{movement}', [MovementController::class, 'destroy']);


Route::get('/movementspdf', [MovementController::class, 'indexL']);



Route::post('/register', [UserController::class, 'register']);

Route::post('/login', [UserController::class, 'login']);

Route::post('/logout', [UserController::class, 'logout']);

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
