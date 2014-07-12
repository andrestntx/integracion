@extends ('admin/layout')

@section ('title') Estadisticas Sypelc @stop

@section ('breadcrumbs')
	{{Breadcrumbs::render('estadisticas')}}
@stop

@section ('content')
<h1 class="text-danger">Estadisticas Sypelc</h1>

<div class="panel panel-danger">
	<div class="panel-heading">Estadisticas</div>
	<div class="panel-body">
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-default">
				  <!-- Default panel contents -->
				  <div class="panel-heading">Revisiones Pendientes</div>
				  <div class="panel-body">
				    <p>Estadistica de Ordenes Pendientes generadas por EMSA,
				    	comparando los archivos de Sypelc
				    </p>
				    {{Form::open(array('url' => 'admin/estadisticas/pendientes', 'method' => 'get', 'class' => 'form-horizontal', 'role' => 'form'))}}
					    <div class="form-group">
					    	<label class="control-label col-sm-2">Tipo Orden</label>
					    	<div class="col-sm-2">
					    		{{Form::select('tipo_orden', $tipo_orden, null, array('class' => 'form-control', 'id' => 'enable-input'))}}
					    	</div>
					    	<div class="col-sm-3" id="enable-inputs">
				    			{{Form::select('importacion', $revision, null, array('class' => 'form-control', 'id' => '1'))}}
				    			{{Form::select('importacion', $solicitudes, null, array('disabled','class' => 'form-control', 'style' => 'display:none;', 'id' => '2'))}}
				    		</div>
				 		</div>
				 		<div class="form-group">
				 			<label class="control-label col-sm-2">Devolucion</label>
				 			<div class="col-sm-5">
				    			{{Form::select('importacion_dev', $devolucion, null, array('class' => 'form-control'))}}
				    		</div>
				 		</div>
				 		<div class="form-group">
				 			<label class="control-label col-sm-2">Sistemas</label>
							<div class="col-sm-5">
								<div class="input-group">
									<span class="input-group-addon">
										{{Form::checkbox('check_sist','yes', false)}}
									</span>
									{{Form::select('importacion_sist', $sistemas, null, array('disabled', 'class' => 'form-control'))}}
								</div><!-- /input-group -->
							</div>
						</div>	
				 		<div id="content-fecha" class="form-group ">
				 			<label class="control-label col-sm-2">Interventoria</label>
					 		<div id="datepicker" class="col-sm-5">
								{{Form::text('fechaInterventoria', null, array('class' => 'datepicker date-requerid form-control', 'data-date-format' => 'dd/mm/yyyy', 'placeholder' => 'Fecha Interventoria'))}}
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-offset-2 col-sm-10">
					 			{{Form::button('Buscar Pendientes', array('type' => 'submit', 'class' => 'btn btn-primary disabled')) }} 
					 		</div>  
					 	</div>
					{{ Form::close() }}
				</div>
				</div>	
				<div class="panel panel-default">
				  <!-- Default panel contents -->
				  <div class="panel-heading">Estadisticas Por</div>
					  <div class="panel-body">
					    <p>Ordene las estadisticas según lo necesite
					    </p>
					    {{Form::open(array('url' => 'admin/estadisticas/confecha', 'method' => 'post', 'class' => 'form-horizontal'))}}
					    	<div class="form-group">
					    		<label class="control-label col-sm-2">Fecha</label>
						    	<div id="content-fecha" class="col-sm-5">
									<div id="datepicker" class="input-daterange input-group">
										{{Form::text('fechaInicio', '01/01/2012', array('class' => 'form-control datepicker input-sm', 'data-date-format' => 'dd/mm/yyyy', 'placeholder' => 'Fecha Inicio'))}}
										<span class="input-group-addon">Hasta</span>
										{{Form::text('fechaFinal', null, array('class' => 'form-control datepicker input-sm date-requerid', 'data-date-format' => 'dd/mm/yyyy', 'placeholder' => 'Fecha Final'))}}
									</div>
								</div>
							</div>
						    <div class="form-group">
						    	<label class="control-label col-sm-2">Ordenar Por</label>
						    	<div class="col-sm-5">
					    			{{Form::select('ruta', $estadisticas, null, array('class' => 'form-control'))}}
					    		</div>
					 		</div>
					 		<div class="form-group">
								<div class="col-sm-offset-2 col-sm-10">
					 				{{Form::button('Ver Estadistica', array('type' => 'submit', 'class' => 'btn btn-primary disabled')) }} 
					 			</div>
					 		</div>   
					    {{ Form::close() }}
					  </div>
				</div>	
			</div>
		</div>
	</div>

@stop