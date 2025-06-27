<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\RoomController;
use App\Http\Controllers\Api\BookingController;
use App\Http\Controllers\Api\EmployeeController;
use App\Http\Controllers\Api\DepartmentController;
use App\Http\Controllers\Api\PositionController;
use App\Http\Controllers\Api\RolePermissionController;
use App\Http\Controllers\Api\InventoryControler;
use App\Http\Controllers\Api\CategoryController;

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

# All Authentication Routes
Route::group(['middleware' => 'api', 'prefix' => 'auth'], function ($router) {
    Route::post('/login', [AuthController::class, 'login']);
    route::post('/register', [AuthController::class, 'storeUser']);
});

# All services api routes
Route::group(['middleware' => ['ip-whitelist','api','jwt-verify'],'prefix' => 'v1'], function ($router) {

    Route::apiResource('roles', RoleController::class);
  
    
});

# All resources api routes
Route::apiResource('employees', EmployeeController::class);
Route::apiResource('customers', CustomerController::class);
Route::apiResource('rooms', RoomController::class);
Route::apiResource('bookings', BookingController::class);
Route::apiResource('users', UserController::class);
Route::apiResource('departments', DepartmentController::class);
Route::apiResource('positions', PositionController::class);
Route::apiResource('inventory', CategoryController::class);
Route::apiResource('inventory', InventoryControler::class);





Route::get('/roles', [RolePermissionController::class, 'index']); // List all roles
Route::get('/roles/{role}', [RolePermissionController::class, 'show']); // Show role with permissions
Route::middleware('role:admin')->group(function () {
    Route::put('/roles/{role}/permissions', [RolePermissionController::class, 'updatePermissions']);
});





