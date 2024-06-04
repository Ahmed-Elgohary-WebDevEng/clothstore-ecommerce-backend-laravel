<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});


// tests
/*Route::middleware('auth:sanctum')->get("/hell-auth", function () {
    return "authenticated";
});
Route::get("/hell-guest", function () {
    return "guest";
});*/
