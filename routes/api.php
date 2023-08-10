<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Log;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/submit-survey', function (Request $request) {
    $results = $request->input('results');

    // Print survey results to the console
    Log::info('Survey Results:', $results);

    // Process and store the survey results as needed
    // You can use Eloquent models to store the data in your database    

    return response()->json(['message' => 'Survey results submitted successfully']);
});