@extends('layouts.app2')

@section('content')
<div class="container">
<h3>Crud Tareas</h3>


<div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Tareas') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('registrar_tarea') }}">
                        @csrf
                        <input id="id" type="hidden" name="id">

                        <div class="row mb-1">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Asignar a') }}</label>
                            <div class="col-md-6"> 
                            <select class="form-control  col-md-4 col-form-label" name="id_user_asignado" id="id_user_asignado">
                                @foreach ($items as $value)
                                      <option value="{{ $value->id }}" {{ ($value->id == Auth::user()->id) ? 'selected' : '' }}> 
                                          {{ $value->name }} 
                                      </option>
                                  @endforeach    
                              </select>
                            </div>
                        </div>
                        </div>


                        <div class="row mb-3">
                            <label for="descripcion" class="col-md-4 col-form-label text-md-end">{{ __('Descripcion Tarea') }}</label>
                            <div class="col-md-6">
                            <textarea id="descripcion" type="text" class="form-control @error('descripcion') is-invalid @enderror" 
                                name="descripcion" value="{{ old('descripcion') }}" required autocomplete="descripcion" autofocus></textarea>
                                @error('descripcion')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Enviar') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<br>
<br>
    <div class="row justify-content-center">
        <div class="col-md-12">
        <div class="card">

<table class="table table-striped table-hover table-responsive">
  <thead>
    <tr>
      <th scope="col">id</th>
      <th scope="col">Quien hará  la tarea</th>
      <th scope="col">Quien asigno la tarea</th>
      <th scope="col">Descripcion</th>
      <th scope="col">Estado</th>
      <th scope="col">Fecha creacion</th>
      <th scope="col">fecha actualizacion</th>
      <th scope="col">Opciones</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($list as $user)
      <tr>
          <th scope="row">{{ $user->id}}</th>
          <td>{{ $user->tarea_signada }}</td>
          <td>{{ $user->tarea_solicitud }}</td>
          <td>{{ $user->descripcion }}</td>
          <td>{{ $user->tipo }}</td>
          <td>{{ $user->created_at }}</td>
          <td>{{ $user->updated_at }}</td>
            <td>         
            <a class="btn btn-danger btn-sm" href="{{ url('/borrar_tarea/?id='.@$user->id) }}" 
            role="button">Borrar</a>
            <a class="btn btn-warning btn-sm" onclick="update('{{@$user->id}}');" role="button">Editar</a>
            <a class="btn btn-info btn-sm" href="{{ url('/rechazar_tarea/?id='.@$user->id) }}" 
            role="button">Rechazar</a>
            <a class="btn btn-success btn-sm" href="{{ url('/finalizado_tarea/?id='.@$user->id) }}" 
            role="button">Finalizado</a>
            </td>
        </tr>
    @endforeach
  </tbody>
</table>
</div>
</div>
</div>
</div>
@endsection
