<?php

use App\Http\Controllers\Students;
use App\Http\Controllers\Teachers;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::get('/', function () {
        return redirect("/settings/students");
    });

    Route::get('/settings', function () {
        return redirect("/settings/students");
    });
    Route::get('/settings/students', [Students::class, 'index'])->name('settings__students');
    Route::get('/settings/teachers', [Teachers::class, 'index'])->name('settings__teachers');
});
