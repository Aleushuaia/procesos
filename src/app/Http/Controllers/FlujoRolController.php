<?php

namespace App\Http\Controllers;

use App\Models\Flujo;
use App\Models\TipoActor;
use App\Models\Proceso;
use Illuminate\Http\Request;

class FlujoRolController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:Administrador|administrador|admin']);
    }

    /**
     * Store a role association with a flujo
     */
    public function store(Request $request, Proceso $proceso, Flujo $flujo)
    {
        if ($flujo->proceso_id !== $proceso->id) {
            abort(404);
        }

        $validated = $request->validate([
            'tipo_actor_id'  => 'required|exists:tipos_actores,id',
            'observaciones'  => 'nullable|string|max:500',
        ]);

        // Verificar si ya existe la asociación
        if ($flujo->tiposActores()->where('tipo_actor_id', $validated['tipo_actor_id'])->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'Este rol ya está asociado al flujo',
            ], 422);
        }

        $flujo->tiposActores()->attach($validated['tipo_actor_id'], [
            'observaciones' => $validated['observaciones'] ?? null,
        ]);

        $tipoActor = TipoActor::find($validated['tipo_actor_id']);

        if ($request->wantsJson()) {
            return response()->json([
                'success'  => true,
                'message'  => 'Rol asociado correctamente',
                'rol'      => [
                    'id'           => $tipoActor->id,
                    'descripcion'  => $tipoActor->descripcion,
                ],
            ]);
        }

        return redirect()->route('internal.procesos.flujos.show', [$proceso->id, $flujo->id])
            ->with('success', 'Rol asociado correctamente');
    }

    /**
     * Remove a role association
     */
    public function destroy(Proceso $proceso, Flujo $flujo, TipoActor $tipoactor)
    {
        if ($flujo->proceso_id !== $proceso->id) {
            abort(404);
        }

        $flujo->tiposActores()->detach($tipoactor->id);

        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Rol desasociado correctamente',
            ]);
        }

        return redirect()->route('internal.procesos.flujos.show', [$proceso->id, $flujo->id])
            ->with('success', 'Rol desasociado correctamente');
    }
}
