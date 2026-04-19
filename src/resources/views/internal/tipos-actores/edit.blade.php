@extends('layouts.app')
@section('title', 'Stakeholders')
@section('page_title', 'Editar Stakeholder')
@section('breadcrumb')<li class="breadcrumb-item"><a href="{{ route('internal.tipos-actores.index') }}">Stakeholders</a></li><li class="breadcrumb-item active">Editar</li>@endsection
@section('content')
<div class="row"><div class="col-md-8"><form action="{{ route('internal.tipos-actores.update', 1) }}" method="POST" class="form-card">@csrf @method('PUT')<div class="form-group"><label>Descripción <span class="text-danger">*</span></label><textarea class="form-control" name="descripcion" rows="4" required></textarea></div><div class="form-group mt-3"><label>Observaciones</label><textarea class="form-control" name="observaciones" rows="4" placeholder="Ingrese observaciones relevantes sobre este stakeholder..."></textarea></div><div class="form-group mt-4"><button type="submit" class="btn btn-primary-pro"><i class="fas fa-save mr-2"></i> Guardar</button><a href="{{ route('internal.tipos-actores.index') }}" class="btn btn-secondary-pro"><i class="fas fa-arrow-left mr-2"></i> Volver</a></div></form></div></div>
@endsection
