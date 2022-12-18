<?php

use Illuminate\Support\Facades\Route;

Route::get('connections', [App\Http\Controllers\HomeController::class, 'connections']);
Route::post('connections-in-common', [App\Http\Controllers\HomeController::class, 'connectionsInCommon']);
Route::post('suggestions', [App\Http\Controllers\HomeController::class, 'suggestions']);
Route::post('request', [App\Http\Controllers\HomeController::class, 'request']);
Route::post('send-request', [App\Http\Controllers\HomeController::class, 'sendRequest']);
Route::post('decline-request', [App\Http\Controllers\HomeController::class, 'declineRequest']);
Route::post('accept-request', [App\Http\Controllers\HomeController::class, 'acceptRequest']);
Route::post('remove-request', [App\Http\Controllers\HomeController::class, 'removeConnection']);