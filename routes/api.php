<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ContactController;
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
Route::put('/updateCategory/{id}',[CategoryController::class,'updateCategory'])->middleware(TokenVerificationMiddleware::class);
Route::delete('/deleteCategory/{id}',[CategoryController::class,'deleteCategory'])->middleware(TokenVerificationMiddleware::class);

/**
 * Routers: Contact routes
 */
Route::post('/contact',[ContactController::class,'addContact'])->middleware(TokenVerificationMiddleware::class);
Route::get('/contact',[ContactController::class,'showContacts'])->middleware(TokenVerificationMiddleware::class);
Route::get('/contact/{id}',[ContactController::class,'showContactsbyID'])->middleware(TokenVerificationMiddleware::class);
Route::put('/contact/{id}',[ContactController::class,'updateContact'])->middleware(TokenVerificationMiddleware::class);
Route::delete('/deleteContact/{id}',[ContactController::class,'deleteContact'])->middleware(TokenVerificationMiddleware::class);
