@extends ('admin/layout')

@section ('title') Estadisticas Sypelc @stop

@section ('breadcrumbs') @stop

@section ('content')
<h1 class="text-danger title">Sistema de Integración Documental</h1>
<div class="panel panel-danger">
	<div class="panel-heading"><h2>Administración</h2></div>
	<div class="panel-body">
		<div class="row">
			<div class="col-md-6">
				<div class="panel panel-default">
				  <!-- Default panel contents -->
				  <div class="panel-heading"><h3>Importar Archivos</h3></div>
					  <div class="panel-body">
					    <p>Importa los archivos genearados por EMSA y Sypelc</p>
					    <a href="{{ route('import') }}" class="btn btn-primary">
					    	<span class="glyphicon glyphicon-plus"></span> 
					    	Importar Archivos
					    </a>
					  </div>
				</div>	
			</div>
			<div class="col-md-6">
				<div class="panel panel-default">
				  <!-- Default panel contents -->
				  <div class="panel-heading"><h3>Estadisticas</h3></div>
					  <div class="panel-body">
					    <p>Genera las estadisticas de Revisiones y PQR de Sypelc</p>
					    </p>
					    <a href="{{ route('estadisticas') }}" class="btn btn-primary">
					    	<span class="glyphicon glyphicon-calendar"></span> 
					    	Ver Estadisticas
					    </a>
					  </div>
				</div>	
			</div>
		</div>
		<div class="row">
			<div class="col-md-12 center-block">
				<div class="panel panel-default">
				  <!-- Default panel contents -->
				  	<div class="panel-heading"><h3>Administrar Datos</h3></div>
					 	<div class="panel-body">
						    <p>Modifica, Agrega y Elimina datos del sistema</p>
						    <a href="{{ route('admin.tecnicos.index') }}" class="btn btn-primary">
						    	<span class="glyphicon glyphicon-user"></span> 
						    	Tecnicos
						    </a>
						    <a href="{{ route('admin.campanas.index') }}" class="btn btn-primary">
						    	<span class="glyphicon glyphicon-list-alt"></span> 
						    	Campañas
						    </a>
						    <a href="{{ route('admin.proyectos.index') }}" class="btn btn-primary">
						    	<span class="glyphicon glyphicon-list-alt"></span> 
						    	Proyectos
						    </a>
							<a href="{{ route('admin.municipios.index') }}" class="btn btn-primary">
								<span class="glyphicon glyphicon-plane"></span> 
								Municipios
							</a>
							<a href="{{ route('admin.clientes.index') }}" class="btn btn-primary">
								<span class="glyphicon glyphicon-user"></span> 
								Clientes
							</a>
							<a href="{{ route('admin.medidores.index') }}" class="btn btn-primary">
								<span class="glyphicon glyphicon-print"></span> 
								Medidores
							</a>
							<a href="{{ route('admin.revisiones.index') }}" class="btn btn-primary">
								<span class="glyphicon glyphicon-phone"></span> 
								Revisiones
							</a>
							<a href="{{ route('admin.solicitudes.index') }}" class="btn btn-primary">
								<span class="glyphicon glyphicon-phone"></span> 
								Solicitudes
							</a>
					  </div>
				</div>	
			</div>
		</div>
	</div>
</div>

@stop