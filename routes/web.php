<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\IngredientController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\TransactionController;
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

Route::get('employee', [EmployeeController::class, 'index'])->name('employee');
Route::post('crate/employee', [EmployeeController::class, 'store']);
Route::put('edit/employee/{employee}', [EmployeeController::class, 'update'])->name('edit.employee');
Route::delete('delete/employee/{employee}', [EmployeeController::class, 'destroy'])->name('delete.employee');

Route::get('supplier', [SupplierController::class, 'index'])->name('supplier');
Route::post('crate/supplier', [SupplierController::class, 'store']);
Route::put('edit/supplier/{supplier}', [SupplierController::class, 'update'])->name('edit.supplier');
Route::delete('delete/supplier/{supplier}', [SupplierController::class, 'destroy'])->name('delete.supplier');

Route::get('transaction', [TransactionController::class, 'index'])->name('transaction');
Route::post('crate/transaction', [TransactionController::class, 'store']);
Route::put('edit/transaction/{transaction}', [TransactionController::class, 'update'])->name('edit.transaction');
Route::delete('delete/transaction/{transaction}', [TransactionController::class, 'destroy'])->name('delete.transaction');

Route::get('ingredient', [IngredientController::class, 'index'])->name('ingredient');
Route::post('crate/ingredient', [IngredientController::class, 'store']);
Route::put('edit/ingredient/{ingredient}', [IngredientController::class, 'update'])->name('edit.ingredient');
Route::delete('delete/ingredient/{ingredient}', [IngredientController::class, 'destroy'])->name('delete.ingredient');
