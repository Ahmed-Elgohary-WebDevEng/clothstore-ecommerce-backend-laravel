<?php

use App\Http\Controllers\API\V1\CartController;
use App\Http\Controllers\API\V1\PageController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// pages routes
Route::get('/', [PageController::class, 'homePage'])->name("page.home-page");
Route::get('/products', [PageController::class, 'getFilteredProducts'])->name("page.get-filtered-products");
Route::get('/products/{product:product_slug}', [PageController::class, 'productDetails'])->name('page.product-details');

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return response()->json(['user' => $request->user()]);
});
/**************************
 * ***** Cart Routes ******
 * ************************
 */
Route::middleware(['auth:sanctum'])->group(function () {
    Route::name('cart')->apiResource('cart/items', CartController::class)->except(['show']);
    Route::delete('cart/items', [CartController::class, 'clear'])->name('cart.items.clear');
});


// tests
/*Route::middleware('auth:sanctum')->get("/hell-auth", function () {
    return "authenticated";
});
Route::get("/hell-guest", function () {
    return "guest";
});*/
