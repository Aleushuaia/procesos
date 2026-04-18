<?php

namespace App\Http\Controllers;

use App\Models\Flujo;
use App\Models\Persona;
use App\Models\Proceso;
use Illuminate\Http\Request;

class FlujoPersonaController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:Administrador|administrador|admin']);
    }

    /**
     * Store a person association with a flujo
     */
    public function store(Request $request, Proceso $proceso, Flujo $flujo)
    {
        if ($flujo->proceso_id !== $proceso->id) {
            abort(404);
        }

        $validated = $request->validate([
            'persona_id'    => 'required|exists:personas,id',
            'observaciones' => 'nullable|string|max:500',
        ]);

        // Verificar si ya existe la asociación
        if ($flujo->personas()->where('persona_id', $validated['persona_id'])->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'Esta persona ya está asociada al flujo',
            ], 422);
        }

        $flujo->personas()->attach($validated['persona_id'], [
            'observaciones' => $validated['observaciones'] ?? null,
        ]);

        $persona = Persona::find($validated['persona_id']);

        if ($request->wantsJson()) {
            return response()->json([
                'success'  => true,
                'message'  => 'Persona asociada correctamente',
                'persona'  => [
                    'id'    => $persona->id,
                    'nombre' => $persona->apellido . ', ' . $persona->nombres,
                ],
            ]);
        }

        return redirect()->route('internal.procesos.flujos.show', [$proceso->id, $flujo->id])
            ->with('success', 'Persona asociada correctamente');
    }

    /**
     * Remove a person association
     */
    public function destroy(Proceso $proceso, Flujo $flujo, Persona $persona)
    {
        if ($flujo->proceso_id !== $proceso->id) {
            abort(404);
        }

        $flujo->personas()->detach($persona->id);

        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Persona desasociada correctamente',
            ]);
        }

        return redirect()->route('internal.procesos.flujos.show', [$proceso->id, $flujo->id])
            ->with('success', 'Persona desasociada correctamente');
    }
}
