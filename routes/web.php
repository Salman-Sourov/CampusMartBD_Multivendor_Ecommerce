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
use App\Http\Controllers\indexController;
use App\Http\Controllers\ProductStockController;
use App\Http\Controllers\LangController;
use App\Http\Controllers\CartController;

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

// Route::get('/', function () {
//     return view('frontend.index');
// });

Route::get('/lang-change/{lang}', [LangController::class, 'langChange'])->name('lang.change');
Route::get('/', [indexController::class, 'index'])->name('index');
Route::get('/category-details/{id}',[indexController::class, 'categoryDetails'])->name('category.details');
Route::get('/brand-details/{id}',[indexController::class, 'brandDetails'])->name('brand.details');
Route::get('/product-details/{id}',[indexController::class, 'productDetails'])->name('product.details');

Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');



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
    Route::post('/category/changeStatus', [CategoryController::class, 'categoryChangeStatus'])->name('category.change.status');

    //Sub Category
    Route::resource('sub-category', SubCategoryController::class);
    Route::post('/subcategory/changeStatus', [SubCategoryController::class, 'subcategoryChangeStatus'])->name('subcategory.change.status');

    //Attribute Set
    Route::resource('attribute-set', AttributeSetController::class);
    Route::post('/attribute-set/changeStatus', [AttributeSetController::class, 'attributesetChangeStatus'])->name('attribute-set.change.status');

    //Attribute
    Route::resource('attribute', AttributeController::class);

    //Product
    Route::resource('product', ProductController::class);
    Route::get('/product_inactive', [ProductController::class, 'inactive_product'])->name('inactive.product');
    Route::post('/product/changeStatus', [ProductController::class, 'productChangeStatus'])->name('product.change.status');

    //Stock
    Route::resource('stock', ProductStockController::class);
    Route::get('/get-stock/{id}', [ProductStockController::class, 'getStock'])->name('get.stock');
    Route::get('/get-attribute/{id}', [ProductStockController::class, 'getAttribute']); 
    Route::get('/get-edit-attribute/{id}', [ProductStockController::class, 'getEditAttribute']);
    Route::get('/get-stock-attribute/{id}', [ProductStockController::class, 'getStockAttribute']);
    Route::post('/add-attribute-wisestock', [ProductStockController::class, 'addAttributeWiseStock'])->name('attributeWise.stock.store');

    Route::get('/get-subcategories/{id}', [CategoryController::class, 'getSubcategories']);
    Route::get('/selected-subcategories/{id}', [CategoryController::class, 'selectedSubcategories']);
    Route::post('/uploadmultiimg', [ProductController::class, 'uploadMultiImg'])->name('uploadMultiImg.add');
    Route::get('/deletemultiimg/{id}', [ProductController::class, 'deleteMultiImg'])->name('deleteMultiImg.delete');
 
}); //End Group Admin Middleware




require __DIR__.'/auth.php';
