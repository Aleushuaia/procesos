@extends('layouts.app')
@section('title', 'Unidades')
@section('page_title', 'Detalles de Unidad')
@section('breadcrumb')<li class="breadcrumb-item"><a href="{{ route('internal.unidades-responsables.index') }}">Unidades</a></li><li class="breadcrumb-item active">Ver</li>@endsection
@section('content')
<div class="row"><div class="col-md-8"><div class="form-card"><div class="mb-3"><label class="text-muted small">Descripción</label><p>Descripción</p></div><div class="mt-4"><a href="{{ route('internal.unidades-responsables.edit', 1) }}" class="btn btn-primary-pro"><i class="fas fa-pencil-alt mr-2"></i> Editar</a><a href="{{ route('internal.unidades-responsables.index') }}" class="btn btn-secondary-pro"><i class="fas fa-arrow-left mr-2"></i> Volver</a></div></div></div></div>
@endsection
