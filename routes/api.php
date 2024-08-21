<?php

use App\Http\Controllers\CategorieController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\TagPostController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::post("register",[UserController::class,"store"]);
Route::post("login",[UserController::class,"login"]);
Route::middleware(['auth:api'])->group(function () {

    Route::put("update",[UserController::class,"update"]);
    Route::delete("delete",[UserController::class,"destroy"]);
    Route::get("refresh",[UserController::class,"refresh"]);
    Route::post("logout",[UserController::class,"logout"]);
    Route::post("user/post",[UserController::class,"createPost"]);
    Route::get("user/post",[UserController::class,"showPosts"]);
    Route::get("user/comments",[UserController::class,"commentsshow"]);


    Route::post("category/store",[CategorieController::class,"store"]);
    Route::delete("category/delete/{id}",[CategorieController::class,"destroy"]);
    Route::put("category/addPost/{postid}",[CategorieController::class,"addPost"]);
    Route::put("category/removePost/{postid}",[CategorieController::class,"removePost"]);




    Route::get("post/user/{id}",[PostController::class,"user"]);
    Route::get("post/category/{id}",[PostController::class,"category"]);
    Route::put("post/update/{id}",[PostController::class,"updateContent"]);
    Route::delete("post/delete/{id}",[PostController::class,"destroy"]);
    Route::get("post/comments/{id}",[PostController::class,"comments"]);
    Route::post("post/addComment",[PostController::class,"addComment"]);



    Route::post("tag/store/{postid}",[TagPostController::class,"addPost"]);
    Route::get("tag/index/{id}",[TagPostController::class,"index"]);
    Route::delete("tag/delete/{postid}",[TagPostController::class,"removePost"]);
    Route::put("tag/update/{id}",[TagPostController::class,"update"]);
    Route::delete("tag/delete",[TagPostController::class,"deleteTag"]);



    Route::get("comment/showpost/{id}",[CommentController::class,"showpost"]);
    Route::get("comment/user/{id}",[CommentController::class,"user"]);
    Route::put("comment/update/{id}",[CommentController::class,"update"]);
    Route::delete("comment/delete/{id}",[CommentController::class,"destroy"]);
});