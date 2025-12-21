<?php
use App\Http\Controllers\FoodController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/login', function () {
    return view('login');
});


Route::get('/fontend', function () {
    return view('font.style');
});

Route::get('/dashboard', function () {
    return view('layout.backend_master');
});

Route::get('/category', function () {
    return view('category');
});

Route::resource('food',FoodController::class);


Route::delete('/foods/{id}', [FoodController::class, 'destroy'])->name('foods.destroy');

Route::get('/foods/edit/{id}', [FoodController::class, 'edit'])
     ->name('foods.edit');


