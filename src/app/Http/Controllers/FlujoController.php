<?php

namespace App\Http\Controllers;

use App\Models\Flujo;
use App\Models\Proceso;
use App\Models\TipoFlujo;
use App\Models\Persona;
use App\Models\TipoActor;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class FlujoController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:Administrador|administrador|admin']);
    }

    /**
     * Display a listing of flujos by proceso
     */
    public function index(Proceso $proceso)
    {
        $flujos = $proceso->flujos()
            ->with(['tipoFlujo', 'personas', 'tiposActores'])
            ->orderBy('descripcion')
            ->get();

        return view('internal.flujos.index', compact('proceso', 'flujos'));
    }

    /**
     * Show the form for creating a new flujo (Modal)
     */
    public function create(Proceso $proceso)
    {
        $tiposFlujo = TipoFlujo::orderBy('descripcion')->get();
        $personas = Persona::orderBy('apellido')->get();
        $tiposActores = TipoActor::orderBy('descripcion')->get();

        return view('internal.flujos.create', compact('proceso', 'tiposFlujo', 'personas', 'tiposActores'));
    }

    /**
     * Store a newly created flujo
     */
    public function store(Request $request, Proceso $proceso)
    {
        $validated = $request->validate([
            'descripcion' => 'required|string|max:255',
            'observaciones' => 'nullable|string|max:1000',
            'tipo_flujo_id' => 'required|exists:tipos_flujos,id',
            'fecha_inicio_analisis' => 'nullable|date',
            'fecha_firma_version' => 'nullable|date|after_or_equal:fecha_inicio_analisis',
            'personas' => 'array',
            'personas.*' => 'exists:personas,id',
            'tipos_actores' => 'array',
            'tipos_actores.*' => 'exists:tipos_actores,id',
        ]);

        $flujo = Flujo::create([
            'id' => (string) Str::uuid(),
            'proceso_id' => $proceso->id,
            'descripcion' => $validated['descripcion'],
            'observaciones' => $validated['observaciones'] !== null ? $validated['observaciones'] : null,
            'tipo_flujo_id' => $validated['tipo_flujo_id'],
            'fecha_inicio_analisis' => isset($validated['fecha_inicio_analisis']) ? $validated['fecha_inicio_analisis'] : null,
            'fecha_firma_version' => isset($validated['fecha_firma_version']) ? $validated['fecha_firma_version'] : null,
        ]);

        // Sincronizar personas
        if (!empty($validated['personas'])) {
            $flujo->personas()->sync($validated['personas']);
        }

        // Sincronizar tipos de actores
        if (!empty($validated['tipos_actores'])) {
            $flujo->tiposActores()->sync($validated['tipos_actores']);
        }

        return response()->json([
            'success' => true,
            'message' => 'Flujo creado correctamente',
            'redirect' => route('internal.procesos.show', $proceso->id)
        ]);
    }

    /**
     * Display the specified flujo (Modal)
     */
    public function show(Proceso $proceso, Flujo $flujo)
    {
        // Verificar que el flujo pertenece al proceso
        if ($flujo->proceso_id !== $proceso->id) {
            abort(404);
        }

        $flujo->load(['tipoFlujo', 'personas', 'tiposActores', 'documentos']);

        if (request()->wantsJson()) {
            return response()->json([
                'id' => $flujo->id,
                'descripcion' => $flujo->descripcion,
                'observaciones' => $flujo->observaciones,
                'tipoFlujo' => isset($flujo->tipoFlujo) ? $flujo->tipoFlujo->descripcion : '-',
                'fecha_inicio_analisis' => $flujo->fecha_inicio_analisis ? $flujo->fecha_inicio_analisis->format('d/m/Y') : null,
                'fecha_firma_version' => $flujo->fecha_firma_version ? $flujo->fecha_firma_version->format('d/m/Y') : null,
                'personas' => $flujo->personas->map(function($p) {
                    return $p->id . '|' . $p->apellido . ', ' . $p->nombres;
                })->toArray(),
                'tipos_actores' => $flujo->tiposActores->map(function($t) {
                    return $t->id . '|' . $t->descripcion;
                })->toArray(),
            ]);
        }

        // Cargar datos necesarios para la vista
        $personas = Persona::orderBy('apellido')->get();
        $tiposActores = TipoActor::orderBy('descripcion')->get();

        return view('internal.flujos.show_standalone', compact('proceso', 'flujo', 'personas', 'tiposActores'));
    }

    /**
     * Show the form for editing the specified flujo (Modal)
     */
    public function edit(Proceso $proceso, Flujo $flujo)
    {
        // Verificar que el flujo pertenece al proceso
        if ($flujo->proceso_id !== $proceso->id) {
            abort(404);
        }

        $flujo->load(['tipoFlujo', 'personas', 'tiposActores']);
        $tiposFlujo = TipoFlujo::orderBy('descripcion')->get();
        $personas = Persona::orderBy('apellido')->get();
        $tiposActores = TipoActor::orderBy('descripcion')->get();
        
        // Obtener los IDs seleccionados
        $personasSeleccionadas = $flujo->personas->pluck('id')->toArray();
        $tiposActoresSeleccionados = $flujo->tiposActores->pluck('id')->toArray();

        return view('internal.flujos.edit_standalone', compact(
            'proceso',
            'flujo',
            'tiposFlujo',
            'personas',
            'tiposActores',
            'personasSeleccionadas',
            'tiposActoresSeleccionados'
        ));
    }

    /**
     * Update the specified flujo
     */
    public function update(Request $request, Proceso $proceso, Flujo $flujo)
    {
        // Verificar que el flujo pertenece al proceso
        if ($flujo->proceso_id !== $proceso->id) {
            abort(404);
        }

        $validated = $request->validate([
            'descripcion' => 'required|string|max:255',
            'observaciones' => 'nullable|string|max:1000',
            'tipo_flujo_id' => 'required|exists:tipos_flujos,id',
            'fecha_inicio_analisis' => 'nullable|date',
            'fecha_firma_version' => 'nullable|date|after_or_equal:fecha_inicio_analisis',
            'personas' => 'array',
            'personas.*' => 'exists:personas,id',
            'tipos_actores' => 'array',
            'tipos_actores.*' => 'exists:tipos_actores,id',
        ]);

        $flujo->update([
            'descripcion' => $validated['descripcion'],
            'observaciones' => isset($validated['observaciones']) ? $validated['observaciones'] : null,
            'tipo_flujo_id' => $validated['tipo_flujo_id'],
            'fecha_inicio_analisis' => isset($validated['fecha_inicio_analisis']) ? $validated['fecha_inicio_analisis'] : null,
            'fecha_firma_version' => isset($validated['fecha_firma_version']) ? $validated['fecha_firma_version'] : null,
        ]);

        // Sincronizar personas
        $flujo->personas()->sync(isset($validated['personas']) ? $validated['personas'] : []);

        // Sincronizar tipos de actores
        $flujo->tiposActores()->sync(isset($validated['tipos_actores']) ? $validated['tipos_actores'] : []);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Flujo actualizado correctamente',
                'redirect' => route('internal.procesos.show', $proceso->id)
            ]);
        }

        return redirect()->route('internal.procesos.flujos.show', [$proceso->id, $flujo->id])
            ->with('success', 'Flujo actualizado correctamente');
    }

    /**
     * Remove the specified flujo
     */
    public function destroy(Proceso $proceso, Flujo $flujo)
    {
        // Verificar que el flujo pertenece al proceso
        if ($flujo->proceso_id !== $proceso->id) {
            abort(404);
        }

        $flujo->delete();

        return response()->json([
            'success' => true,
            'message' => 'Flujo eliminado correctamente',
            'redirect' => route('internal.procesos.show', $proceso->id)
        ]);
    }
}
