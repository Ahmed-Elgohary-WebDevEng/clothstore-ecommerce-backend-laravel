<?php

use App\Http\Controllers\API\V1\PageController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

// pages routes
Route::get('/', [PageController::class, 'homePage'])->name("page.home-page");
Route::get('/products/{product:product_slug}', [PageController::class, 'productDetails'])->name('page.product-details');


// tests
/*Route::middleware('auth:sanctum')->get("/hell-auth", function () {
    return "authenticated";
});
Route::get("/hell-guest", function () {
    return "guest";
});*/
