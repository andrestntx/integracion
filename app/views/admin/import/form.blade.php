@extends ('admin/layout')

@section ('title') Importar Archivos @stop

@section ('breadcrumbs')
  {{Breadcrumbs::render('import')}}
@stop

@section ('content')
	<h1 class="text-danger">Importar Archivos</h1>
  <div class="panel panel-danger">
    <div class="panel-heading col-md-12"><h2 class="col-md-10">Modulo Importar </h2> <div class="col-md-2"><a href="{{ route('admin.import.resultado.index')}}" class="btn btn-danger">Resultados</a></div></div>
    <div class="panel-body ">
      <div class="col-md-6">
        <h3>Archivos Sypelc</h3>
        <div class="panel panel-default">
          <!-- Default panel contents -->
          <div class="panel-heading">Importar Archivo "Solicitudes EMSA"</div>
          <div class="panel-body">
            <p>Importa el archivo "solicitudes" generado por EMSA
            </p>
            {{ Form::open(array('id' => 'importForm', 'action' => 'Admin_ImportController@postArchivo', 'method' => 'POST', 'class' => 'form-horizontal', 'files' => true))}}
              <div class="form-group">
                <label class="control-label col-sm-3">Tipo Archivo</label> 
                <div class="col-sm-8">
                  {{Form::select('tipo', $importsypelc, null, array('class' => 'form-control'))}}
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-sm-3">Archivo</label> 
                <div class="col-sm-8">
                  {{ Form::file('archivo') }}
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-sm-3">Delimitador</label> 
                <div class="col-sm-8">
                  {{Form::select('delimitador', $delimitador, null, array('class' => 'form-control'))}}
                </div>
              </div>
              <div class="form-group">
                <div class="col-sm-offset-3 col-sm-9">
                {{ Form::button('Importar', array('type' => 'submit', 'class' => 'btn btn-primary disabled')) }}   
                </div>
              </div> 
            {{ Form::close() }}
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <h3>Archivos EMSA</h3>
        <div class="panel panel-default">
          <!-- Default panel contents -->
          <div class="panel-heading">Importar Archivo "Solicitudes EMSA"</div>
          <div class="panel-body">
            <p>Importa el archivo "solicitudes" generado por EMSA
            </p>
            {{ Form::open(array('id' => 'importForm', 'action' => 'Admin_ImportController@postArchivo', 'method' => 'POST', 'class' => 'form-horizontal', 'files' => true))}}
              <div class="form-group">
                <label class="control-label col-sm-3">Tipo Archivo</label> 
                <div class="col-sm-8">
                  {{Form::select('tipo', $importemsa, null, array('class' => 'form-control'))}}
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-sm-3">Archivo</label> 
                <div class="col-sm-8">
                  {{ Form::file('archivo') }}
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-sm-3">Delimitador</label> 
                <div class="col-sm-8">
                  {{Form::select('delimitador', $delimitador, null, array('class' => 'form-control'))}}
                </div>
              </div>
              <div class="form-group">
                <div class="col-sm-offset-3 col-sm-9">
                {{ Form::button('Importar', array('type' => 'submit', 'class' => 'btn btn-primary disabled')) }} 
                </div>  
              </div> 
            {{ Form::close() }}
          </div>
        </div>
      </div> 
    </div>
  </div>
</div>
@stop
