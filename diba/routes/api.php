<?php

use App\Http\Controllers\File\FileController;
use App\Http\Controllers\User\RoleController;
use App\Http\Controllers\User\UserController;
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
Route::post('login', [UserController::class, 'login'])->name('login');

Route::middleware(['auth:api'])->group(
    function () {
        Route::get('logout', [UserController::class, 'logout'])->name('logout');
    }
);

Route::middleware(['auth:api', 'permission'])->group(
    function () {
        Route::apiResource('files', FileController::class)->except(['update', 'destroy']);
        Route::prefix('users')->group(
            function () {
                Route::get('{user}/roles', [UserController::class, 'getRoles'])->name('users.roles.index');
                Route::put('{user}/roles', [UserController::class, 'syncRoles'])->name('roles.sync');
                Route::post(
                    '{user}/roles/{role}',
                    [UserController::class, 'addRole']
                )
                    ->name('users.roles.store');
                Route::delete(
                    '{user}/roles/{role}',
                    [UserController::class, 'deleteRole']
                )
                    ->name('users.roles.destroy');
            }
        );

        Route::prefix('roles')->group(
            function () {
                Route::get('{role}/permissions', [RoleController::class, 'getPermissions'])
                    ->name('roles.permissions.index');
                Route::put('{role}/permissions', [RoleController::class, 'syncPermissions'])
                    ->name('permissions.sync');
                Route::post(
                    '{role}/permissions/{permission}',
                    [RoleController::class, 'addPermission']
                )
                    ->name('roles.permissions.store');
                Route::delete(
                    '{role}/permissions/{permission}',
                    [RoleController::class, 'deletePermission']
                )
                    ->name('roles.permissions.destroy');
            }
        );
    }
);
