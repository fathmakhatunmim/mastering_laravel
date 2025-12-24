<?php
use App\Http\Controllers\FoodController;
use App\Http\Controllers\reviewcontroller;
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
})->name('category');


Route::get('/customerReview', function () {
    return view('CustoReview');
})->name('customer.review'); 

Route::get('/customerOrder', function () {
    return view('customerOrder');
})->name('customer.order'); 



Route::resource('food',FoodController::class);


Route::get('/food/{id}', [FoodController::class, 'show'])->name('food.details');



// // Food page + Reviews
// Route::get('/food', [FoodController::class, 'Index']);

// // Optional: Review CRUD or AJAX
// Route::get('/review', [FoodController::class, 'reviewIndex']);

// web.php
// Route::post('/reviewStore', [FoodController::class, 'reviewStore'])->name('food.reviewStore');
Route::get('/reviewEdit/{id}', [FoodController::class, 'reviewEdit'])->name('food.reviewEdit');

Route::delete('/reviewDelete/{id}', [FoodController::class, 'reviewDestroy'])->name('food.reviewDelete');


Route::post('/reviewStore', [FoodController::class, 'reviewStore'])->name('food.reviewStore');

Route::post('/OrderStore', [FoodController::class, 'OrderStore'])->name('food.OrderStore');



Route::get('/reviewData', [FoodController::class, 'reviewIndex'])->name('food.reviewData');

Route::get('/OrderIndex', [FoodController::class, 'OrderIndex'])->name('food.OrderIndex');







Route::resource('review',reviewcontroller::class);


Route::delete('/foods/{id}', [FoodController::class, 'destroy'])->name('foods.destroy');

Route::get('/foods/edit/{id}', [FoodController::class, 'edit'])
     ->name('foods.edit');


