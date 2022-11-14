<?php

use App\Http\Controllers\admin\AdminController;
use App\Http\Controllers\admin\Auth\ForgotPasswordController;
use App\Http\Controllers\Admin\CategoriesController;
use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\admin\Auth\LoginController;
use App\Http\Controllers\admin\Auth\ResetPasswordController;
use App\Http\Controllers\admin\OrderController as AdminOrderController;
use App\Http\Controllers\admin\PermissionController;
use App\Http\Controllers\admin\ProductController;
use App\Http\Controllers\admin\StoreController;
use App\Http\Controllers\admin\TagController;
use App\Http\Controllers\admin\TestController;
use App\Http\Controllers\admin\UserController;
use App\Http\Controllers\front\CartController;
use App\Http\Controllers\front\CheckoutController;
use App\Http\Controllers\front\CustomLoginController;
use App\Http\Controllers\front\IndexController;
use App\Http\Controllers\front\FrontProductController;
use App\Http\Controllers\front\OrderController;
use App\Http\Controllers\front\SocialLoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LocalizationController;
use App\Http\Middleware\CheckUserType;
use GuzzleHttp\Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//dashboard ROUTES
Route::group(['prefix' => 'dashboard', 'namespace' => 'admin'], function () {
    Route::group(['middleware' => ['auth:admin']], function () {
       
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        //CATEGORIES ROUTES
        Route::group(['prefix' => 'categories'], function () {
            Route::get('/', [CategoriesController::class, 'index'])->name('categories');
            Route::post('/AjaxDT', [CategoriesController::class, 'AjaxDT']);
            Route::get('/create', [CategoriesController::class, 'create'])->name('categories.create');
            Route::post('/store', [CategoriesController::class, 'store'])->name('categories.store');
            Route::get('/edit/{id}', [CategoriesController::class, 'edit'])->name('categories.edit');
            Route::put('/update/{id}', [CategoriesController::class, 'update'])->name('categories.update');
            Route::get('/delete/{id}', [CategoriesController::class, 'delete'])->name('categories.delete');
            Route::get('/show/{id}', [CategoriesController::class, 'show'])->name('categories.show');
        });
        //PRODUCT ROUTES
        Route::group(['prefix' => 'products'], function () {
            Route::get('/', [ProductController::class, 'index'])->name('products');
            Route::post('/AjaxDT', [ProductController::class, 'AjaxDT']);
            Route::get('/create', [ProductController::class, 'create'])->name('products.create');
            Route::post('/store', [ProductController::class, 'store'])->name('products.store');
            Route::get('/edit/{id}', [ProductController::class, 'edit'])->name('products.edit');
            Route::put('/update/{id}', [ProductController::class, 'update'])->name('products.update');
            Route::get('/delete/{id}', [ProductController::class, 'delete'])->name('products.delete');
            Route::post('/product/removeImage/{media_id}', [ProductController::class, 'removeImage'])->name('products.media.destroy');
            Route::get('/show/{id}', [ProductController::class, 'show'])->name('products.show');
            Route::get('/get-products', [ProductController::class, 'getProducts']);
            Route::post('/search' , [ProductController::class , 'search'])->name('product.search');
            
        });

        //tags ROUTES
        Route::group(['prefix' => 'tags'], function () {
            Route::get('/', [TagController::class, 'index'])->name('tags');
            Route::post('/AjaxDT', [TagController::class, 'AjaxDT']);
            Route::get('/create', [TagController::class, 'create'])->name('tags.create');
            Route::post('/store', [TagController::class, 'store'])->name('tags.store');
            Route::get('/edit/{id}', [TagController::class, 'edit'])->name('tags.edit');
            Route::put('/update/{id}', [TagController::class, 'update'])->name('tags.update');
            Route::get('/delete/{id}', [TagController::class, 'delete'])->name('tags.delete');
        });

        //admins ROUTES
        Route::group(['prefix' => 'admins'], function () {
            Route::get('/', [AdminController::class, 'index'])->name('admins');
            Route::post('/AjaxDT', [AdminController::class, 'AjaxDT']);
            Route::get('/create', [AdminController::class, 'create'])->name('admins.create');
            Route::post('/store', [AdminController::class, 'store'])->name('admins.store');
            Route::get('/edit/{id}', [AdminController::class, 'edit'])->name('admins.edit');
            Route::put('/update/{id}', [AdminController::class, 'update'])->name('admins.update');
            Route::get('/delete/{id}', [AdminController::class, 'delete'])->name('admins.delete');
            Route::get('/admin_permissions/{id}', [AdminController::class, 'admin_permissions'])->name('admins.permissions.edit');
            Route::post('/permissions_AjaxDT/{id}', [AdminController::class, 'AjaxDT_Permission']);
            Route::put('/set_permission/{id}', [AdminController::class, 'set_permission'])->name('admins.set_permission');
        });

        //Permission ROUTES
        Route::group(['prefix' => 'permissions'], function () {
            Route::get('/', [PermissionController::class, 'index'])->name('permissions');
            Route::post('/AjaxDT', [PermissionController::class, 'AjaxDT']);
            Route::get('/create', [PermissionController::class, 'create'])->name('permissions.create');
            Route::post('/store', [PermissionController::class, 'store'])->name('permissions.store');
            Route::get('/edit/{id}', [PermissionController::class, 'edit'])->name('permissions.edit');
            Route::put('/update/{id}', [PermissionController::class, 'update'])->name('permissions.update');
            Route::get('/delete/{id}', [PermissionController::class, 'delete'])->name('permissions.delete');
        });

        //orders routes
        Route::group(['prefix' => 'orders'], function () {
            Route::get('/', [OrderController::class, 'index'])->name('orders');
            Route::post('/AjaxDT', [OrderController::class, 'AjaxDT']);
            Route::get('/delete/{id}', [OrderController::class, 'delete'])->name('orders.delete');
            Route::get('/printpdf/{order}', [AdminOrderController::class, 'printPdf'])->name('orders.pdf');
            Route::get('/show/{order}', [OrderController::class, 'show'])->name('show.order');
        });

        //users routes
        Route::group(['prefix' => 'users'], function () {
            Route::get('/', [UserController::class, 'index'])->name('users');
            Route::post('/AjaxDT', [UserController::class, 'AjaxDT']);
            Route::get('/create', [UserController::class, 'create'])->name('users.create');
            Route::post('/store', [UserController::class, 'store'])->name('users.store');
            Route::get('/delete/{id}', [UserController::class, 'delete'])->name('users.delete');
            Route::get('/edit/{id}', [UserController::class, 'edit'])->name('users.edit');
            Route::put('/update/{id}', [UserController::class, 'update'])->name('users.update');
        });

          //test routes
          Route::group(['prefix' => 'test'], function () {
            Route::get('/create', [TestController::class, 'create'])->name('test.create');
            Route::get('/cities/{id?}', [TestController::class, 'cites'])->name('test.cites');
            Route::get('/cities_en/{id?}', [TestController::class, 'cites_en'])->name('test.cites_en');
            Route::post('/store', [TestController::class, 'store'])->name('test.store');
            Route::get('/get-address', [TestController::class, 'address'])->name('test.address');

        });

        Route::get('/stores/{store}', [StoreController::class, 'index']);

       

        //Logout ROUTES
        Route::post('logout', [LoginController::class, 'logout'])->name('admin.logout');
    });

    //dashboard login ROUTES
    Route::get('/login', [LoginController::class, 'login'])->name('admin.login');
    Route::post('login-store', [LoginController::class, 'store'])->name('admin-login.store');

    //locale route
    Route::get('locale/{lang?}', [LocalizationController::class, 'change'])->name('locale.change');

    // //reset password for admin panel
    // Route::get('admin/password/request', [ForgotPasswordController::class, 'reset_password'])->name('admin.request.password');
    // Route::post('admin/password/email',
    // [ForgotPasswordController::class,'sendResetLinkEmail'])->name('admin.password.email');
    // // Route::get('admin/password/reset/{token}',[ResetPasswordController::class,'showResetForm'])->name('admin.password.reset');
    // Route::post('/password/reset',[ResetPasswordController::class ,'reset'])->name('admin.password.reset');

});



