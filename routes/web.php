<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CUserController;


Route::get('/', function () {
    return view('users\layouts');
});


Route::resource('users', CUserController::class)->parameters(['users' => 'c_user']);


Route::get('users/{c_user}/ban-form', [CUserController::class, 'showBanForm'])->name('users.ban.form');
Route::post('users/{c_user}/ban', [CUserController::class, 'ban'])->name('users.ban');
Route::post('users/{c_user}/unban', [CUserController::class, 'unban'])->name('users.unban');
Route::fallback(function () {
    return response()->view('users.err404', [], 404);
});