<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CitiesController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\CKEditorController;
use App\Http\Controllers\Users\InfoController;
use App\Http\Controllers\Users\PostController;
use App\Http\Controllers\Auth\SocialController;
use App\Http\Controllers\Users\CategoryController;

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

Route::get('/', function () {
    return redirect('./home');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

//Social Login
// Google login
Route::get('/redirect_google', [SocialController::class, 'redirect_google'])->name('redirectgoogle');
Route::get('/google_callback', [SocialController::class, 'processGoogleLogin']);
//Facebook login
Route::get('/redirect_facebook', [SocialController::class, 'redirect_facebook'])->name('redirectfacebook');
Route::get('/facebook_callback', [SocialController::class, 'processFacebookLogin']);
//Route User
Route::prefix('user')->group(function () {
    Route::get('/', [InfoController::class, 'show'])->name('userInfo')->middleware('auth');
    Route::get('/{id}', [InfoController::class, 'user_view'])->whereNumber('id')->name('viewInfo');
    Route::get('/edit', [InfoController::class, 'edit'])->name('userEdit')->middleware('auth');
    Route::post('/edit/store', [InfoController::class, 'store'])->name('userEdit.Store')->middleware('auth');
    Route::resource('/post', PostController::class)->names('post');
    Route::get('/post/create', [PostController::class, 'create'])->name('post.create')->middleware('auth');
});

Route::post('/ckeditor/upload', [CKEditorController::class, 'upload'])->name('ckeditor.image-upload');
Route::get('/getDistricts/{id?}', [CitiesController::class, 'getDistricts'])->whereNumber('id')->name('getDistricts');
Route::get('/getWards/{id?}', [CitiesController::class, 'getWards'])->whereNumber('id')->name('getWards');

Route::resource('/category', CategoryController::class, ['only' => ['index', 'show']])->names('category');

Route::get('/search', [SearchController::class, 'search'])->name('search');

Route::middleware('auth', 'role:admin')->prefix('admincp')->group(function () {
    Route::get('/', [AdminController::class, 'show'])->name('admin.show');
    Route::get('/user', [AdminController::class, 'user_list'])->name('admin.user');
    Route::get('/user/{id}', [AdminController::class, 'user_show'])->name('admin.user.show');
    Route::post('/user/{id}', [AdminController::class, 'store'])->name('admin.user.store');
    Route::get('/lockuser/{id}', [AdminController::class, 'checklookuser'])->whereNumber('id')->name('admin.user.lock');
    Route::get('/unlockuser/{id}', [AdminController::class, 'checklookuser'])->whereNumber('id')->name('admin.user.unlock');
    Route::get('/upuser/{id}', [AdminController::class, 'checkadminuser'])->whereNumber('id')->name('admin.user.up');
    Route::get('/downuser/{id}', [AdminController::class, 'checkadminuser'])->whereNumber('id')->name('admin.user.down');
    Route::get('/posts', [AdminController::class, 'post_list'])->name('admin.post.show');
    Route::get('/posts-check-vip', [AdminController::class, 'post_list_check_vips'])->name('admin.vips.check');
    Route::get('/posts-vip', [AdminController::class, 'post_list_vips'])->name('admin.vips.show');
    Route::get('/posts-validate', [AdminController::class, 'post_list_validate'])->name('admin.validate.show');
    Route::get('/posts-block', [AdminController::class, 'post_postblock_validate'])->name('admin.postblock.show');
    Route::get('/posts-up/{id}', [AdminController::class, 'upVip'])->name('admin.vips.up');
    Route::get('/posts-down/{id}', [AdminController::class, 'downVip'])->name('admin.vips.down');
    Route::get('/posts-check/{id}', [AdminController::class, 'checkpost'])->name('admin.post.check');
    Route::get('/category', [CategoryController::class, 'list'])->name('admin.category.list');
    Route::put('/category', [CategoryController::class, 'store'])->name('admin.category.store');
    Route::delete('/category/{category}', [CategoryController::class, 'destroy'])->name('admin.category.destroy');
    Route::get('/category/create', [CategoryController::class, 'create'])->name('admin.category.creat');
    Route::get('/category/{category}/edit', [CategoryController::class, 'edit'])->name('admin.category.edit');
    Route::put('/category/{category}', [CategoryController::class, 'update'])->name('admin.category.update');
});
