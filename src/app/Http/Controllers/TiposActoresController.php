<?php

namespace App\Http\Controllers;

use App\Models\TipoActor;
use Illuminate\Http\Request;

class TiposActoresController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:Administrador|administrador|admin']);
    }

    public function index()
    {
        $tiposActores = TipoActor::orderBy('descripcion')->get();
        return view('internal.tipos-actores.index', compact('tiposActores'));
    }

    public function create()
    {
        return view('internal.tipos-actores.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'descripcion' => 'required|string|max:255|unique:tipos_actores',
        ]);
        
        TipoActor::create($validated);
        
        return redirect()->route('internal.tipos-actores.index')->with('success', 'Tipo de Actor creado exitosamente');
    }

    public function show($id)
    {
        $tipoActor = TipoActor::findOrFail($id);
        return view('internal.tipos-actores.show', compact('tipoActor'));
    }

    public function edit($id)
    {
        $tipoActor = TipoActor::findOrFail($id);
        return view('internal.tipos-actores.edit', compact('tipoActor'));
    }

    public function update(Request $request, $id)
    {
        $tipoActor = TipoActor::findOrFail($id);
        
        $validated = $request->validate([
            'descripcion' => 'required|string|max:255|unique:tipos_actores,descripcion,' . $id,
        ]);
        
        $tipoActor->update($validated);
        
        return redirect()->route('internal.tipos-actores.index')->with('success', 'Tipo de Actor actualizado exitosamente');
    }

    public function destroy($id)
    {
        $tipoActor = TipoActor::findOrFail($id);
        $tipoActor->delete();
        
        return redirect()->route('internal.tipos-actores.index')->with('success', 'Tipo de Actor eliminado exitosamente');
    }
}
