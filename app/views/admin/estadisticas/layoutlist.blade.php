@extends ('admin/layout')

@section ('title') Lista de {{ $nombreEstadistica }} @stop

@section ('breadcrumbs') 
    {{Breadcrumbs::render('estadisticas/page', $nombreModelo)}}
@stop

@section ('content')

    <h1 class="text-danger">{{ $nombreEstadistica }}</h1>
    <div class="panel panel-danger">
      <!-- Default panel contents -->
  <div class="panel-heading col-md-12">
    <h2 class="col-md-10">
      @if ($nombreModelo != 'pendientes')
        Del {{$fechaInicio}} hasta {{$fechaFinal}}
      @endif
    </h2> 
    <div class="col-md-2">
      {{Form::open(array('url' => 'admin/estadisticas/'.$nombreModelo, 'method' => 'post'))}}
        {{ Form::button('Descargar', array('type' => 'submit', 'class' => 'btn btn-primary')) }}  
        @if ($nombreModelo == 'pendientes')
            {{ Form::hidden('importacion', $importacion_id)}}
            {{ Form::hidden('importacion_dev', $devolucion_importacion_id)}}
            {{ Form::hidden('importacion_sist', $sistemas_importacion_id)}}
            {{ Form::hidden('fechaInterventoria', $fechaInterventoria)}}
            {{ Form::hidden('tipo_orden', $tipo_orden)}}
        @else
          {{ Form::hidden('fechaInicio', $fechaInicio)}}
          {{ Form::hidden('fechaFinal', $fechaFinal)}}
        @endif

      {{ Form::close() }}
    </div>
  </div>
     	<table class="table table-striped" style="font-size:12px;">
        <tr>
            @foreach ($nombresAtributos as $nombre)
              <th>{{$nombre}}</th>  
            @endforeach
        </tr>
        @foreach ($modelos as $modelo)
        <tr>
            @foreach ($atributos as $atributo)
              @if($atributo == 'produccion')
                <td>{{$modelo->$atributo}}</td>
              @elseif($atributo == 'recuperacion')
                <td>{{number_format($modelo->$atributo, 1, ',', '.')}} Kw</td>
              @else
                <td>{{$modelo->$atributo}}</td> 
              @endif
                
            @endforeach
        </tr>
        @endforeach
      </table>
    </div>
    @if($nombreModelo != 'pendientes')
      {{ $modelos->appends(array('fechaInicio' => $fechaInicio, 'fechaFinal' => $fechaFinal, 'ruta' => $ruta))->links() }}
    @else
      {{ $modelos->appends(array('fechaInterventoria' => $fechaInterventoria, 'importacion' => $importacion_id, 
        'importacion_dev' => $devolucion_importacion_id, 'sistemas_importacion_id', 
        'sistemas_importacion_id' => $sistemas_importacion_id, 'tipo_orden' => $tipo_orden))->links() }}
    @endif

@stop