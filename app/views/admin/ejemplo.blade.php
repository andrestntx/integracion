@extends ('admin/layout')

@section ('content')
    <div class="col-md-12" style="margin: 0 0 10px 0;">
      
      </div>
    </div>
    <div class="col-md-12">
      <table class="table table-striped ">
        @foreach ($models as $model)
        <tr >
            {{$model->id}}
        </tr>
        @endforeach
      </table>
    </div>
  {{ $models->links() }}
{{ Form::close() }}
@stop