<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CategoryController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/articles' , [ArticleController::class, 'index']);
Route::get('/article/{id}' , [ArticleController::class, 'show']);
//add article with categories
Route::post('/addArticle' , [ArticleController::class, 'store']); 
//update article with its categories
Route::post('/updateArticle/{id}' , [ArticleController::class, 'update']);
//delete article with its related Article_Category
Route::get('/deleteArticle/{id}' , [ArticleController::class, 'destroy']);  



Route::get('/categories' , [CategoryController::class, 'index']);
Route::get('/category/{id}' , [CategoryController::class, 'show']);
Route::post('/addCategory' , [CategoryController::class, 'store']);
Route::post('/updateCategory/{id}' , [CategoryController::class, 'update']);
//delete categories with its related Article_Category
Route::get('/deleteCategory/{id}' , [CategoryController::class, 'destroy']);
