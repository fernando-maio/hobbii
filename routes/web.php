<?php

use App\Http\Controllers\ActionController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ProjectController;

Route::get('/', function () {
    return view('welcome');
});

Route::group(['prefix' => 'dashboard'], function () {
    Route::get('/', [ActionController::class, 'index'])->name('actions');
    Route::get('/run/{id}', [ActionController::class, 'run'])->name('actions.run');
    Route::get('/stop/{id}', [ActionController::class, 'stop'])->name('actions.stop');
    Route::get('/invoice/{id}', [ActionController::class, 'invoice'])->name('actions.invoice');
});

Route::group(['prefix' => 'clients'], function () {
    Route::get('/', [ClientController::class, 'index'])->name('clients');
    Route::get('/create', [ClientController::class, 'create'])->name('clients.create');
    Route::post('/store', [ClientController::class, 'store'])->name('clients.store');
    Route::get('/edit/{id}', [ClientController::class, 'edit'])->name('clients.edit');
    Route::patch('/edit/{id}', [ClientController::class, 'update'])->name('clients.update');
    Route::delete('/remove/{id}', [ClientController::class, 'remove'])->name('clients.remove');
});

Route::group(['prefix' => 'projects'], function () {
    Route::get('/', [ProjectController::class, 'index'])->name('projects');
    Route::get('/create', [ProjectController::class, 'create'])->name('projects.create');
    Route::post('/store', [ProjectController::class, 'store'])->name('projects.store');
    Route::get('/edit/{id}', [ProjectController::class, 'edit'])->name('projects.edit');
    Route::patch('/edit/{id}', [ProjectController::class, 'update'])->name('projects.update');
    Route::delete('/remove/{id}', [ProjectController::class, 'remove'])->name('projects.remove');
    Route::get('/finish/{id}', [ProjectController::class, 'finish'])->name('projects.finish');
});