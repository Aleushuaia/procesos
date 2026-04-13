@extends('layouts.app')

@section('page_title','Gestión de Personas')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title mb-0">Personas</h3>
        <div>
            <a href="{{ route('internal.personas.create') }}" class="btn btn-primary btn-sm">Crear persona</a>
        </div>
    </div>
    <div class="card-body">
        <form method="GET" class="mb-3">
            <div class="input-group">
                <input name="q" value="{{ $q ?? '' }}" class="form-control" placeholder="Buscar por apellido o nombre">
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary">Buscar</button>
                </div>
            </div>
        </form>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Apellido</th>
                        <th>Nombres</th>
                        <th>DNI</th>
                        <th>Roles</th>
                        <th class="text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($personas as $p)
                    <tr>
                        <td>{{ $p->apellido }}</td>
                        <td>{{ $p->nombres }}</td>
                        <td>{{ $p->dni }}</td>
                        <td>
                            @foreach($p->tiposActores as $t)
                                <span class="badge badge-secondary">{{ $t->descripcion }}</span>
                            @endforeach
                        </td>
                        <td class="text-right">
                            <a href="{{ route('internal.personas.edit', $p) }}" class="btn btn-sm btn-outline-primary">Editar</a>
                            <form action="{{ route('internal.personas.destroy', $p) }}" method="POST" style="display:inline-block" onsubmit="return confirm('Eliminar persona?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-3">{{ $personas->withQueryString()->links() }}</div>
    </div>
</div>
@endsection
