<?php

namespace App\Http\Controllers;

use App\Models\TipoFlujo;
use Illuminate\Http\Request;

class TipoFlujoController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:Administrador|administrador|admin']);
    }

    public function index()
    {
        $tipoFlujos = TipoFlujo::orderBy('descripcion')->get();
        return view('internal.tipo-flujos.index', compact('tipoFlujos'));
    }

    public function create()
    {
        return view('internal.tipo-flujos.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'descripcion' => 'required|string|max:255|unique:tipos_flujos_procesos',
        ]);
        
        TipoFlujo::create($validated);
        
        return redirect()->route('internal.tipo-flujos.index')->with('success', 'Tipo de Flujo creado exitosamente');
    }

    public function show($id)
    {
        $tipoFlujo = TipoFlujo::findOrFail($id);
        return view('internal.tipo-flujos.show', compact('tipoFlujo'));
    }

    public function edit($id)
    {
        $tipoFlujo = TipoFlujo::findOrFail($id);
        return view('internal.tipo-flujos.edit', compact('tipoFlujo'));
    }

    public function update(Request $request, $id)
    {
        $tipoFlujo = TipoFlujo::findOrFail($id);
        
        $validated = $request->validate([
            'descripcion' => 'required|string|max:255|unique:tipos_flujos_procesos,descripcion,' . $id,
        ]);
        
        $tipoFlujo->update($validated);
        
        return redirect()->route('internal.tipo-flujos.index')->with('success', 'Tipo de Flujo actualizado exitosamente');
    }

    public function destroy($id)
    {
        $tipoFlujo = TipoFlujo::findOrFail($id);
        $tipoFlujo->delete();
        
        return redirect()->route('internal.tipo-flujos.index')->with('success', 'Tipo de Flujo eliminado exitosamente');
    }
}
