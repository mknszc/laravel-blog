<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Front\Homepage as Homepage;
use App\Http\Controllers\Back\Dashboard as Dashboard;
use App\Http\Controllers\Back\AuthController as AuthController;
use App\Http\Controllers\Back\ArticleController as ArticleController;
use App\Http\Controllers\Back\CategoryController as CategoryController;
use App\Http\Controllers\Back\PageController as PageController;
use App\Http\Controllers\Back\ConfigController as ConfigController;


Route::get('/bakim', function() {

    return view('front.offline');
});
/*
|--------------------------------------------------------------------------
| Front
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*Route::get('/', function () {
    return view('front.homepage');
});
*/

Route::get('/', [Homepage::class, 'index'])->name('homepage');
Route::get('/iletisim', [Homepage::class, 'contact'])->name('contact');
Route::post('/iletisim', [Homepage::class, 'contactPost'])->name('contact.post');
Route::get('/blog/{categorySlug}/{slug}', [Homepage::class, 'single'])->name('single');
Route::get('/kategori/{slug}', [Homepage::class, 'category'])->name('category');
Route::get('/{sayfa}', [Homepage::class, 'page'])->name('page');

/*
|--------------------------------------------------------------------------
| Back
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*Route::get('/', function () {
    return view('front.homepage');
});
*/

Route::prefix('admin')->name('admin.')->middleware('isLogin')->group(function() {
    Route::get('/giris', [AuthController::class, 'login'])->name('login');
    Route::post('/giris', [AuthController::class, 'loginPost'])->name('login.post');
});

Route::prefix('admin')->name('admin.')->middleware('isAdmin')->group(function() {
    Route::get('/panel', [Dashboard::class, 'index'])->name('dashboard');
    Route::get('/cikis', [AuthController::class, 'logout'])->name('logout');

    Route::get('makaleler/silinenler', [ArticleController::class, 'trashed'])->name('trashed');
    Route::get('switch', [ArticleController::class, 'switch'])->name('switch');
    Route::get('deleteArticle/{id}', [ArticleController::class, 'delete'])->name('delete.article');
    Route::get('hardDeleteArticle/{id}', [ArticleController::class, 'hardDelete'])->name('hard.delete.article');
    Route::get('recyclerticle/{id}', [ArticleController::class, 'recycle'])->name('recycle.article');
    Route::resource('makaleler', ArticleController::class);

    Route::get('kategoriler', [CategoryController::class, 'index'])->name('categories');
    Route::get('kategori/status', [CategoryController::class, 'switch'])->name('category.switch');
    Route::post('kategori/ekle', [CategoryController::class, 'create'])->name('category.create');
    Route::post('kategori/guncelle', [CategoryController::class, 'update'])->name('category.update');
    Route::post('kategori/sil', [CategoryController::class, 'delete'])->name('category.delete');
    Route::get('kategori/getir', [CategoryController::class, 'getData'])->name('category.getData');

    Route::get('sayfalar', [PageController::class, 'index'])->name('page.index');
    Route::get('sayfa/switch', [PageController::class, 'switch'])->name('page.switch');
    Route::get('sayfalar/olustur', [PageController::class, 'create'])->name('page.create');
    Route::post('sayfalar/olustur', [PageController::class, 'store'])->name('page.store');
    Route::get('sayfalar/guncelle/{id}', [PageController::class, 'edit'])->name('page.edit');
    Route::post('sayfalar/guncelle/{id}', [PageController::class, 'update'])->name('page.update');
    Route::get('sayfalar/sil/{id}', [PageController::class, 'delete'])->name('page.delete');
    Route::get('sayfa/siralama', [PageController::class, 'orders'])->name('page.orders');

    Route::get('ayarlar', [ConfigController::class, 'index'])->name('config.index');
    Route::post('ayarlar/update', [ConfigController::class, 'update'])->name('config.update');

});