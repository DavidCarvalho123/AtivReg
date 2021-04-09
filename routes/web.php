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

Route::get('/unidades', function(){
    if(Gate::denies('sadmin-only', Auth::user()))
    {
        if(Gate::allows('multiuni-only', Auth::user()))
        {
            return view('auth.baseunidade');
        }
        else
        {
            return redirect('/dashboard');
        }
    }
    else
    {
        return redirect('/');
    }
})->middleware('auth');

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

    Route::get('/{url1}', function($url1){
    return view('auth.baselogin');
    })->name('Login')->where(['url1' => 'login|Login']);

    Route::get('/{url2}', function($url2){
        return view('auth.baseregister');
    })->name('Registar')->where(['url2' => 'registar|Registar']);
});
Route::get('/logout',App\Http\Livewire\Logout::class)->middleware('auth');

Route::get('/mudarpasse', function(){
    return view('auth.basemudar');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
