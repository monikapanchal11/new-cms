<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/admin/pages', function () {
    return view('pages'); // This will serve the Vue-based CRUD view
})->name('pages');

Route::get('{slug}', [PageController::class, 'show'])->where('slug', '.*');
