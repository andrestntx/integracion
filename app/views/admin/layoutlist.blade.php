@extends ('admin/layout')

@section ('title') Lista de {{ $modelsName }} @stop

@section ('breadcrumbs')
  {{Breadcrumbs::render('model', $modelsName)}}
@stop

@section ('content')
    <div class="col-md-12" style="margin: 0 0 10px 0;">
      <div class="col-md-4">
        <h1  style="margin:0;">Lista de {{ $modelsName }}</h1>
      </div>
      @if($modelsName != 'revisiones' && $modelsName != 'solicitudes' && $modelsName != 'clientes' && $modelsName != 'medidores')
      <div class="col-md-4">
        <a href="{{ route('admin.'.$modelsName.'.create')}}" class="btn btn-primary" style="margin-top:5px;" >Crear Nuevo</a>
      </div>
      @endif
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
    <div class="col-md-2">
      @if ($modelsName == 'revisiones' || $modelsName == 'solicitudes')
        {{Form::open(array('url' => 'admin/estadisticas/'.$modelsName, 'method' => 'post'))}}
          {{ Form::button('Descargar', array('type' => 'submit', 'class' => 'btn btn-primary')) }}  
        {{ Form::close() }}
      @endif
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
        @foreach ($models as $model)
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
              
              @if($modelsName == 'revisiones' || $modelsName == 'solicitudes')
                <a href="{{ route('admin.'.$modelsName.'.show', $model->id) }}" class="btn btn-primary" style="padding:2px 8px;">
                  Estados
                </a>
              @endif
            </td>
        </tr>
        @endforeach
      </table>
    </div>
  {{ $models->links() }}
  {{ Form::open(array('route' => array('admin.'.$modelsName.'.destroy', 'USER_ID'), 'method' => 'DELETE', 'role' => 'form', 'id' => 'form-delete')) }}
{{ Form::close() }}
@stop