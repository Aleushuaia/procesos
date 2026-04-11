<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AccessControlController;

// Spatie middleware aliases moved to AppServiceProvider

// Rutas públicas - Login (solo si no está autenticado)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

// Rutas protegidas - Requerieren autenticación
Route::middleware('auth')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // Rutas protegidas - Solo para administradores
    Route::middleware('role:administrador')->group(function () {
        Route::prefix('settings')->name('settings.')->group(function () {
            Route::get('access-control', [AccessControlController::class, 'index'])->name('access-control.index');
            
            // APIs JSON para operaciones AJAX
            Route::get('access-control/role/{role}', [AccessControlController::class, 'getRoleDetails'])->name('access-control.role-details');
            Route::post('access-control/role/{role}/permissions', [AccessControlController::class, 'updateRolePermissions'])->name('access-control.update-permissions');
            Route::post('access-control/user/{user}/role', [AccessControlController::class, 'assignRoleToUser'])->name('access-control.assign-role');
            Route::delete('access-control/user/{user}/role', [AccessControlController::class, 'removeRoleFromUser'])->name('access-control.remove-role');
            Route::post('access-control/role', [AccessControlController::class, 'createRole'])->name('access-control.create-role');
            Route::delete('access-control/role/{role}', [AccessControlController::class, 'deleteRole'])->name('access-control.delete-role');
        });
    });
});

