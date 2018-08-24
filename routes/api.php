<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use NovaCards\SystemInformationCard\SystemInformation;

/*
|--------------------------------------------------------------------------
| Card API Routes
|--------------------------------------------------------------------------
|
| Here is where you may register API routes for your card. These routes
| are loaded by the ServiceProvider of your card. You're free to add
| as many additional routes to this file as your card may require.
|
*/

Route::get('/stats', function (Request $request, SystemInformation $systemInformation) {
    return response()->json([
        'avg' => $systemInformation->avg(),
        'mem' => $systemInformation->memory(),
        'disk' => $systemInformation->disk(),
        'systemTime' => $systemInformation->systemTime()->toIso8601ZuluString(),
        'upTime' => $systemInformation->uptime()
    ]);
});
