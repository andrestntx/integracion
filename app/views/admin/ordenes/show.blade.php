@extends ('admin/layout')

@section ('title') Orden #-{{$orden->orden_id}} @stop

@section ('breadcrumbs')
    {{Breadcrumbs::render('model/action/id', $modelsName, $action, $orden->orden_id)}}
@stop

@section ('content') 
  <div class="col-md-4">
    <h1 style="font-size:19px;">Orden <b>{{$orden->orden_id}}</b></h1>
    <table class="table table-hover" style="font-size:16px;">
      <tr>
        <td>Proyecto:</td> <td>{{$orden->proyecto_id}}</td>
      </tr>
      <tr>
        <td>Tipo:</td> <td>{{$orden->tipo_id}}</td>
      </tr>
      <tr>
       <th>Cliente</th>
      </tr>
      <tr>
        <td>Cedula o Nit</td> <td>{{$orden->cliente_id}}</td>
      </tr>
      <tr>
        <td>Nombre</td> <td> {{$orden->cliente_nombre}}</td>
      </tr>
      <tr>
        <td>Municipio</td> <td>{{$orden->municipio_nombre}}</td>
      </tr>
      <tr>
        <td>Direccion</td> <td> {{$orden->direccion}}</td>
      </tr>
      <tr>
        <td>Servicio</td> <td> {{$orden->servicio_id}}</td>
      </tr>
      <tr>
        <td>Nodo</td> <td> {{$orden->numero_nodo}}</td>
      </tr>
      <tr>
        <td>Medidor</td> <td> {{$orden->medidor_id}}</td>
      </tr>
    </table>
  </div>

  <div class="col-md-8">
    <h3>Estados</h3>
    <table class="table table-hover">
      <tr>
        @foreach ($attributeNames as $name)
          <th>{{$name}}</th>  
        @endforeach
      </tr>
        @foreach ($states as $state) 
          <tr>
            @foreach ($attributes as $attribute)
              <td>{{$state->$attribute}}</td> 
            @endforeach
          </tr>
        @endforeach
    </table>
   
  </div>
@stop