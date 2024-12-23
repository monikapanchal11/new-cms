<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;


Route::get('/', function () {
    return view('welcome');
});


Route::get('api/{slug}', [PageController::class, 'show'])->where('slug', '.*');

Route::get('/{any}', function () {
    return view('app'); 
})->where('any', '.*');
