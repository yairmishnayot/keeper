<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\UserController;
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


//Public Routes
Route::post('/register', [AuthController::class, 'register'])->name('auth.register');
Route::post('/login', [AuthController::class, 'login'])->name('auth.login');

//Protected Routes
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/user', [UserController::class, 'getCurrentUser'])->name('user.get_current');
    Route::get('/logout', [AuthController::class, 'logout'])->name('user.logout');

    Route::prefix('notes')->group(function(){
        Route::get('/', [NoteController::class, 'index'])->name('notes.index');
        Route::post('create', [NoteController::class, 'store'])->name('notes.create');
        Route::get('/{id}', [NoteController::class, 'show'])->name('notes.show');
    });
});
