<?php

namespace App\Http\Controllers;

use App\Models\UnidadResponsable;
use Illuminate\Http\Request;

class UnidadResponsableController extends Controller
{
    public function __construct()
    {
        // TEMPORARILY DISABLED FOR TESTING
        // $this->middleware(['auth', 'role:Administrador|administrador|admin']);
    }

    public function index()
    {
        $unidadesResponsables = UnidadResponsable::orderBy('descripcion')->get();
        return view('internal.unidades-responsables.index', compact('unidadesResponsables'));
    }

    public function create()
    {
        return view('internal.unidades-responsables.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'descripcion' => 'required|string|max:255|unique:unidades_responsables',
        ]);
        
        UnidadResponsable::create($validated);
        
        return redirect()->route('internal.unidades-responsables.index')->with('success', 'Unidad Responsable creada exitosamente');
    }

    public function show($id)
    {
        $unidadResponsable = UnidadResponsable::findOrFail($id);
        return view('internal.unidades-responsables.show', compact('unidadResponsable'));
    }

    public function edit($id)
    {
        $unidadResponsable = UnidadResponsable::findOrFail($id);
        return view('internal.unidades-responsables.edit', compact('unidadResponsable'));
    }

    public function update(Request $request, $id)
    {
        $unidadResponsable = UnidadResponsable::findOrFail($id);
        
        $validated = $request->validate([
            'descripcion' => 'required|string|max:255|unique:unidades_responsables,descripcion,' . $id,
        ]);
        
        $unidadResponsable->update($validated);
        
        return redirect()->route('internal.unidades-responsables.index')->with('success', 'Unidad Responsable actualizada exitosamente');
    }

    public function destroy($id)
    {
        $unidadResponsable = UnidadResponsable::findOrFail($id);
        $unidadResponsable->delete();
        
        return redirect()->route('internal.unidades-responsables.index')->with('success', 'Unidad Responsable eliminada exitosamente');
    }
}
