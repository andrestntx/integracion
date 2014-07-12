@extends ('admin/layout')

@section ('title') Estadistica - Proyectos Sypelc @stop

@section ('breadcrumbs') 
    {{Breadcrumbs::render('estadisticas/page', 'proyectos')}}
@stop

@section ('content')

	<h1 class="text-danger">Proyectos Sypelc</h1>
		<div class="panel panel-danger">
			<!-- Default panel contents -->
			 <div class="panel-heading col-md-12">
			    <h2 class="col-md-10">.</h2> 
			    <div class="col-md-2">
			      {{Form::open(array('url' => 'admin/estadisticas/proyectos', 'method' => 'post'))}}
			      	{{ Form::hidden('fechaInicio', $fechaInicio)}}
			      	{{ Form::hidden('fechaFinal', $fechaFinal)}}
			        {{ Form::button('Descargar', array('type' => 'submit', 'class' => 'btn btn-primary')) }}  
			      {{ Form::close() }}
			    </div>
			</div>
		
			<table class="table table-striped" style="font-size:12px;">
		        <tr>
		            @foreach ($nombresAtributos as $nombre)
		              <th>{{$nombre}}</th>  
		            @endforeach
		        </tr>
		        @foreach ($datos as $dato)
		        <tr>
		            @foreach ($atributos as $atributo)
		              @if($atributo == 'produccion')
		                <td>{{$dato->$atributo}}</td>
		              @elseif($atributo == 'recuperacion')
		                <td>{{number_format($dato->$atributo, 1, ',', '.')}} W</td>
		              @else
		                <td>{{$dato->$atributo}}</td> 
		              @endif
		                
		            @endforeach
		        </tr>
		        @endforeach
		      </table>
		</div>

	{{ $datos->appends(array('fechaInicio' => $fechaInicio, 'fechaFinal' => $fechaFinal))->links() }}
@stop