<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\TravelRequestController;


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

Route::middleware('api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('travel-requests/filter', [TravelRequestController::class, 'filter']);


Route::middleware('auth:api')->group(function () {
    Route::post('travel-requests', [TravelRequestController::class, 'create']);
    Route::put('travel-requests/{id}/status', [TravelRequestController::class, 'updateStatus']);
    Route::get('travel-requests/{id}', [TravelRequestController::class, 'show']);
    Route::get('travel-requests', [TravelRequestController::class, 'index']);
    Route::put('travel-requests/{id}/cancel', [TravelRequestController::class, 'cancel']);
});

Route::post('/login', function(Request $request){
    $credentials = $request->only(['email', 'password']);

    if(!$token = auth()->attempt($credentials)){
        abort(401,'Unauthorized');
    }

    return response()->json([
        'data' => [ 
            'token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]
    ]);
});
