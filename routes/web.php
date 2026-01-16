<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LangController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ProductStockController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\AgentController;
use App\Http\Controllers\user\UserController;
use App\Http\Controllers\admin\AdminController;
use App\Http\Controllers\admin\BrandController;
use App\Http\Controllers\admin\CategoryController;
use App\Http\Controllers\admin\SubCategoryController;
use App\Http\Controllers\admin\AttributeController;
use App\Http\Controllers\admin\AttributeSetController;
use App\Http\Controllers\admin\ProductController;
use App\Http\Controllers\admin\OrderController;
use App\Http\Controllers\admin\SettingController;
use App\Http\Controllers\admin\InstitutionsController;

use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

// Default Pages
Route::get('/register', fn() => view('auth.register'))->name('register');

// Language Change
Route::get('/lang-change/{lang}', [LangController::class, 'langChange'])->name('lang.change');

// Homepage & Product Display
Route::get('/', [IndexController::class, 'index'])->name('index');
Route::get('/category-details/{slug}', [IndexController::class, 'categoryDetails'])->name('category.details');
// Route::get('/brand-details/{id}', [IndexController::class, 'brandDetails'])->name('brand.details');
Route::get('/shops', [IndexController::class, 'shops'])->name('all.shops');
Route::get('/shop/{id}', [IndexController::class, 'shopDetails'])->name('shop.details');
Route::get('/product/{shop}/{slug}', [IndexController::class, 'productDetails'])->name('product.details');

// Agent Registration
Route::get('/agent/register', [AgentController::class, 'AgentRegisterShow'])->name('agentregister.show');
Route::post('/agent/register/store', [AgentController::class, 'AgentRegister'])->name('agentregister.store');

// Cart Management
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::get('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');

// Buy Now & Checkout
Route::post('/buy/now', [CartController::class, 'buyNow'])->name('buy.now');
Route::get('/checkout', [CartController::class, 'checkout'])->name('checkout');

// Order Confirmation
Route::post('/confirm/order', [IndexController::class, 'confirmOrder'])->name('confirm.order');

// Product Search
Route::post('/product/search', [IndexController::class, 'productSearch'])->name('product.search');
Route::get('/mobile/product/search', [IndexController::class, 'mobileProductSearch'])->name('mobile.product.search');


