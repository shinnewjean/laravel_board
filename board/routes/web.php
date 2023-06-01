<?php
/***********************************************
 * 프로젝트명   :   laravel_board
 * 디렉토리     :   Controllers
 * 파일명       :   UserController.php
 * 이력         :   v001 0530 YJ.shin new
*********************************************** */
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BoardsController;
use App\Http\Controllers\UserController;

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
    return view('welcome');
});

// Board
Route::resource('/boards', BoardsController::class);

// Users
Route::get('/users/login',[UserController::class,'login'])->name('users.login');
Route::post('/users/loginpost',[UserController::class,'loginpost'])->name('users.login.post');
Route::get('/users/registration',[UserController::class,'registration'])->name('users.registration');
Route::post('/users/registrationpost',[UserController::class,'registrationpost'])->name('users.registration.post');
Route::get('/users/logout',[UserController::class,'logout'])->name('users.logout'); // 0531 add logout기능
Route::get('/users/withdraw', [UserController::class, 'withdraw'])->name('users.withdraw'); // 0531 add withdraw탈퇴기능
Route::get('/users/edit', [UserController::class, 'edit'])->name('users.edit'); // 0531 add 회원정보 수정 기능
Route::post('/users/edit', [UserController::class, 'editpost'])->name('users.edit.post'); // 0531 add 회원정보 수정 기능


