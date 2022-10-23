<?php

use App\Http\Controllers\Api\Auth\ForgotPasswordController;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\LogoutController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\BatchController;
use App\Http\Controllers\Api\CultivarController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\FeedController;
use App\Http\Controllers\Api\FeedSubController;
use App\Http\Controllers\Api\SubsrateController;
use App\Http\Controllers\Api\SubsrateTargetController;
use App\Http\Controllers\Api\SubsrateTargetSubController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\VarietyMasterController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
 */

/* Route::middleware('auth:api')->get('/user', function (Request $request) {
return $request->user();
}); */

Route::group(['prefix' => 'v1', 'namespace' => 'Api', 'as' => 'api'], function () {

    Route::post('/register', [RegisterController::class, 'store'])->name('register');
    Route::post('/login', [LoginController::class, 'index'])->name('login');

    Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('forgot.password');

    Route::group(['middleware' => ['auth:api']], function () {

        Route::get('/profile', [UserController::class, 'details'])->name('profile.detail');
        Route::post('/change-password', [UserController::class, 'changePassword'])->name('change.password');

        Route::get('/logout', [LogoutController::class, 'index'])->name('logout');

        Route::post('/edit-profile', [UserController::class, 'editProfile'])->name('edit.profile');
        Route::post('/set-your-profile', [UserController::class, 'setProfile'])->name('set.profile');

        //Subsrate
        Route::post('/subsrate/{type}', [SubsrateController::class, 'index'])->name('subsrates');
        Route::get('/batchid-list/{type}/{comparmentNo}', [SubsrateController::class, 'batchIDList'])->name('batchid.list');
        Route::post('/subsrate', [SubsrateController::class, 'store'])->name('subsrate.store');
        Route::put('/subsrate/{id}', [SubsrateController::class, 'edit'])->name('subsrate.edit');
        Route::delete('/subsrate/{id}', [SubsrateController::class, 'delete'])->name('subsrate.delete');
        Route::post('/subsrate/dashboard/update', [SubsrateController::class, 'dashboardUpdate'])->name('subsrate.dashboardUpdate');

        //Batch
        Route::post('/batch/{type}', [BatchController::class, 'index'])->name('batches');
        Route::get('/batch/details/{id}', [BatchController::class, 'details'])->name('batch.details');
        Route::post('/batch', [BatchController::class, 'store'])->name('batch.store');
        Route::put('/batch/{id}', [BatchController::class, 'edit'])->name('batch.edit');
        Route::delete('/batch/{id}', [BatchController::class, 'delete'])->name('batch.delete');
        Route::post('/batch-suggestion', [BatchController::class, 'suggestion']);

        //Subsrate
        Route::post('/subsrate-target/{type}', [SubsrateTargetController::class, 'index'])->name('subsrates.target');
        Route::post('/subsrate-target', [SubsrateTargetController::class, 'store'])->name('subsrate.target.store');
        Route::put('/subsrate-target/{id}', [SubsrateTargetController::class, 'edit'])->name('subsrate.target.edit');
        Route::delete('/subsrate-target/{id}', [SubsrateTargetController::class, 'delete'])->name('subsrate.target.delete');

        //Subsrate Sub
        Route::get('/subsrate-target-sub/{subsrateTargetID}', [SubsrateTargetSubController::class, 'index'])->name('subsrates.target.sub');
        Route::post('/subsrate-target-sub', [SubsrateTargetSubController::class, 'store'])->name('subsrate.target.sub.store');
        Route::put('/subsrate-target-sub/{id}', [SubsrateTargetSubController::class, 'edit'])->name('subsrate.target.sub.edit');
        Route::delete('/subsrate-target-sub/{id}', [SubsrateTargetSubController::class, 'delete'])->name('subsrate.target.sub.delete');

        //Feed
        Route::post('/feed/{type}', [FeedController::class, 'index'])->name('feed');
        Route::post('/feed', [FeedController::class, 'store'])->name('feed.store');
        Route::put('/feed/{id}', [FeedController::class, 'edit'])->name('feed.edit');
        Route::delete('/feed/{id}', [FeedController::class, 'delete'])->name('feed.delete');

        //Feed Sub
        Route::get('/feed-sub/{feedID}', [FeedSubController::class, 'index'])->name('feed.sub');
        Route::post('/feed-sub', [FeedSubController::class, 'store'])->name('feed.sub.store');
        Route::put('/feed-sub/{id}', [FeedSubController::class, 'edit'])->name('feed.sub.edit');
        Route::delete('/feed-sub/{id}', [FeedSubController::class, 'delete'])->name('feed.sub.delete');

        //Dashboard
        Route::post('/dashboard', [DashboardController::class, 'dashboard'])->name('main.dashboard');
        Route::get('/dashboard/graph/{batchId}/{type}', [DashboardController::class, 'dashboardGraph'])->name('main.dashboardGraph');
        Route::post('/dashboard/historic', [DashboardController::class, 'historic'])->name('dashboard.historic');
        Route::post('/dashboard/custom-graph', [DashboardController::class, 'customGraph'])->name('dashboard.custom.graph');
        Route::post('/dashboard/batch', [DashboardController::class, 'batch'])->name('dashboard.batches');
        Route::post('/dashboard/targets', [DashboardController::class, 'targets'])->name('dashboard.targets');

        // cultivar
        Route::get('/cultivar/{type}', [CultivarController::class, 'index'])->name('cultivar');

        // Variety Master
        Route::get('/variety-master', [VarietyMasterController::class, 'index'])->name('variety.master');
        Route::post('/variety-master', [VarietyMasterController::class, 'store'])->name('variety.master.store');
        Route::put('/variety-master/{id}', [VarietyMasterController::class, 'update'])->name('variety.master.edit');
        Route::delete('/variety-master/{id}', [VarietyMasterController::class, 'delete'])->name('variety.master.delete');

    });
});
