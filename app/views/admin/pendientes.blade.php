@extends ('admin/layout')

@section ('title') Estadistica - Esados Pendientes @stop

@section ('content')
<header class="row">
	<h2 class="text-primary">Ordenes de Revision Pendientes</h2>
</header>
<div class="row">
    <div class="col-md-12">
    
		<table class="table table-hover " style="width: 90%">
		    <tr class="active">
		          <th>numeroOrden</th>  
		          <th>fechaGeneracion</th>
		    </tr>
		    @foreach ($pendientes as $pendiente)
		        <td>{{$pendiente->id}}</td> 
		        <td>{{$pendiente->fecha}}</td> 
		    </tr>
		    @endforeach
		</table>
		{{ $pendientes->links() }}
    </div>	
</div>
@stop