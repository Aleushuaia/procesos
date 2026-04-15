<?php

namespace App\Http\Controllers;

use App\Models\CriticidadProceso;
use Illuminate\Http\Request;

class CriticidadController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:Administrador|administrador|admin']);
    }

    public function index()
    {
        $criticidades = CriticidadProceso::orderBy('descripcion')->get();
        return view('internal.criticidades.index', compact('criticidades'));
    }

    public function create()
    {
        return view('internal.criticidades.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'descripcion' => 'required|string|max:255|unique:criticidades_procesos',
        ]);
        
        CriticidadProceso::create($validated);
        
        return redirect()->route('internal.criticidades.index')->with('success', 'Criticidad creada exitosamente');
    }

    public function show($id)
    {
        $criticidad = CriticidadProceso::findOrFail($id);
        return view('internal.criticidades.show', compact('criticidad'));
    }

    public function edit($id)
    {
        $criticidad = CriticidadProceso::findOrFail($id);
        return view('internal.criticidades.edit', compact('criticidad'));
    }

    public function update(Request $request, $id)
    {
        $criticidad = CriticidadProceso::findOrFail($id);
        
        $validated = $request->validate([
            'descripcion' => 'required|string|max:255|unique:criticidades_procesos,descripcion,' . $id,
        ]);
        
        $criticidad->update($validated);
        
        return redirect()->route('internal.criticidades.index')->with('success', 'Criticidad actualizada exitosamente');
    }

    public function destroy($id)
    {
        $criticidad = CriticidadProceso::findOrFail($id);
        $criticidad->delete();
        
        return redirect()->route('internal.criticidades.index')->with('success', 'Criticidad eliminada exitosamente');
    }
}
