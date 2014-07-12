@extends ('admin/layout')

@section ('title') Resultado de Importación -{{$resultado->id}} @stop

@section ('breadcrumbs') 
	{{Breadcrumbs::render(Route::currentRouteName(), $resultado->id)}}
@stop

@section ('content') 
	<div class="col-md-4">
		<h1 style="font-size:19px;">Resultado <b>{{$resultado->id}}</b></h1>
		<table class="table table-hover" style="font-size:16px;">
	        <tr> 
	        	<td>Creada el</td> 
	        	<td>{{ $resultado->created_at }}</td> 
	        </tr>
	        <tr> 
	        	<td>Actualización</td> 
	        	<td>{{ $resultado->updated_at  }}</td> 
	        </tr>
	        <tr> 
	        	<td>Tipo</td> 
	        	<td>{{ Archivo::find($resultado->archivo_id)->nombre }}</td> 
	        </tr>
	        <tr> 
	        	<td>Faltantes</td> 
	        	<td>{{ $resultado->total  - $resultado->creadas - $resultado->descartadas - $resultado->actualizadas - $resultado->no_sypelc - $resultado->no_encontradas }}</td> 
	        </tr>
	        <tr> 
	        	<td>Creadas</td> 
	        	<td>{{ $resultado->creadas }}</td> 
	        </tr>
	        <tr> 
	        	<td>Actualizadas</td>
	        	<td>{{ $resultado->actualizadas }}</td>
	        </tr>
	        <tr> 
	        	<td>Descartadas</td> 
	        	<td>{{ $resultado->descartadas }}</td> 
	        </tr>
	        <tr> 
	        	<td>No Sypelc</td> 
	        	<td>{{ $resultado->no_sypelc }}</td> 
	        </tr>
	        <tr> 
	        	<td>No Encontradas </td> 
	        	<td> {{ $resultado->no_encontradas }}</td> 
	        </tr>
        </table>
	</div>

	<div class="col-md-8">
		<h3>Lineas descartadas</h3>
		<table class="table table-hover">
			<tr class="active">
			    <th>Numero de Orden</th>  
			    <th>Motivo</th>
			    <th>Veces</th>
			</tr>
			@foreach ($descartadas as $descartada) 
			<tr>
   				<td>{{$descartada->idOrden}}</td>
   				<td>{{$descartada->nombre}}</td>
   				<td>{{$descartada->veces}}</td>
   			</tr>
   			@endforeach
		</table>
	</div>
@stop