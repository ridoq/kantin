<?php

use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('category',[CategoryController::class, 'index'])->name('category');
Route::post('crate/category',[CategoryController::class, 'store']);
Route::put('edit/category/{category}',[CategoryController::class, 'update'])->name('edit.category');
Route::delete('delete/category/{category}',[CategoryController::class, 'destroy'])->name('delete.category');
