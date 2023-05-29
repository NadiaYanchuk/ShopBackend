<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\SubCategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return 'welcome';
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'role:admin'])->group(function (){
    Route::controller(DashboardController::class)->group(function(){
        Route::get('/admin/dashboard', 'Index')->name('admindashboard');
    });

    Route::controller(CategoryController::class)->group(function(){
        Route::get('/admin/all-categories', 'Index')->name('allcategories');
        Route::get('/admin/add-category', 'AddCategory')->name('addcategory');
        Route::post('/admin/store-category', 'StoreCategory')->name('storecategory');
    });

    Route::controller(SubCategoryController::class)->group(function(){
        Route::get('/admin/all-subcategories', 'Index')->name('allsubcategories');
        Route::get('/admin/add-subcategory', 'AddSubCategory')->name('addsubcategory');
    });

    Route::controller(ProductController::class)->group(function(){
        Route::get('/admin/all-products', 'Index')->name('allproducts');
        Route::get('/admin/add-product', 'AddProduct')->name('addproduct');
    });

    Route::controller(OrderController::class)->group(function(){
        Route::get('/admin/pending-order', 'Index')->name('pendingorders');
    });
});

require __DIR__.'/auth.php';
