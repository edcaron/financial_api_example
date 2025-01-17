<?php

use App\Http\Controllers\ContaController;
use App\Http\Controllers\TransacaoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post("conta", [ContaController::class, "store"])->middleware(['transaction']);
Route::get("conta", [ContaController::class, "show"]);

Route::post("transacao", [TransacaoController::class, "store"])->middleware(['transaction']);
