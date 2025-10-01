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
use App\Http\Controllers\admin\OrderController;
use App\Http\Controllers\admin\SubCategoryController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\ProductStockController;
use App\Http\Controllers\LangController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\admin\SettingController;
use App\Http\Controllers\AgentController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\ForgotPasswordController;

Route::get('/lang-change/{lang}', [LangController::class, 'langChange'])->name('lang.change');
Route::get('/', [indexController::class, 'index'])->name('index');
Route::get('/category-details/{slug}', [indexController::class, 'categoryDetails'])->name('category.details');
Route::get('/brand-details/{id}', [indexController::class, 'brandDetails'])->name('brand.details');
Route::get('/shops', [indexController::class, 'shops'])->name('all.shops');
Route::get('/product-details/{id}', [indexController::class, 'productDetails'])->name('product.details');

// Show agent register form
Route::get('/agent/register/', [AgentController::class, 'AgentRegisterShow'])->name('agentregister.show');
// Handle agent registration
Route::post('/agent/register/store', [AgentController::class, 'AgentRegister'])->name('agentregister.store');


Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::get('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');

//buy now
Route::post('/buy/now', [CartController::class, 'buyNow'])->name('buy.now');
Route::get('/checkout', [CartController::class, 'checkout'])->name('checkout');

//Confirm Order
Route::post('/confirm/order', [indexController::class, 'confirmOrder'])->name('confirm.order');

//SearchProduct
Route::post('/product/search', [indexController::class, 'productSearch'])->name('product.search');
Route::get('/mobile/product/search', [indexController::class, 'mobileProductSearch'])->name('mobile.product.search');

Route::middleware(['auth', 'role:user'])->group(function () {
    // Route::get('/user', [Usercontroller::class, 'home'])->name('home');
    Route::get('/user-dashboard', [UserController::class, 'userDashboard'])->name('user.dashboard');
    Route::get('/user/logout', [Usercontroller::class, 'userLogout'])->name('user.logout');
}); //End Group Admin Middleware

