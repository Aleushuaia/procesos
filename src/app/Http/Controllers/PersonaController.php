<?php

namespace App\Http\Controllers;

use App\Models\Persona;
use App\Models\TipoActor;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PersonaController extends Controller
{
    public function __construct()
    {
        // TEMPORARILY DISABLED FOR TESTING
        // $this->middleware(['auth', 'role:Administrador|administrador|admin']);
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->filterPersonas($request);
        }

        return view('internal.personas.index');
    }

    private function filterPersonas(Request $request)
    {
        $query = Persona::with('tiposActores');

        if ($request->get('apellido')) {
            $query->where('apellido', 'ilike', '%' . $request->get('apellido') . '%');
        }
        if ($request->get('nombres')) {
            $query->where('nombres', 'ilike', '%' . $request->get('nombres') . '%');
        }
        if ($request->get('dni')) {
            $query->where('dni', 'ilike', '%' . $request->get('dni') . '%');
        }

        $allowedSorts = ['apellido', 'nombres', 'dni', 'created_at'];
        $sortColumn   = in_array($request->get('sort'), $allowedSorts) ? $request->get('sort') : 'apellido';
        $sortDirection = $request->get('direction') === 'desc' ? 'desc' : 'asc';
        $query->orderBy($sortColumn, $sortDirection);

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
                ],
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
            ],
        ]);
    }

    public function create()
    {
        $tipos = TipoActor::orderBy('descripcion')->get();
        return view('internal.personas.create', compact('tipos'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'apellido' => 'required|string|max:100',
            'nombres' => 'required|string|max:100',
            'dni' => 'nullable|string|max:20',
            'tipos_actores' => 'array',
        ]);

        $persona = Persona::create([
            'id' => (string) Str::uuid(),
            'apellido' => $data['apellido'],
            'nombres' => $data['nombres'],
            'dni' => $data['dni'] ?? null,
        ]);

        if (! empty($data['tipos_actores'])) {
            $persona->tiposActores()->sync($data['tipos_actores']);
        }

        return redirect()->route('internal.personas.index')->with('success','Persona creada correctamente.');
    }

    public function edit(Persona $persona)
    {
        $tipos = TipoActor::orderBy('descripcion')->get();
        $selected = $persona->tiposActores()->pluck('id')->toArray();
        return view('internal.personas.edit', compact('persona','tipos','selected'));
    }

    public function update(Request $request, Persona $persona)
    {
        $data = $request->validate([
            'apellido' => 'required|string|max:100',
            'nombres' => 'required|string|max:100',
            'dni' => 'nullable|string|max:20',
            'tipos_actores' => 'array',
        ]);

        $persona->update([
            'apellido' => $data['apellido'],
            'nombres' => $data['nombres'],
            'dni' => $data['dni'] ?? null,
        ]);

        $persona->tiposActores()->sync($data['tipos_actores'] ?? []);

        return redirect()->route('internal.personas.index')->with('success','Persona actualizada.');
    }

    public function destroy(Persona $persona)
    {
        $persona->delete();
        return redirect()->route('internal.personas.index')->with('success','Persona eliminada.');
    }

    public function show(Persona $persona)
    {
        $persona->load('tiposActores');
        return view('internal.personas.show', compact('persona'));
    }
}
