<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;

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
    return view('inicio');
});





Route::get('/dashboard', function () {
    if(Gate::denies('sadmin-only', Auth::user()))
    {
        return view('layouts.lightdashboardbase');
    }
    else
    {
        return redirect('/');
    }

})->middleware('auth');

Route::get('/sadmin', function (){
    if(Gate::allows('sadmin-only', Auth::user()))
    {
        return view('superadmin.sadmin');
    }
    else
    {
        return redirect('/Login');
    }

});





Route::get('/docs', function (){
    return view('layouts.documentacao');
});
Route::group(['middleware' => 'guest'],function(){

    Route::get('/Login', function(){
    return view('auth.baselogin');
    })->name('Login');

    Route::get('/Register', function(){
        return view('auth.baseregister');
    });
});
Route::get('/logout',App\Http\Livewire\Logout::class)->middleware('auth');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
