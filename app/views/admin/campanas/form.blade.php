
<div class="row">
    <div class="form-group col-md-4">
      {{ Form::label('id', 'Id de la Campaña') }}
      {{ Form::text('id', null, array('placeholder' => 'Introduce Id de la campaña', 'class' => 'form-control', $estadoid)) }}
    </div>
    <div class="form-group col-md-4">
      {{ Form::label('nombre', 'Nombre de la Campaña') }}
      {{ Form::text('nombre', null, array('placeholder' => 'Introduce el nombre de la  campaña', 'class' => 'form-control')) }}        
    </div>
</div>
<div class="row">
	<div class="form-group col-md-4">
      {{ Form::label('proyecto_id', 'Id del Proyecto') }}
      {{ Form::select('proyecto_id', $proyectosSelect, $model->proyecto_id, array('class' => 'form-control'))}}
    </div>
    
</div>
