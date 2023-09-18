<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

Route::middleware('auth:sanctum')->get('/guard', function (Request $request) {

    if (Auth::guard('users')->check())
    {
        return 'users';
    }

    if (Auth::guard('owners')->check())
    {
        return 'owners';
    }

    if (Auth::guard('admin')->check())
    {
        return 'admin';
    }

});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
