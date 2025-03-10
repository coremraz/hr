<?php

use App\Http\Controllers\AuthHhController;
use App\Http\Controllers\EntriesController;
use App\Http\Controllers\SearchController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/auth', [AuthHhController::class, 'auth']);
Route::post('/logout', [AuthHhController::class, 'logout']);

Route::get('/me', [AuthHhController::class, 'me'])->middleware('auth:sanctum');

// Add this route for the callback
Route::get('/hh/callback', [AuthHhController::class, 'callback']);


//Entries
Route::post('/addEntry', [EntriesController::class, 'addEntry']);
Route::get('/getEntries', [EntriesController::class, 'getEntries']);
Route::post('/deleteEntry', [EntriesController::class, 'deleteEntry']);

//Ai search
Route::post('/handleSearch', [SearchController::class, 'handleSearch']);

Route::get('/{any?}', function () {
    return view('app');
})->where('any', '.*');
