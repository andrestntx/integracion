@extends ('admin/layout')

@section ('title') {{ $action.' '.$modelsName }} @stop

@section ('breadcrumbs')
  @if($action == 'edit')
    {{Breadcrumbs::render('model/action/id', $modelsName, $action, $model->id)}}
  @else
    {{Breadcrumbs::render('model/action', $modelsName, $action, $actionName)}}
  @endif
@stop

@section ('content')
  <div class="col-md-12" style="padding:0;">
      <h1 style="margin-top:0; display:inline-block;">{{ $actionName.' '.$modelsName }} </h1>
   </div> 

{{ Form::model($model, $form_data, array('role' => 'form')) }}

  @include ('admin/errors', array('errors' => $errors))

  @include('admin/'.$modelsName.'/form' , array($proyectosSelect, $model))

  {{ Form::button('Guardar' , array('type' => 'submit', 'class' => 'btn btn-primary')) }}    
  
{{ Form::close() }}


@stop