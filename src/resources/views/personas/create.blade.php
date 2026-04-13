@extends('layouts.app')

@section('page_title','Crear Persona')

@section('content')
<div class="card">
    <div class="card-header"><h3 class="card-title mb-0">Crear Persona</h3></div>
    <div class="card-body">
        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('internal.personas.store') }}">
            @csrf
            @include('personas._form')
            <div class="mt-3">
                <a href="{{ route('internal.personas.index') }}" class="btn btn-secondary">Cancelar</a>
                <button class="btn btn-primary">Guardar</button>
            </div>
        </form>
    </div>
</div>
@endsection
