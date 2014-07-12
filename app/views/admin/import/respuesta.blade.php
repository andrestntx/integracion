@extends ('admin/layout')

@section ('title') Importar Archivos @stop

@section ('breadcrumbs')
	{{Breadcrumbs::render(Route::currentRouteName())}}
@stop

@section ('content') 
	<div class="col-md-12">
		@if ($respuesta['error'] == true)
			<div class="alert alert-danger">
				<h1 style="font-size:20px;">
					<span class="glyphicon glyphicon-remove"></span>
					¡Error! - {{$respuesta['mensaje']}}
				</h1>
			</div>
		@else
			<div class="alert alert-success">
				<h1 style="font-size:20px;">
					<span class="glyphicon glyphicon-ok"></span>
					¡Bien! - {{$respuesta['mensaje']}}
				</h1>
			</div>
			<div class="col-md-12">
				<p style="font-size:18px;">
					<span class="glyphicon glyphicon-cog"></span>
					El archivo se está importando actualmente. Puedes conocer su proceso con el siguiente id 
					{{HTML::link('admin/import/resultado/'.$respuesta['id'], $respuesta['id'])}}
				</p>
			</div>
		@endif
	</div>

@stop