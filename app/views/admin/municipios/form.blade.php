
<div class="row">
    <div class="form-group col-md-4">
      {{ Form::label('id', 'Id del municipio') }}
      {{ Form::text('id', null, array('placeholder' => 'Introduce Id del municipio', 'class' => 'form-control', $estadoid)) }}
    </div>
    <div class="form-group col-md-4">
      {{ Form::label('nombre', 'Nombre del Municipio') }}
      {{ Form::text('nombre', null, array('placeholder' => 'Introduce el nombre del municipio', 'class' => 'form-control')) }}        
    </div>
</div>
<div class="row">
	<div class="form-group col-md-4">
      {{ Form::label('factorDistancia', 'Factor Distancia') }}
      {{ Form::text('factorDistancia', null, array('placeholder' => 'Introduce el factor distancia', 'class' => 'form-control')) }}        
    </div>
</div>
