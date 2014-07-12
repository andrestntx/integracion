@extends ('admin/layout')

@section ('title') Lista de {{ $nombreEstadistica }} @stop

@section ('breadcrumbs') 
    {{Breadcrumbs::render('estadisticas/page', $nombreModelo)}}
@stop

@section ('content')

    <h1 class="text-danger">{{ $nombreEstadistica }} - Sin Resultados</h1>
    <div class="panel panel-danger">
      <!-- Default panel contents -->
  <div class="panel-heading col-md-12">
    <h2 class="col-md-10">
      @if ($nombreModelo != 'pendientes')
        Del {{$fechaInicio}} hasta {{$fechaFinal}}
      @endif
    </h2> 
    <div class="col-md-2">
      
    </div>
  </div>
     	<table class="table table-striped" style="font-size:12px;">
        <tr>
            @foreach ($nombresAtributos as $nombre)
              <th>{{$nombre}}</th>  
            @endforeach
        </tr>
      </table>
    </div>

@stop