/*
|--------------------------------------------------------------------------
| User Routes (Requires Authentication & User Role)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/user-dashboard', [UserController::class, 'userDashboard'])->name('user.dashboard');
    Route::get('/user/logout', [UserController::class, 'userLogout'])->name('user.logout');
});


/*
|--------------------------------------------------------------------------
| Admin Routes (Requires Authentication & Admin Role)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin'])->group(function () {

    // Admin Profile & Dashboard
    Route::get('/admin/dashboard', [AdminController::class, 'adminHome'])->name('admin.home');
    Route::get('/admin/profile', [AdminController::class, 'AdminProfile'])->name('admin.profile');
    Route::post('/admin/profile/store', [AdminController::class, 'AdminProfileStore'])->name('admin.profile.store');
    Route::get('/admin/change/passowrd', [AdminController::class, 'AdminChangePassword'])->name('admin.change.password');
    Route::post('/admin/update/password', [AdminController::class, 'AdminUpdatePassword'])->name('admin.update.password');
    Route::get('/admin/logout', [AdminController::class, 'adminLogout'])->name('admin.logout');

    // Brand Management
    // Route::resource('brand', BrandController::class);
    // Route::post('/brand/changeStatus', [BrandController::class, 'brandChangeStatus'])->name('brand.change.status');
    // Route::delete('/delete-brand/{id}', [BrandController::class, 'brandDelete'])->name('brand.delete');

    // Category Management
    Route::resource('category', CategoryController::class);
    Route::post('/category/changeStatus', [CategoryController::class, 'categoryChangeStatus'])->name('category.change.status');
    Route::delete('/delete-category/{id}', [CategoryController::class, 'categoryDelete'])->name('category.delete');

    // Subcategory Management
    Route::resource('sub-category', SubCategoryController::class);
    Route::post('/subcategory/changeStatus', [SubCategoryController::class, 'subcategoryChangeStatus'])->name('subcategory.change.status');
    Route::delete('/delete-subcategory/{id}', [SubCategoryController::class, 'subCategoryDelete'])->name('subcategory.delete');

    // Attribute Set Management
    Route::resource('attribute-set', AttributeSetController::class);
    Route::post('/attribute-set/changeStatus', [AttributeSetController::class, 'attributesetChangeStatus'])->name('attribute-set.change.status');
    Route::delete('/delete-attribute-set/{id}', [AttributeSetController::class, 'attributesetDelete'])->name('attributeset.delete');

    // Attribute Management
    Route::resource('attribute', AttributeController::class);
    Route::post('/attribute/changeStatus', [AttributeController::class, 'attributeChangeStatus'])->name('attribute.change.status');
    Route::delete('/delete-attribute/{id}', [AttributeController::class, 'attributeDelete'])->name('attribute.delete');


    // Order Management
    Route::get('/all/order', [OrderController::class, 'allOrder'])->name('all.order');
    Route::get('/order/details/{id}', [OrderController::class, 'orderDetails'])->name('order.details');
    Route::get('/order/confirm/{id}', [OrderController::class, 'orderConfirm'])->name('order.confirm');

    // Site Settings
    Route::controller(SettingController::class)->group(function () {
        Route::get('/site/setting', 'siteSetting')->name('site.setting');
        Route::post('/update/featured_products', 'updateFeaturedProducts')->name('update.featured.products');
        Route::get('/delete/featured_products/{id}', 'deleteFeaturedProducts')->name('delete.featured.products');
    });

    // Institutions Management
    Route::resource('institutions', InstitutionsController::class);
    Route::post('/institutions/change-status', [InstitutionsController::class, 'institutionsChangeStatus'])->name('institutions.change.status');
    Route::delete('/delete-institution/{id}', [InstitutionsController::class, 'institutionsDelete'])->name('institutions.delete');

    // Seller Verification
    Route::controller(UserController::class)->group(function () {
        Route::get('/seller/verification', 'verificationIndex')->name('verification.index');
        Route::get('/seller/verification/details/{id}', 'verificationDetails')->name('verification.details');
        Route::get('/seller/verification/confirm/{id}', 'verificationConfirm')->name('verification.confirm');
        Route::get('/seller/verification/reject/{id}', 'verificationReject')->name('verification.reject');
        Route::get('/all/sellers', 'allSellers')->name('sellers.index');
    });
});


/*
|--------------------------------------------------------------------------
| Agent Routes (Requires Authentication & Agent Role)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:agent'])->group(function () {
    Route::get('/agent/dashboard', [AgentController::class, 'AgentDashboard'])->name('agent.dashboard');
    Route::get('/agent/logout', [AgentController::class, 'AgentLogout'])->name('agent.logout');
    Route::get('/agent/profile', [AgentController::class, 'AgentProfile'])->name('agent.profile');
    Route::post('/agent/profile/store', [AgentController::class, 'AgentProfileStore'])->name('agent.profile.store');
    Route::get('/agent/change/passowrd', [AgentController::class, 'AgentChangePassword'])->name('agent.change.password');
    Route::post('/agent/update/password', [AgentController::class, 'AgentUpdatePassword'])->name('agent.update.password');
    Route::post('/agent/verification', [AgentController::class, 'AgentVerification'])->name('agent.verification');

    Route::prefix('agent')->group(function () {
        // Product Management
        Route::resource('product', ProductController::class);
        Route::get('/product_inactive', [ProductController::class, 'inactive_product'])->name('inactive.product');
        Route::post('/product/changeStatus', [ProductController::class, 'productChangeStatus'])->name('product.change.status');
        Route::post('/product/{id}', [ProductController::class, 'productDelete'])->name('product.delete');

        // Category AJAX Helpers
        Route::get('/get-subcategories/{id}', [CategoryController::class, 'getSubcategories']);
        Route::get('/selected-subcategories/{id}', [CategoryController::class, 'selectedSubcategories']);

        // Product Image Upload/Delete
        Route::post('/uploadmultiimg', [ProductController::class, 'uploadMultiImg'])->name('uploadMultiImg.add');
        Route::get('/deletemultiimg/{id}', [ProductController::class, 'deleteMultiImg'])->name('deleteMultiImg.delete');

        // Product Stock Management
        Route::resource('stock', ProductStockController::class);
        Route::get('/get-stock/{id}', [ProductStockController::class, 'getStock'])->name('get.stock');
        Route::get('/get-attribute/{id}', [ProductStockController::class, 'getAttribute']);
        Route::get('/get-edit-attribute/{id}', [ProductStockController::class, 'getEditAttribute']);
        Route::get('/get-stock-attribute/{id}', [ProductStockController::class, 'getStockAttribute']);
        Route::post('/add-attribute-wisestock', [ProductStockController::class, 'addAttributeWiseStock'])->name('attributeWise.stock.store');
        Route::delete('/delete/stock/{id}', [ProductStockController::class, 'deleteStock'])->name('stocks.destroy');
        Route::get('/stock-out/{id}', [ProductStockController::class, 'stockOut'])->name('stock.out');
        Route::get('/stock-in/{id}', [ProductStockController::class, 'stockIn'])->name('stock.in');
    });
});



require __DIR__ . '/auth.php';

/*
|--------------------------------------------------------------------------
| Authentication & Verification Routes
|--------------------------------------------------------------------------
*/

// OTP Email Verification
Route::get('/email/verify', [VerifyEmailController::class, 'showVerifyForm'])->name('verify.email');
Route::post('/email/verify', [VerifyEmailController::class, 'verifyCode'])->name('verify.email.submit');

// Resend OTP
Route::post('/resend-otp', [RegisteredUserController::class, 'resendOtp'])->name('resend.otp');

// Forgot Password (OTP Flow)
Route::get('forgot-password', [ForgotPasswordController::class, 'showForgotForm'])->name('forgot.form');
Route::post('forgot-password', [ForgotPasswordController::class, 'sendResetOtp'])->name('forgot.send');

// Default Laravel Auth Routes