//Admin Management Group Middleware
Route::middleware(['auth', 'role:admin'])->group(function () {

    Route::get('/admin/dashboard', [AdminController::class, 'adminHome'])->name('admin.home');
    Route::get('/admin/profile', [AdminController::class, 'AdminProfile'])->name('admin.profile');
    Route::post('/admin/profile/store', [AdminController::class, 'AdminProfileStore'])->name('admin.profile.store');
    Route::get('/admin/change/passowrd', [AdminController::class, 'AdminChangePassword'])->name('admin.change.password');
    Route::post('/admin/update/password', [AdminController::class, 'AdminUpdatePassword'])->name('admin.update.password');
    Route::get('/admin/logout', [AdminController::class, 'adminLogout'])->name('admin.logout');

    //Brand
    Route::resource('brand', BrandController::class);
    Route::post('/brand/changeStatus', [BrandController::class, 'brandChangeStatus'])->name('brand.change.status');
    Route::delete('/delte-brand/{id}', [BrandController::class, 'brandDelete'])->name('brand.delete');

    //Category
    Route::resource('category', CategoryController::class);
    Route::post('/category/changeStatus', [CategoryController::class, 'categoryChangeStatus'])->name('category.change.status');
    Route::delete('/delte-category/{id}', [CategoryController::class, 'categoryDelete'])->name('category.delete');

    //Sub Category
    Route::resource('sub-category', SubCategoryController::class);
    Route::post('/subcategory/changeStatus', [SubCategoryController::class, 'subcategoryChangeStatus'])->name('subcategory.change.status');
    Route::delete('/delte-subcategory/{id}', [SubCategoryController::class, 'subCategoryDelete'])->name('subcategory.delete');

    //Attribute Set
    Route::resource('attribute-set', AttributeSetController::class);
    Route::post('/attribute-set/changeStatus', [AttributeSetController::class, 'attributesetChangeStatus'])->name('attribute-set.change.status');
    Route::delete('/delte-attribute-set/{id}', [AttributeSetController::class, 'attributesetDelete'])->name('attributeset.delete');

    //Attribute
    Route::resource('attribute', AttributeController::class);
    Route::post('/attribute/changeStatus', [AttributeController::class, 'attributeChangeStatus'])->name('attribute.change.status');
    Route::delete('/delte-attribute/{id}', [AttributeController::class, 'attributeDelete'])->name('attribute.delete');

    //Product
    Route::resource('product', ProductController::class);
    Route::get('/product_inactive', [ProductController::class, 'inactive_product'])->name('inactive.product');
    Route::post('/product/changeStatus', [ProductController::class, 'productChangeStatus'])->name('product.change.status');
    Route::post('/product/{id}', [ProductController::class, 'productDelete'])->name('product.delete');


    //Stock
    Route::resource('stock', ProductStockController::class);
    Route::get('/get-stock/{id}', [ProductStockController::class, 'getStock'])->name('get.stock');
    Route::get('/get-attribute/{id}', [ProductStockController::class, 'getAttribute']);
    Route::get('/get-edit-attribute/{id}', [ProductStockController::class, 'getEditAttribute']);
    Route::get('/get-stock-attribute/{id}', [ProductStockController::class, 'getStockAttribute']);
    Route::post('/add-attribute-wisestock', [ProductStockController::class, 'addAttributeWiseStock'])->name('attributeWise.stock.store');
    Route::delete('/delete/stock/{id}', [ProductStockController::class, 'deleteStock'])->name('stocks.destroy');
    Route::get('/stock-out/{id}', [ProductStockController::class, 'stockOut'])->name('stock.out');
    Route::get('/stock-in/{id}', [ProductStockController::class, 'stockIn'])->name('stock.in');


    Route::get('/get-subcategories/{id}', [CategoryController::class, 'getSubcategories']);
    Route::get('/selected-subcategories/{id}', [CategoryController::class, 'selectedSubcategories']);
    Route::post('/uploadmultiimg', [ProductController::class, 'uploadMultiImg'])->name('uploadMultiImg.add');
    Route::get('/deletemultiimg/{id}', [ProductController::class, 'deleteMultiImg'])->name('deleteMultiImg.delete');


    // Order
    Route::get('/all/order', [OrderController::class, 'allOrder'])->name('all.order');
    Route::get('/order/details/{id}', [OrderController::class, 'orderDetails'])->name('order.details');
    Route::get('/order/confirm/{id}', [OrderController::class, 'orderConfirm'])->name('order.confirm');


    // Site Setting All Route
    Route::controller(SettingController::class)->group(function () {
        Route::get('/site/setting', 'siteSetting')->name('site.setting');
        Route::post('/update/featured_products', 'updateFeaturedProducts')->name('update.featured.products');
        Route::get('/delte/featured_products/{id}', 'deleteFeaturedProducts')->name('delete.featured.products');
    });
}); //End Group Admin Middleware

//Agent Management Group Middleware
Route::middleware(['auth', 'role:agent'])->group(function () {

    Route::get('/agent/dasboard', [AgentController::class, 'AgentDashboard'])->name('agent.dashboard');
    Route::get('/agent/logout', [AgentController::class, 'AgentLogout'])->name('agent.logout');
});

require __DIR__ . '/auth.php';


// Registration OTP verification page
Route::get('/email/verify', [VerifyEmailController::class, 'showVerifyForm'])
    ->name('verify.email');

// OTP submit route
Route::post('/email/verify', [VerifyEmailController::class, 'verifyCode'])
    ->name('verify.email.submit');

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

Route::get('/dashboard', function () {
    return view('dashboard'); // resources/views/dashboard.blade.php
})->name('dashboard');

Route::post('/resend-otp', [RegisteredUserController::class, 'resendOtp'])->name('resend.otp');

// Forgot Password OTP Flow
Route::get('forgot-password', [ForgotPasswordController::class, 'showForgotForm'])->name('forgot.form');
Route::post('forgot-password', [ForgotPasswordController::class, 'sendResetOtp'])->name('forgot.send');

Route::get('forgot-password/otp', [ForgotPasswordController::class, 'showOtpForm'])->name('forgot.otp.form');
Route::post('forgot-password/otp', [ForgotPasswordController::class, 'verifyOtp'])->name('forgot.otp.verify');