// Route::get('custom/login',[CustomLoginController::class, 'showLoginform'])->name('showLoginform');
// Route::post('custom/login',[CustomLoginController::class, 'login'])->name('custom-login');
// Route::post('logout', [CustomLoginController::class, 'logout'])->name('logout');

// Route::get('/home', [HomeController::class, 'index'])->middleware(['auth:web'])->name('home');

Auth::routes(['verify' => true]);

//front-end ROUTES
Route::group(['namespace' => 'front'], function () {
    Route::get('/', [IndexController::class, 'index'])->name('index');
    Route::get('/products/{product}', [FrontProductController::class, 'show'])->name('product.show');
    //cart routes
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart', [CartController::class, 'store'])->name('cart.store');
    Route::put('/cart-updateQuantity', [CartController::class, 'update'])->name('cart.update');
    Route::put('/cart-delete/{id}', [CartController::class, 'delete'])->name('cart.delete');
    //checkout routes
    Route::get('/checkout', [CheckoutController::class, 'show'])->name('show.checkout');
    Route::post('/checkout', [CheckoutController::class, 'checkout'])->name('checkout.store');
    //orders route
    // Route::get('/orders', [OrderController::class, 'orders'])->name('orders');
    //payment routes
    Route::any('/paypal/callback', [CheckoutController::class, 'paypalCallback'])->name('paypal.callback');
    Route::any('/paypal/cancel', [CheckoutController::class, 'paypalCancel'])->name('paypal.cancel');
    //Social media login
    Route::get('/social/login', [SocialLoginController::class, 'SocailLogin'])->name('social.login');
    Route::get('/social/{provider}/login', [SocialLoginController::class, 'redirect'])->name('social.redirect');
    Route::get('/social/{provider}/callback', [SocialLoginController::class, 'callback'])->name('social.callback');
//search
Route::post('/search' , [IndexController::class , 'search'])->name('search');

});




//example code for cookie
// Route::get('/send-cookie', function () {
    //لما بدي اخزن كوكي وانا ببعت لفيو
    // $cookie = Cookie::queue(Cookie::make('cart','product 2',-10)); // to delete cookie -10 for example

    //لما بدي اخزن كوكي بشكل عام ف الموقع
    // return response('We have set cookie for you')->cookie(Cookie::make('cart','product 1',90));
    // $cart = $request->cookie('cart'); // if i wana to show cookie values

    // return view('admin.dashboard');

    //EncryptCookies لو بدي اخليه م يشفر كوكي معين بروج ع هاد الميدوير وبحط الكوكي الي م بدي اشفره
// });
