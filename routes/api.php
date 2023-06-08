<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;

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


Route::get('/current/{city?}/{country?}/{units?}', function ($city = 'Santander', $country = 'ES', $units = 'metric') {
    Artisan::call('current', [
        'city'    => $city,
        'country' => $country,
        '--units' => $units,
    ]);

    return response(Artisan::output(), 200);
});

Route::get('/forecast/{city?}/{country?}/{days?}/{units?}', function ($city = 'Santander', $country = 'ES', $days = 1, $units = 'metric') {
    Artisan::call('forecast', [
        'city'    => $city,
        'country' => $country,
        '--days'  => $days,
        '--units' => $units,
    ]);

    return response(Artisan::output(), 200);
});

Route::get('/forecast/ask', function () {
    Artisan::call('forecast:ask');

    return response(Artisan::output(), 200);
});
