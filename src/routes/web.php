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
// TEMPORARILY DISABLED FOR TESTING
// Route::middleware('auth')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // Rutas protegidas - Solo para administradores
    // TEMPORARILY DISABLED FOR TESTING
    // Route::middleware('role:Administrador|administrador|admin')->group(function () {
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

        // Gestión interna - CRUD de entidades
        Route::prefix('internal')->name('internal.')->group(function () {
            Route::resource('procesos', App\Http\Controllers\ProcesoController::class);
            Route::resource('criticidades', App\Http\Controllers\CriticidadController::class);
            // 'procesos' resource removed (obsolete)
            Route::resource('estados', App\Http\Controllers\EstadoController::class);
            Route::resource('personas', App\Http\Controllers\PersonaController::class);
            // 'roles' and 'proceso-unidad-responsable' resources removed (obsolete)
            Route::resource('tipos-actores', App\Http\Controllers\TiposActoresController::class);
            Route::resource('tipos-procesos', App\Http\Controllers\TipoProcesoController::class);
            Route::resource('unidades-responsables', App\Http\Controllers\UnidadResponsableController::class);
            
            // Documentos nested resource under procesos
            Route::resource('procesos.documentos', App\Http\Controllers\ProcesoDocumentoController::class)
                ->only(['store', 'show', 'edit', 'update', 'destroy']);
            
            // Unidades Responsables nested resource under procesos
            Route::post('procesos/{proceso}/unidades', [App\Http\Controllers\ProcesoController::class, 'vincularUnidad'])->name('procesos.unidades.store');
            Route::delete('procesos/{proceso}/unidades/{unidad}', [App\Http\Controllers\ProcesoController::class, 'desvincularUnidad'])->name('procesos.unidades.destroy');

            // Stakeholders (Tipos de Actores) nested resource under procesos
            Route::post('procesos/{proceso}/stakeholders', [App\Http\Controllers\ProcesoController::class, 'vincularTipoActor'])->name('procesos.stakeholders.store');
            Route::delete('procesos/{proceso}/stakeholders/{tipoActor}', [App\Http\Controllers\ProcesoController::class, 'desvincularTipoActor'])->name('procesos.stakeholders.destroy');
        });

        // Fin de la sección de gestión interna
        // });  // TEMPORARILY DISABLED FOR TESTING - end of role:admin group
    // });  // TEMPORARILY DISABLED FOR TESTING - end of auth group
// });  // TEMPORARILY DISABLED FOR TESTING - end of main group


