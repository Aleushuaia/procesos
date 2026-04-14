@extends('layouts.app')
@section('title', 'Unidades')
@section('page_title', 'Nueva Unidad Responsable')
@section('breadcrumb')<li class="breadcrumb-item"><a href="{{ route('internal.unidades-responsables.index') }}">Unidades</a></li><li class="breadcrumb-item active">Nueva</li>@endsection
@section('content')
<div class="row"><div class="col-md-8"><form action="{{ route('internal.unidades-responsables.store') }}" method="POST" class="form-card">@csrf<div class="form-group"><label>Descripción <span class="text-danger">*</span></label><textarea class="form-control" name="descripcion" rows="4" required></textarea></div><div class="form-group mt-4"><button type="submit" class="btn btn-primary-pro"><i class="fas fa-save mr-2"></i> Guardar</button><a href="{{ route('internal.unidades-responsables.index') }}" class="btn btn-secondary-pro"><i class="fas fa-arrow-left mr-2"></i> Volver</a></div></form></div></div>
@endsection
