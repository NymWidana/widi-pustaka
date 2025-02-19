<?php

use App\Http\Controllers\API\AuthorController;
use App\Http\Controllers\API\BookController;
use App\Http\Controllers\API\CategoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

//routes for book CRUD api
Route::controller(BookController::class)->group( function(){
    Route::get('/books', 'index')->name('book.index');
    Route::post('/books', 'store')->name('book.store');
    Route::get('/books/{book}', 'show')->name('book.show');
    Route::put('/books/{book}', 'update')->name('book.update');
    Route::delete('/books/{book}', 'destroy')->name('book.destroy');
});

//routes for category CRUD api
Route::controller(CategoryController::class)->group( function(){
    Route::get('/categories', 'index')->name('category.index');
    Route::post('/categories', 'store')->name('category.store');
    Route::get('/categories/{category}', 'show')->name('category.show');
    Route::put('/categories/{category}', 'update')->name('category.update');
    Route::delete('/categories/{category}', 'destroy')->name('category.destroy');
});

//routes for author CRUD api
Route::controller(AuthorController::class)->group( function(){
    Route::get('/authors', 'index')->name('author.index');
    Route::post('/authors', 'store')->name('author.store');
    Route::get('/authors/{author}', 'show')->name('author.show');
    Route::put('/authors/{author}', 'update')->name('author.update');
    Route::delete('/authors/{author}', 'destroy')->name('author.destroy');
});
