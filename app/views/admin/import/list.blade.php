@extends ('admin/layout')

@section ('title') Lista de Importacion @stop

@section ('breadcrumbs') 
    {{Breadcrumbs::render(Route::currentRouteName())}}
@stop

@section ('content')

    <h1 class="text-danger">Lista de Importaciones</h1>
   	<table class="table table-striped">
    <tr>
        <th>Id</th>
        <th>Creación</th>
        <th>Actualización</th>
        <th>Tipo Archivo</th>
        <th>Faltantes</th>
        <th>Creadas</th>
        <th>Actualziadas</th>
        <th>Descartadas</th>
        <th>No Sypelc</th>
        <th>No Encontradas</th>
        <th>Ver</th>
    </tr>
    @foreach ($resultados as $resultado)
    <tr>
        <td>{{ $resultado->id }}</td>
        <td>{{ $resultado->created_at }}</td>
        <td>{{ $resultado->updated_at  }}</td>
        <td>{{ $resultado->nombre }}</td>
        <td>{{ $resultado->total  - $resultado->creadas - $resultado->descartadas - $resultado->actualizadas - $resultado->no_sypelc - $resultado->no_encontradas }}</td> 
        <td>{{ $resultado->creadas }}</td>
        <td>{{ $resultado->actualizadas }}</td>
        <td>{{ $resultado->descartadas }}</td>
        <td>{{ $resultado->no_sypelc }}</td>
        <td>{{ $resultado->no_encontradas }}</td>
        <td>
          {{HTML::link('admin/import/resultado/'.$resultado->id, 'Ver', array('class' => 'btn btn-primary'))}}

        </td>
    </tr>
    @endforeach
  </table>
  {{ $resultados->links() }}
  {{ Form::open(array('route' => array('admin.users.destroy', 'USER_ID'), 'method' => 'DELETE', 'role' => 'form', 'id' => 'form-delete')) }}
{{ Form::close() }}
@stop