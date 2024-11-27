<?php

use App\Http\Controllers\CategoryController;
use App\Http\Middleware\TokenVerificationMiddleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
/**
 * Routers: User routes
 */
Route::post('/register',[UserController::class,'register']);
Route::post('/login',[UserController::class,'login']);
Route::post('/SendOtpCode',[UserController::class,'SendOtpCode']);
Route::post('/verifyOTP',[UserController::class,'verifyOTP']);
Route::post('/resetPassword',[UserController::class,'resetPassword'])->middleware(TokenVerificationMiddleware::class);
Route::post('/logOut',[UserController::class,'logOut'])->middleware(TokenVerificationMiddleware::class);

/**
 * Routers: Category routes
 */
Route::post('/addCategory',[CategoryController::class,'addCategory'])->middleware(TokenVerificationMiddleware::class);
Route::get('/getAllCategories',[CategoryController::class,'getAllCategories'])->middleware(TokenVerificationMiddleware::class);
Route::get('/getCategoryById/{id}',[CategoryController::class,'getByID'])->middleware(TokenVerificationMiddleware::class);
