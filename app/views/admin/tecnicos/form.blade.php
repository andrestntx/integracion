
<div class="row">
    <div class="form-group col-md-4">
      {{ Form::label('id', 'Id del Tecnico') }}
      {{ Form::text('id', null, array('placeholder' => 'Introduce Id del tecnico', 'class' => 'form-control', $estadoid)) }}
    </div>
    <div class="form-group col-md-4">
      {{ Form::label('nombre', 'Nombre del Tecnico') }}
      {{ Form::text('nombre', null, array('placeholder' => 'Introduce el nombre del tecnico', 'class' => 'form-control')) }}        
    </div>
</div>

<div class="row">
    <div class="form-group col-md-4">
      {{ Form::label('nick', 'Nick') }}
      {{ Form::text('nick', null, array('placeholder' => 'Introduce el Nick del tecnico', 'class' => 'form-control')) }}
    </div>
</div>

