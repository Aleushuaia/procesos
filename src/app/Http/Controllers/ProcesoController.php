<?php

namespace App\Http\Controllers;

use App\Models\Proceso;
use App\Models\TipoProceso;
use App\Models\EstadoProceso;
use App\Models\CriticidadProceso;
use App\Models\UnidadResponsable;
use App\Models\Persona;
use App\Models\TipoActor;
use App\Models\TipoProcesoDocumento;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProcesoController extends Controller
{
    public function __construct()
    {
        // TEMPORARILY DISABLED FOR TESTING
        // $this->middleware(['auth', 'role:Administrador|administrador|admin']);
    }

    public function index(Request $request)
    {
        // Verificar si es una petición AJAX
        if ($request->ajax()) {
            return $this->filterProcesos($request);
        }

        // Para la carga inicial, cargar todos los datos
        $procesos = Proceso::with(['tipoProceso', 'estadoProceso', 'criticidadProceso'])
            ->orderBy('codigo')
            ->get();

        // Cargar catálogos para los selectores de filtros
        $tiposProceso = TipoProceso::orderBy('descripcion')->get();
        $estadosProceso = EstadoProceso::orderBy('descripcion')->get();
        $criticidadesProceso = CriticidadProceso::orderBy('descripcion')->get();
        $unidadesResponsables = UnidadResponsable::orderBy('descripcion')->get();

        return view('internal.procesos.index', compact(
            'procesos',
            'tiposProceso',
            'estadosProceso',
            'criticidadesProceso',
            'unidadesResponsables'
        ));
    }

    /**
     * Filtrar procesos para peticiones AJAX
     */
    private function filterProcesos(Request $request)
    {
        $query = Proceso::with(['tipoProceso', 'estadoProceso', 'criticidadProceso']);

        // Aplicar filtros
        if ($request->get('codigo')) {
            $query->where('codigo', 'ilike', '%' . $request->get('codigo') . '%');
        }

        if ($request->get('descripcion')) {
            $query->where('descripcion', 'ilike', '%' . $request->get('descripcion') . '%');
        }

        if ($request->get('tipo_proceso_id')) {
            $query->where('tipo_proceso_id', $request->get('tipo_proceso_id'));
        }

        if ($request->get('estado_proceso_id')) {
            $query->where('estado_proceso_id', $request->get('estado_proceso_id'));
        }

        if ($request->get('criticidad_proceso_id')) {
            $query->where('criticidad_proceso_id', $request->get('criticidad_proceso_id'));
        }

        // Filtrar por requiere_revision (si se envía 1 o 0)
        if ($request->filled('requiere_revision')) {
            $val = $request->get('requiere_revision');
            if ($val === '1' || $val === '0') {
                $query->where('requiere_revision', (int) $val);
            }
        }

        // Aplicar ordenamiento (solo columnas reales de la tabla)
        $allowedSorts = ['codigo', 'descripcion', 'tipo_proceso_id', 'estado_proceso_id', 'criticidad_proceso_id', 'created_at'];
        $sortColumn = in_array($request->get('sort'), $allowedSorts) ? $request->get('sort') : 'codigo';
        $sortDirection = $request->get('direction') === 'desc' ? 'desc' : 'asc';
        $query->orderBy($sortColumn, $sortDirection);

        // Aplicar paginación
        $perPage = $request->get('per_page', 'all');

        if ($perPage === 'all') {
            $items = $query->get();
            $total = $items->count();

            return response()->json([
                'data' => $items->values(),
                'pagination' => [
                    'total'        => $total,
                    'per_page'     => $total,
                    'current_page' => 1,
                    'last_page'    => 1,
                ]
            ]);
        }

        $paginated = $query->paginate((int) $perPage);

        return response()->json([
            'data' => collect($paginated->items()),
            'pagination' => [
                'total'        => $paginated->total(),
                'per_page'     => $paginated->perPage(),
                'current_page' => $paginated->currentPage(),
                'last_page'    => $paginated->lastPage(),
            ]
        ]);
    }

    public function create()
    {
        $tiposProceso = TipoProceso::orderBy('descripcion')->get();
        $estadosProceso = EstadoProceso::orderBy('descripcion')->get();
        $criticidadesProceso = CriticidadProceso::orderBy('descripcion')->get();
        $unidadesResponsables = UnidadResponsable::orderBy('descripcion')->get();
        $personas = Persona::orderBy('apellido')->get();
        $procesos = Proceso::orderBy('descripcion')->get();

        return view('internal.procesos.create', compact(
            'tiposProceso',
            'estadosProceso',
            'criticidadesProceso',
            'unidadesResponsables',
            'personas',
            'procesos'
        ));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'descripcion' => 'required|string|max:100',
            'observaciones' => 'nullable|string',
            'codigo' => 'nullable|string|max:50|unique:procesos',
            'objetivo' => 'nullable|string',
            'tipo_proceso_id' => 'required|exists:tipos_procesos,id',
            'estado_proceso_id' => 'required|exists:estados_procesos,id',
            'criticidad_proceso_id' => 'required|exists:criticidades_procesos,id',
            'proceso_padre_id' => 'nullable|exists:procesos,id',
            'requiere_revision' => 'boolean',
        ]);

        // Ensure checkbox value is saved as 0/1 even when unchecked (not present in request)
        $data['requiere_revision'] = $request->has('requiere_revision') ? 1 : 0;

        $proceso = Proceso::create(array_merge([
            'id' => (string) Str::uuid(),
        ], $data));

        return redirect()->route('internal.procesos.show', $proceso->id)->with('success', 'Proceso creado correctamente.');
    }

    public function show(Proceso $proceso)
    {
        $proceso->load(['tipoProceso', 'estadoProceso', 'criticidadProceso', 'procesoPadre', 'documentos.tipoDocumento', 'unidadesResponsables', 'tiposActores']);

        // Datos auxiliares requeridos por los modales incluidos en la vista
        $personas = Persona::orderBy('apellido')->get();
        $tiposActores = TipoActor::orderBy('descripcion')->get();
        $tiposDocumento = TipoProcesoDocumento::orderBy('descripcion')->get();
        $unidadesResponsables = UnidadResponsable::orderBy('descripcion')->get();

        return view('internal.procesos.show', compact('proceso', 'personas', 'tiposActores', 'tiposDocumento', 'unidadesResponsables'));
    }

    public function edit(Proceso $proceso)
    {
        $proceso->load(['tipoProceso', 'estadoProceso', 'criticidadProceso']);

        $tiposProceso = TipoProceso::orderBy('descripcion')->get();
        $estadosProceso = EstadoProceso::orderBy('descripcion')->get();
        $criticidadesProceso = CriticidadProceso::orderBy('descripcion')->get();
        $personas = Persona::orderBy('apellido')->get();
        $procesos = Proceso::where('id', '!=', $proceso->id)->orderBy('descripcion')->get();

        return view('internal.procesos.edit', compact(
            'proceso',
            'tiposProceso',
            'estadosProceso',
            'criticidadesProceso',
            'personas',
            'procesos'
        ));
    }

    public function update(Request $request, Proceso $proceso)
    {
        $data = $request->validate([
            'descripcion' => 'required|string|max:100',
            'observaciones' => 'nullable|string',
            'codigo' => 'nullable|string|max:50|unique:procesos,codigo,' . $proceso->id . ',id',
            'objetivo' => 'nullable|string',
            'tipo_proceso_id' => 'required|exists:tipos_procesos,id',
            'estado_proceso_id' => 'required|exists:estados_procesos,id',
            'criticidad_proceso_id' => 'required|exists:criticidades_procesos,id',
            'proceso_padre_id' => 'nullable|exists:procesos,id',
            'requiere_revision' => 'boolean',
        ]);

        // Ensure checkbox value is saved as 0/1 even when unchecked (not present in request)
        $data['requiere_revision'] = $request->has('requiere_revision') ? 1 : 0;

        $proceso->update($data);

        return redirect()->route('internal.procesos.show', $proceso->id)->with('success', 'Proceso actualizado correctamente.');
    }

    public function destroy(Proceso $proceso)
    {
        $proceso->delete();
        return redirect()->route('internal.procesos.index')->with('success', 'Proceso eliminado.');
    }

    /**
     * Vincular una unidad responsable a un proceso
     */
    public function vincularUnidad(Proceso $proceso, Request $request)
    {
        try {
            $validated = $request->validate([
                'unidad_responsable_id' => 'required|string|exists:unidades_responsables,id'
            ]);

            $unidadId = $validated['unidad_responsable_id'];

            // Verificar si la unidad ya está vinculada
            if ($proceso->unidadesResponsables()->where('unidad_responsable_id', $unidadId)->exists()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Esta unidad ya está vinculada al proceso'
                ], 422);
            }

            // Vincular la unidad
            $proceso->unidadesResponsables()->attach($unidadId);

            return response()->json([
                'success' => true,
                'message' => 'Unidad vinculada correctamente'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al vincular la unidad: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Desvincu lar una unidad responsable de un proceso
     */
    public function desvincularUnidad(Proceso $proceso, $unidadId)
    {
        // Validar que sea un UUID válido
        if (!preg_match('/^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$/i', $unidadId)) {
            return response()->json([
                'success' => false,
                'message' => 'ID de unidad inválido'
            ], 422);
        }

        $proceso->unidadesResponsables()->detach($unidadId);

        return response()->json([
            'success' => true,
            'message' => 'Unidad desvinculada correctamente'
        ]);
    }

    /**
     * Vincular un stakeholder (tipo de actor) a un proceso
     */
    public function vincularTipoActor(Proceso $proceso, Request $request)
    {
        try {
            $validated = $request->validate([
                'tipo_actor_id' => 'required|string|exists:tipos_actores,id'
            ]);

            $tipoActorId = $validated['tipo_actor_id'];

            // Verificar si el stakeholder ya está vinculado
            if ($proceso->tiposActores()->where('tipo_actor_id', $tipoActorId)->exists()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Este stakeholder ya está vinculado al proceso'
                ], 422);
            }

            // Vincular el stakeholder
            $proceso->tiposActores()->attach($tipoActorId);

            return response()->json([
                'success' => true,
                'message' => 'Stakeholder vinculado correctamente'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al vincular el stakeholder: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Desvinculkar un stakeholder (tipo de actor) de un proceso
     */
    public function desvincularTipoActor(Proceso $proceso, $tipoActorId)
    {
        // Validar que sea un UUID válido
        if (!preg_match('/^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$/i', $tipoActorId)) {
            return response()->json([
                'success' => false,
                'message' => 'ID de stakeholder inválido'
            ], 422);
        }

        $proceso->tiposActores()->detach($tipoActorId);

        return response()->json([
            'success' => true,
            'message' => 'Stakeholder desvinculado correctamente'
        ]);
    }
}
