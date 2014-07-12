
<div class="row">
    <div class="form-group col-md-4">
      {{ Form::label('id', 'Id del Proyecto') }}
      {{ Form::text('id', null, array('placeholder' => 'Introduce Id del proyecto', 'class' => 'form-control', $estadoid)) }}
    </div>
    <div class="form-group col-md-4">
      {{ Form::label('nombre', 'Nombre del Proyecto') }}
      {{ Form::text('nombre', null, array('placeholder' => 'Introduce el nombre del proyecto', 'class' => 'form-control')) }}        
    </div>
  </div>
