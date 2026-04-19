<?php

namespace App\Http\Controllers;

use App\Models\TipoProceso;
use Illuminate\Http\Request;

class TipoProcesoController extends Controller
{
    public function __construct()
    {
        // TEMPORARILY DISABLED FOR TESTING
        // $this->middleware(['auth', 'role:Administrador|administrador|admin']);
    }

    public function index()
    {
        $tipoProcesos = TipoProceso::orderBy('descripcion')->get();
        return view('internal.tipos-procesos.index', compact('tipoProcesos'));
    }

    public function create()
    {
        return view('internal.tipos-procesos.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'descripcion' => 'required|string|max:255|unique:tipos_procesos',
        ]);
        
        TipoProceso::create($validated);
        
        return redirect()->route('internal.tipos-procesos.index')->with('success', 'Tipo de Proceso creado exitosamente');
    }

    public function show($id)
    {
        $tipoProceso = TipoProceso::findOrFail($id);
        return view('internal.tipos-procesos.show', compact('tipoProceso'));
    }

    public function edit($id)
    {
        $tipoProceso = TipoProceso::findOrFail($id);
        return view('internal.tipos-procesos.edit', compact('tipoProceso'));
    }

    public function update(Request $request, $id)
    {
        $tipoProceso = TipoProceso::findOrFail($id);
        
        $validated = $request->validate([
            'descripcion' => 'required|string|max:255|unique:tipos_procesos,descripcion,' . $id,
        ]);
        
        $tipoProceso->update($validated);
        
        return redirect()->route('internal.tipos-procesos.index')->with('success', 'Tipo de Proceso actualizado exitosamente');
    }

    public function destroy($id)
    {
        $tipoProceso = TipoProceso::findOrFail($id);
        $tipoProceso->delete();
        
        return redirect()->route('internal.tipos-procesos.index')->with('success', 'Tipo de Proceso eliminado exitosamente');
    }
}
