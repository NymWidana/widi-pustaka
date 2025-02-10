<?php

use App\Http\Controllers\API\BookController;
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
