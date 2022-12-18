@extends('layouts.app2')

@section('content')

<div class="container">
<h3>Lista Usuarios</h3>

<table class="table table-striped table-hover table-responsive">
  <thead>
    <tr>
      <th scope="col">ID</th>
      <th scope="col">Nombre Completo</th>
      <th scope="col">Teléfono</th>
      <th scope="col">Email</th>
      <th scope="col">Estado</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($list as $user)
      <tr>
          <th scope="row">{{ $user->id}}</th>
          <td>{{ $user->name . " ". $user->apellido }}</td>
          <td>{{ $user->telefono }}</td>
          <td>{{ $user->email }}</td>
          <td>
              @if($user->estado == 1)
                True
              @else
                False
              @endif
        </td>
        </tr>
    @endforeach
  </tbody>
</table>
</div>

@endsection
