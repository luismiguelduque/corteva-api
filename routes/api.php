<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\Settings\AuthController;
use App\Http\Controllers\Api\Settings\RolesController;
use App\Http\Controllers\Api\Settings\UsersController;

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

//<-- Authentication (Autenticación)  -->
Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/login',    [AuthController::class, 'login']);
//<-END- Authentication (Autenticación)  -->



//<-- Services That Require To Be Authenticated  -->
Route::group(['middleware' => ['auth:sanctum']], function () {
   Route::get('/auth/me',      [AuthController::class, 'me']);
   Route::post('/auth/logout', [AuthController::class, 'logout']);
   Route::post('/auth/change-password', [App\Http\Controllers\Api\Settings\AuthController::class, 'changePassword']);


   //<-- Roles (Roles)  -->
   Route::get('roles',         [RolesController::class, 'index']);
   //<-END- Roles (Roles)  -->

   //<-- Users (Usuarios)  -->
   Route::get('users',         [UsersController::class, 'index']);
   Route::post('users',        [UsersController::class, 'store']);
   Route::get('users/{id}',    [UsersController::class, 'show']);
   Route::post('users-update', [UsersController::class, 'update']);
   Route::delete('users/{id}', [UsersController::class, 'destroy']);
   //<-END- Users (Usuarios)  -->
});
//<-END- Services That Require To Be Authenticated  -->




