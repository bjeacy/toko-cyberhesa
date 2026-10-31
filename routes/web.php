<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ItemController;
use Illuminate\Support\Facades\Route;

Route::get('/', [CategoryController::class, 'index'])->name('categories.index');

Route::get('/categories/{id}', [CategoryController::class, 'show'])->name('categories.show');

Route::get('/items', [ItemController::class, 'index'])->name('items.index');

Route::get('/items/create', [ItemController::class, 'create'])->name('items.create');

Route::post('/items', [ItemController::class, 'store'])->name('items.store');
