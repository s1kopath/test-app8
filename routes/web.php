<?php

use App\Http\Controllers\EmployeeController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

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

Route::get('/welcome', function () {
    return view('welcome');
});


Route::get('/', function () {
    return redirect()->route('home-locate', app()->getLocale());
})->name('home');


Auth::routes();

Route::group(['prefix' => '{locale}', 'where' => ['locale' => '[a-zA-Z]{2}']], function () {
    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home-locate');
});



// Employee
Route::post('/employee/add',[EmployeeController::class, 'add'])->name('add_employee');
Route::get('/employee/delete/{id}',[EmployeeController::class, 'delete'])->name('delete_employee');
Route::post('/employee/update/{id}',[EmployeeController::class, 'update'])->name('update_employee');




