<?php

use App\Http\Controllers\admin\ProductController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\user\UserController;
use App\Http\Controllers\admin\AdminController;
use App\Http\Controllers\admin\AttributeController;
use App\Http\Controllers\admin\AttributeSetController;
use App\Http\Controllers\admin\BrandController;
use App\Http\Controllers\admin\CategoryController;
use App\Http\Controllers\admin\SubCategoryController;
use App\Http\Controllers\ProductStockController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('frontend.index');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Route::get('/admin/dashboard', [AdminController::class, 'adminHome'])->name('admin.home');

Route::get('/user', [Usercontroller::class, 'home'])->name('home');
Route::get('/user/logout', [Usercontroller::class, 'userLogout'])->name('user.logout');

//Admin Management Group Middleware
Route::middleware(['auth', 'role:admin'])->group(function () {

    Route::get('/admin/dashboard', [AdminController::class, 'adminHome'])->name('admin.home');
    Route::get('/admin/profile', [AdminController::class, 'AdminProfile'])->name('admin.profile');
    Route::post('/admin/profile/store', [AdminController::class, 'AdminProfileStore'])->name('admin.profile.store');
    Route::get('/admin/change/passowrd', [AdminController::class, 'AdminChangePassword'])->name('admin.change.password');
    Route::post('/admin/update/password', [AdminController::class, 'AdminUpdatePassword'])->name('admin.update.password');

    //Brand
    Route::resource('brand', BrandController::class);
    Route::post('/brand/changeStatus', [BrandController::class, 'brandChangeStatus'])->name('brand.change.status');

    //Category
    Route::resource('category', CategoryController::class);

    //Sub Category
    Route::resource('sub-category', SubCategoryController::class);

    //Attribute Set
    Route::resource('attribute-set', AttributeSetController::class);

    //Attribute
    Route::resource('attribute', AttributeController::class);

    //Product
    Route::resource('product', ProductController::class);

    //Stock
    Route::resource('stock', ProductStockController::class);
    Route::get('/get-stock/{id}', [ProductStockController::class, 'getStock'])->name('get.stock');
    Route::get('/get-attribute/{id}', [ProductStockController::class, 'getAttribute']);



    Route::get('/get-subcategories/{id}', [CategoryController::class, 'getSubcategories']);
    Route::get('/selected-subcategories/{id}', [CategoryController::class, 'selectedSubcategories']);
    Route::post('/uploadmultiimg', [ProductController::class, 'uploadMultiImg'])->name('uploadMultiImg.add');
    Route::get('/deletemultiimg/{id}', [ProductController::class, 'deleteMultiImg'])->name('deleteMultiImg.delete');

 
}); //End Group Admin Middleware




require __DIR__.'/auth.php';
