<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\ParentsController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('category', [CategoryController::class, 'index'])->name('category');
Route::post('crate/category', [CategoryController::class, 'store']);
Route::put('edit/category/{category}', [CategoryController::class, 'update'])->name('edit.category');
Route::delete('delete/category/{category}', [CategoryController::class, 'destroy'])->name('delete.category');

Route::get('menu', [MenuController::class, 'index'])->name('menu');
Route::post('crate/menu', [MenuController::class, 'store']);
Route::put('edit/menu/{menu}', [MenuController::class, 'update'])->name('edit.menu');
Route::delete('delete/menu/{menu}', [MenuController::class, 'destroy'])->name('delete.menu');

Route::get('customer', [CustomerController::class, 'index'])->name('customer');
Route::post('crate/customer', [CustomerController::class, 'store']);
Route::put('edit/customer/{customer}', [CustomerController::class, 'update'])->name('edit.customer');
Route::delete('delete/customer/{customer}', [CustomerController::class, 'destroy'])->name('delete.customer');
