<div class="form-row">
    <div class="form-group col-md-4">
        <label>Apellido</label>
        <input name="apellido" value="{{ old('apellido', $persona->apellido ?? '') }}" class="form-control" required maxlength="100">
    </div>
    <div class="form-group col-md-4">
        <label>Nombres</label>
        <input name="nombres" value="{{ old('nombres', $persona->nombres ?? '') }}" class="form-control" required maxlength="100">
    </div>
    <div class="form-group col-md-4">
        <label>DNI</label>
        <input name="dni" value="{{ old('dni', $persona->dni ?? '') }}" class="form-control" maxlength="20">
    </div>
</div>

<div class="form-group">
    <label>Roles (Tipos de actor)</label>
    <select name="tipos_actores[]" multiple class="form-control">
        @foreach($tipos as $t)
            <option value="{{ $t->id }}" @if(in_array($t->id, $selected ?? [])) selected @endif>{{ $t->descripcion }}</option>
        @endforeach
    </select>
    <small class="form-text text-muted">Mantén presionada la tecla Ctrl (Cmd) para múltiple selección.</small>
</div>
