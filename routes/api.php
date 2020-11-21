<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post("/registrar","API\UserController@registrar");

Route::middleware('auth:sanctum')->get('/mostrarDatos',"API\UserController@mostrarDatos");
Route::middleware('auth:sanctum')->delete('/borrar/{id?}',"API\UserController@borrar");

Route::post("/logAdmin","API\UserController@logAdmin");
Route::post("/logIn","API\UserController@logIn");

Route::post("/mail","API\MailController@sendMail");
Route::middleware('auth:sanctum')->post("/file","API\ImagenController@guardarFoto");

Route::get('register/verify{code}','API/UserController@verify');
//Route::middleware('auth:sanctum')->delete('/logOut',"API\PersonaController@logOut");