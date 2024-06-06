<?php

use App\Http\Controllers\API\V1\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{product:product_slug}', [ProductController::class, 'show'])->name('products.show');


// tests
/*Route::middleware('auth:sanctum')->get("/hell-auth", function () {
    return "authenticated";
});
Route::get("/hell-guest", function () {
    return "guest";
});*/
