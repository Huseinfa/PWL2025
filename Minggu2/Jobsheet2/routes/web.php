<?php

use App\Http\Controllers\AboutController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ArticleController;

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

/*Route::get('/hello', function () { return 'Hello World';
});
diganti dengan
*/



// Route::get('/world', function () { return 'World';
// });

// Route::get('/welcome', function () { return 'Selamat Datang';
// });

// Route::get('/biodata', function () { return 
//     'Husein Fadhlullah
//     <br> 2341760134';
// });

// Route::get('/user/{name}', function ($name) { return 'Nama saya '.$name;
// });

// Route::get('/posts/{post}/comments/{comment}', function ($postId, $commentId) {
//     return 'Pos ke-'.$postId." Komentar ke-: ".$commentId;
// });

// Route::get('/articles/{id}', function ($id) { return 'Halaman Artikel dengan ID '.$id;
// });

// #Route::get('/user/{name?}', function ($name=null) {return 'Nama saya '.$name; });

// Route::get('/user/{name?}', function ($name='John') { return 'Nama saya '.$name;
// });



// Route::get('/hello', [WelcomeController::class, 'hello']);

// Route::get('/', [PageController::class, 'index']);

// Route::get('/about', [PageController::class, 'about']);

// Route::get('articles/{id}', [PageController::class, 'articles']);

#Praktikum G
Route::get('/', [HomeController::class, 'index']);

Route::get('/about', [AboutController::class, 'about']);

Route::get('/articles/{id}', [ArticleController::class, 'articles']);
