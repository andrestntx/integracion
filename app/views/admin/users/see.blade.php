@extends ('admin/layout')

@section ('title') User {{ $user->full_name }} @stop

@section ('content')

<h2>User #{{ $user->id }}</h2>

<p>Full name: {{ $user->full_name }}</p>
<p>Email: {{ $user->email }}</p>

<p>
  <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-primary">
    Editar
  </a>    
</p>

{{ Form::model($user, array('route' => array('admin.users.destroy', $user->id), 'method' => 'DELETE'), array('role' => 'form')) }}
  {{ Form::submit('Eliminar usuario', array('class' => 'btn btn-danger')) }}
{{ Form::close() }}

@stop