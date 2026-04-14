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
        $this->middleware(['auth','role:administrador']);
    }

    public function index(Request $request)
    {
        $q = $request->get('q');
        $personas = Persona::query()
            ->when($q, fn($b) => $b->where('apellido', 'ilike', "%{$q}%")->orWhere('nombres', 'ilike', "%{$q}%"))
            ->orderBy('apellido')
            ->get();

        return view('internal.personas.index', compact('personas','q'));
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
