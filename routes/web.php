<?php

use App\Http\Controllers\Api\LocationController;
use App\Http\Controllers\Backend\AuthController;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\API\DashboardController as  APIDashboardController;
use App\Http\Controllers\Backend\LanguageController;
use App\Http\Controllers\Backend\PermissionController;
use App\Http\Controllers\Backend\PostCatalogueController;
use App\Http\Controllers\Backend\PostController;
use App\Http\Controllers\Backend\UserCatalogueController;
use App\Http\Controllers\Backend\UserController;
use App\Http\Middleware\AuthenticateMiddleware;
use App\Http\Middleware\LoginMiddleware;
use Illuminate\Support\Facades\Route;
use LDAP\Result;

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
    return view('welcome');
});

// Backend route
Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard.index')->middleware(['admin', 'locale']);
Route::get('admin', [AuthController::class, 'index'])->name('auth.admin')->middleware('login');
Route::post('login', [AuthController::class, 'login'])->name('auth.login');
Route::get('logout', [AuthController::class, 'logout'])->name('auth.logout');


Route::middleware(['admin', 'locale'])->prefix('user')->name('user.')->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('index');
    Route::get('create', [UserController::class, 'create'])->name('create');
    Route::post('store', [UserController::class, 'store'])->name('store');
    Route::get('{id}/edit', [UserController::class, 'edit'])->where(['id' => '[0-9]+'])->name('edit');
    Route::post('{id}/update', [UserController::class, 'update'])->where(['id' => '[0-9]+'])->name('update');
    Route::get('{id}/delete', [UserController::class, 'delete'])->where(['id' => '[0-9]+'])->name('delete');
    Route::delete('{id}/destroy', [UserController::class, 'destroy'])->where(['id' => '[0-9]+'])->name('destroy');
});
Route::middleware(['admin', 'locale'])->prefix('user/catalogue')->name('user.catalogue.')->group(function () {
    Route::get('/', [UserCatalogueController::class, 'index'])->name('index');
    Route::get('create', [UserCatalogueController::class, 'create'])->name('create');
    Route::post('store', [UserCatalogueController::class, 'store'])->name('store');
    Route::get('{id}/edit', [UserCatalogueController::class, 'edit'])->where(['id' => '[0-9]+'])->name('edit');
    Route::post('{id}/update', [UserCatalogueController::class, 'update'])->where(['id' => '[0-9]+'])->name('update');
    Route::get('{id}/delete', [UserCatalogueController::class, 'delete'])->where(['id' => '[0-9]+'])->name('delete');
    Route::delete('{id}/destroy', [UserCatalogueController::class, 'destroy'])->where(['id' => '[0-9]+'])->name('destroy');
    Route::get('/permission', [UserCatalogueController::class, 'permission'])->name('permission');
    Route::post('/updatePermission', [UserCatalogueController::class, 'updatePermission'])->name('updatePermission');
});
Route::middleware(['admin', 'locale'])->prefix('language')->name('language.')->group(function () {
    Route::get('/', [LanguageController::class, 'index'])->name('index');
    Route::get('create', [LanguageController::class, 'create'])->name('create');
    Route::post('store', [LanguageController::class, 'store'])->name('store');
    Route::get('{id}/edit', [LanguageController::class, 'edit'])->where(['id' => '[0-9]+'])->name('edit');
    Route::post('{id}/update', [LanguageController::class, 'update'])->where(['id' => '[0-9]+'])->name('update');
    Route::get('{id}/delete', [LanguageController::class, 'delete'])->where(['id' => '[0-9]+'])->name('delete');
    Route::delete('{id}/destroy', [LanguageController::class, 'destroy'])->where(['id' => '[0-9]+'])->name('destroy');
    Route::get('/{id}/switch', [LanguageController::class, 'switchBackendLanguage'])->where(['id' => '[0-9]+'])->name('switch');
    Route::get('/{id}/{languageId}/{model}/translate', [LanguageController::class, 'translate'])->where(['id' => '[0-9]+', 'languageId' => '[0-9]+'])->name('translate');
});

Route::middleware(['admin', 'locale'])->prefix('post/catalogue')->name('post.catalogue.')->group(function () {
    Route::get('/', [PostCatalogueController::class, 'index'])->name('index');
    Route::get('create', [PostCatalogueController::class, 'create'])->name('create');
    Route::post('store', [PostCatalogueController::class, 'store'])->name('store');
    Route::get('{id}/edit', [PostCatalogueController::class, 'edit'])->where(['id' => '[0-9]+'])->name('edit');
    Route::post('{id}/update', [PostCatalogueController::class, 'update'])->where(['id' => '[0-9]+'])->name('update');
    Route::get('{id}/delete', [PostCatalogueController::class, 'delete'])->where(['id' => '[0-9]+'])->name('delete');
    Route::delete('{id}/destroy', [PostCatalogueController::class, 'destroy'])->where(['id' => '[0-9]+'])->name('destroy');
});
Route::middleware(['admin', 'locale'])->prefix('post')->name('post.')->group(function () {
    Route::get('/', [PostController::class, 'index'])->name('index');
    Route::get('create', [PostController::class, 'create'])->name('create');
    Route::post('store', [PostController::class, 'store'])->name('store');
    Route::get('{id}/edit', [PostController::class, 'edit'])->where(['id' => '[0-9]+'])->name('edit');
    Route::post('{id}/update', [PostController::class, 'update'])->where(['id' => '[0-9]+'])->name('update');
    Route::get('{id}/delete', [PostController::class, 'delete'])->where(['id' => '[0-9]+'])->name('delete');
    Route::delete('{id}/destroy', [PostController::class, 'destroy'])->where(['id' => '[0-9]+'])->name('destroy');
});
Route::middleware(['admin', 'locale'])->prefix('permission')->name('permission.')->group(function () {
    Route::get('/', [PermissionController::class, 'index'])->name('index');
    Route::get('create', [PermissionController::class, 'create'])->name('create');
    Route::post('store', [PermissionController::class, 'store'])->name('store');
    Route::get('{id}/edit', [PermissionController::class, 'edit'])->where(['id' => '[0-9]+'])->name('edit');
    Route::post('{id}/update', [PermissionController::class, 'update'])->where(['id' => '[0-9]+'])->name('update');
    Route::get('{id}/delete', [PermissionController::class, 'delete'])->where(['id' => '[0-9]+'])->name('delete');
    Route::delete('{id}/destroy', [PermissionController::class, 'destroy'])->where(['id' => '[0-9]+'])->name('destroy');
});

Route::post("location", [LocationController::class, 'getLocation'])->name('location.index')->middleware(['admin', 'locale']);
Route::post("/dashboard/changeStatus", [APIDashboardController::class, 'changeStatus'])->name('dashboard.changeStatus')->middleware(['admin', 'locale']);
Route::post("/dashboard/changeStatusAll", [APIDashboardController::class, 'changeStatusAll'])->name('dashboard.changeStatusAll')->middleware(['admin', 'locale']);
