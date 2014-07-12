@extends ('admin/layout')

@section ('title') Lista de {{ $modelsName }} @stop

@section ('breadcrumbs')
    {{Breadcrumbs::render('model/action/id', $modelsName, $action, $model->id)}}
@stop

@section ('content')
    <div class="col-md-12" style="margin: 0 0 10px 0;">
      <div class="col-md-4">
        <h2  style="margin:0;">Resultado: {{$model->id}}</h2>
      </div>
      <div class="col-md-4">
        <a href="{{ route('admin.'.$modelsName.'.create')}}" class="btn btn-primary" style="margin-top:5px;" >Crear Nuevo</a>
      </div>
      <div class="col-md-4">
        <div class="form-group">
          {{Form::open(array('url' => 'admin/estadisticas/findmodel', 'method' => 'get', 'class' => 'form-inline'))}}
            {{Form::select('buscarpor', $buscarpor, null, array('class' => 'form-control'))}}
            {{ Form::text('value', null, array('placeholder' => 'Buscar: ', 'class' => 'form-control', 'style' => 'width:50%;')) }}
            {{ Form::hidden('modelsName', $modelsName)}}
            {{ Form::hidden('tableName', $tableName)}}
          {{ Form::close() }}
    </div>
      </div>
    </div>
    <div class="col-md-12">
      <table class="table table-striped ">
        <tr>
            @foreach ($attributeNames as $name)
              <th>{{$name}}</th>  
            @endforeach
            <th>Accion</th>
        </tr>
        <tr >
            @foreach ($attributes as $attribute)
              <td>{{$model->$attribute}}</td> 
            @endforeach
            <td>
               @if($modelsName != 'revisiones' && $modelsName != 'solicitudes' && $modelsName != 'clientes' && $modelsName != 'medidores')
                <a href="{{ route('admin.'.$modelsName.'.edit', $model->id) }}" class="btn btn-primary" style="padding:2px 8px;">
                  Editar
                </a>
                @endif
              @if($modelsName == 'revisiones' || $modelsName == 'solicitues')
                <a href="{{ route('admin.'.$modelsName.'.show', $model->id) }}" class="btn btn-primary" style="padding:2px 8px;">
                  Estados
                </a>
              @endif
            </td>
        </tr>
      </table>
    </div>
  {{ Form::open(array('route' => array('admin.'.$modelsName.'.destroy', 'USER_ID'), 'method' => 'DELETE', 'role' => 'form', 'id' => 'form-delete')) }}
{{ Form::close() }}
@stop