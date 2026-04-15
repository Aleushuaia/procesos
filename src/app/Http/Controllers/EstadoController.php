<?php

namespace App\Http\Controllers;

use App\Models\EstadoProceso;
use Illuminate\Http\Request;

class EstadoController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:Administrador|administrador|admin']);
    }

    public function index()
    {
        $estados = EstadoProceso::orderBy('descripcion')->get();
        return view('internal.estados.index', compact('estados'));
    }

    public function create()
    {
        return view('internal.estados.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'descripcion' => 'required|string|max:255|unique:estados_procesos',
        ]);
        
        EstadoProceso::create($validated);
        
        return redirect()->route('internal.estados.index')->with('success', 'Estado creado exitosamente');
    }

    public function show($id)
    {
        $estado = EstadoProceso::findOrFail($id);
        return view('internal.estados.show', compact('estado'));
    }

    public function edit($id)
    {
        $estado = EstadoProceso::findOrFail($id);
        return view('internal.estados.edit', compact('estado'));
    }

    public function update(Request $request, $id)
    {
        $estado = EstadoProceso::findOrFail($id);
        
        $validated = $request->validate([
            'descripcion' => 'required|string|max:255|unique:estados_procesos,descripcion,' . $id,
        ]);
        
        $estado->update($validated);
        
        return redirect()->route('internal.estados.index')->with('success', 'Estado actualizado exitosamente');
    }

    public function destroy($id)
    {
        $estado = EstadoProceso::findOrFail($id);
        $estado->delete();
        
        return redirect()->route('internal.estados.index')->with('success', 'Estado eliminado exitosamente');
    }
}

