<?php

use Illuminate\Support\Facades\Route;
use  App\Http\Controllers\RegisterController;
use  App\Http\Controllers\LoginController;
use  App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\DB;
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
    return view('students.index');
});
Route::get('/login', function () {
    return view('login');
});
Route::get('/register', function () {
    return view('register');
});
Route::post('/signup', [RegisterController::class, 'signup']);
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
// Route::get('/welcome', function () {
//     $result = DB::table('students')->get();
//     return view('welcome', compact('result'));
// })->middleware('auth');

Route::middleware(['auth'])->group(function () {
    Route::get('/', function () {
        return redirect()->route('students.index');
    });
    Route::resource('students', StudentController::class);
});
