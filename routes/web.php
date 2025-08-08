<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Client\RestaurantController;

Route::get('/', [UserController::class, 'Index'])->name('index');

Route::get('/dashboard', function () {
    return view('frontend.dashboard.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::post('/profile/store', [UserController::class, 'ProfileStore'])->name('profile.store');
    Route::get('/user/logout', [UserController::class, 'UserLogout'])->name('user.logout');
    Route::get('/change/password', [UserController::class, 'ChangePassword'])->name('change.password');
    Route::post('/user/password/update', [UserController::class, 'UserPasswordUpdate'])->name('user.password.update');
});

require __DIR__.'/auth.php';

// Group for admin routes with the '/admin' prefix
Route::prefix('admin')->group(function () {
    // Public admin routes (no middleware)
    Route::get('/login', [AdminController::class, 'AdminLogin'])->name('admin.login');
    Route::post('/login_submit', [AdminController::class, 'AdminLoginSubmit'])->name('admin.login_submit');
    Route::get('/forget_password', [AdminController::class, 'AdminForgetPassword'])->name('admin.forget_password');
    Route::post('/password_submit', [AdminController::class, 'AdminPasswordSubmit'])->name('admin.password_submit');
    Route::get('/reset-password/{token}/{email}', [AdminController::class, 'AdminResetPassword']);
    Route::post('/rest_password_submit', [AdminController::class, 'AdminResetPasswordSubmit'])->name('admin.reset_password_submit');

    // Protected admin routes
    Route::middleware('admin')->group(function(){
        Route::get('/dashboard', [AdminController::class, 'AdminDashboard'])->name('admin.dashboard');
        Route::get('/logout', [AdminController::class, 'AdminLogout'])->name('admin.logout');
        Route::get('/profile', [AdminController::class, 'AdminProfile'])->name('admin.profile');
        Route::post('/profile/store', [AdminController::class, 'AdminProfileStore'])->name('admin.profile.store');
        Route::get('/change/password', [AdminController::class, 'AdminChangePassword'])->name('admin.change.password');
        Route::post('/admin/password/update', [AdminController::class, 'AdminPasswordUpdate'])->name('admin.password.update');

        /// All Admin Category
        Route::controller(CategoryController::class)->group(function(){
            Route::get('/all/category', 'AllCategory')->name('all.category');
            Route::get('/add/category', 'AddCategory')->name('add.category');
            Route::post('/store/category', 'StoreCategory')->name('category.store');
            Route::get('/edit/category/{id}', 'EditCategory')->name('edit.category');
            Route::post('/update/category', 'UpdateCategory')->name('category.update');
            Route::get('/delete/category/{id}', 'DeleteCategory')->name('delete.category');
        });

        /// All Admin City
        Route::controller(CategoryController::class)->group(function(){
            Route::get('/all/city', 'AllCity')->name('all.city');
            Route::post('/store/city', 'StoreCity')->name('city.store');
            Route::get('/edit/city/{id}', 'EditCity');
            Route::post('/update/city', 'UpdateCity')->name('city.update');
            Route::get('/delete/city/{id}', 'DeleteCity')->name('delete.city');
        });
    });
});

// Group for client routes with the '/client' prefix
Route::prefix('client')->group(function () {
            // Public client routes (no middleware)
            Route::get('/login', [ClientController::class, 'ClientLogin'])->name('client.login');
            Route::get('/register', [ClientController::class, 'ClientRegister'])->name('client.register');
            Route::post('/register/submit', [ClientController::class, 'ClientRegisterSubmit'])->name('client.register.submit');
            Route::post('/login_submit', [ClientController::class, 'ClientLoginSubmit'])->name('client.login_submit');

            // Protected client routes
            Route::middleware('client')->group(function(){
                Route::get('/dashboard', [ClientController::class, 'ClientDashboard'])->name('client.dashboard');
                Route::get('/logout', [ClientController::class, 'ClientLogout'])->name('client.logout');
                Route::get('/profile', [ClientController::class, 'ClientProfile'])->name('client.profile');
                Route::post('/profile/store', [ClientController::class, 'ClientProfileStore'])->name('client.profile.store');
                Route::get('/change/password', [ClientController::class, 'ClientChangePassword'])->name('client.change.password');
                Route::post('/password/update', [ClientController::class, 'ClientPasswordUpdate'])->name('client.password.update');

            // RestaurantController routes
            Route::controller(RestaurantController::class)->group(function(){
                Route::get('/all/menu', 'AllMenu')->name('all.menu');
                Route::get('/add/menu', 'AddMenu')->name('add.menu');
                Route::post('/store/menu', 'StoreMenu')->name('menu.store');
                Route::get('/edit/menu/{id}', 'EditMenu')->name('edit.menu');
                Route::post('/update/menu', 'UpdateMenu')->name('menu.update');
                Route::get('/delete/menu/{id}', 'DeleteMenu')->name('delete.menu');

            Route::controller(RestaurantController::class)->group(function(){
                    Route::get('/all/product', 'AllProduct')->name('all.product');
                    Route::get('/add/product', 'AddProduct')->name('add.product');
                    Route::post('/store/product', 'StoreProduct')->name('product.store');
                    Route::get('/edit/product/{id}', 'EditProduct')->name('edit.product');
                    Route::post('/update/product', 'UpdateProduct')->name('product.update');
                    Route::get('/delete/product/{id}', 'DeleteProduct')->name('delete.product');
                    Route::get('/changeStatus', 'ChangeStatus')->name('change.status');

            Route::controller(RestaurantController::class)->group(function(){
                    Route::get('/all/gallery', 'AllGallery')->name('all.gallery');
                    Route::get('/add/gallery', 'AddGallery')->name('add.gallery');
                    Route::post('/store/gallery', 'StoreGallery')->name('gallery.store');
                    Route::get('/edit/gallery/{id}', 'EditGallery')->name('edit.gallery');
                    Route::post('/update/gallery', 'UpdateGallery')->name('gallery.update');
                    Route::get('/delete/gallery/{id}', 'DeleteGallery')->name('delete.gallery');
                });
            });
        });
    });
});




