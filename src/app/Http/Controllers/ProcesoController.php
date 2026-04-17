<?php

namespace App\Http\Controllers;

use App\Models\Proceso;
use App\Models\TipoProceso;
use App\Models\EstadoProceso;
use App\Models\CriticidadProceso;
use App\Models\UnidadResponsable;
use App\Models\Persona;
use App\Models\TipoFlujo;
use App\Models\TipoActor;
use App\Models\TipoProcesoDocumento;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProcesoController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:Administrador|administrador|admin']);
    }

    public function index(Request $request)
    {
        $q = $request->get('q');
        $procesos = Proceso::query()
            ->when($q, function($b) use ($q) {
                return $b->where('descripcion', 'ilike', "%{$q}%")
                         ->orWhere('codigo', 'ilike', "%{$q}%");
            })
            ->with(['tipoProceso', 'estadoProceso', 'criticidadProceso', 'unidadResponsable', 'flujos'])
            ->orderBy('codigo')
            ->get();

        return view('internal.procesos.index', compact('procesos', 'q'));
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
            'unidad_responsable_id' => 'required|exists:unidades_responsables,id',
            'responsable_proceso_id' => 'nullable|exists:personas,id',
            'proceso_padre_id' => 'nullable|exists:procesos,id',
            'requiere_revision' => 'boolean',
        ]);

        $proceso = Proceso::create(array_merge([
            'id' => (string) Str::uuid(),
        ], $data));

        return redirect()->route('internal.procesos.show', $proceso->id)->with('success', 'Proceso creado correctamente.');
    }

    public function show(Proceso $proceso)
    {
        $proceso->load(['tipoProceso', 'estadoProceso', 'criticidadProceso', 'unidadResponsable', 'responsable', 'procesoPadre', 'flujos' => function($q) {
            $q->with(['tipoFlujo', 'personas', 'tiposActores']);
        }, 'documentos.tipoDocumento']);

        // Datos auxiliares requeridos por los modales incluidos en la vista
        $tiposFlujo = TipoFlujo::orderBy('descripcion')->get();
        $personas = Persona::orderBy('apellido')->get();
        $tiposActores = TipoActor::orderBy('descripcion')->get();
        $tiposDocumento = TipoProcesoDocumento::orderBy('descripcion')->get();

        return view('internal.procesos.show', compact('proceso', 'tiposFlujo', 'personas', 'tiposActores', 'tiposDocumento'));
    }

    public function edit(Proceso $proceso)
    {
        $proceso->load(['tipoProceso', 'estadoProceso', 'criticidadProceso', 'unidadResponsable']);

        $tiposProceso = TipoProceso::orderBy('descripcion')->get();
        $estadosProceso = EstadoProceso::orderBy('descripcion')->get();
        $criticidadesProceso = CriticidadProceso::orderBy('descripcion')->get();
        $unidadesResponsables = UnidadResponsable::orderBy('descripcion')->get();
        $personas = Persona::orderBy('apellido')->get();
        $procesos = Proceso::where('id', '!=', $proceso->id)->orderBy('descripcion')->get();

        return view('internal.procesos.edit', compact(
            'proceso',
            'tiposProceso',
            'estadosProceso',
            'criticidadesProceso',
            'unidadesResponsables',
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
            'unidad_responsable_id' => 'required|exists:unidades_responsables,id',
            'responsable_proceso_id' => 'nullable|exists:personas,id',
            'proceso_padre_id' => 'nullable|exists:procesos,id',
            'requiere_revision' => 'boolean',
        ]);

        $proceso->update($data);

        return redirect()->route('internal.procesos.show', $proceso->id)->with('success', 'Proceso actualizado correctamente.');
    }

    public function destroy(Proceso $proceso)
    {
        $proceso->delete();
        return redirect()->route('internal.procesos.index')->with('success', 'Proceso eliminado.');
    }
}
