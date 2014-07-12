<!DOCTYPE html>
<html>
  <head>
    <title>@yield('title', 'Aprendiendo Laravel')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- Bootstrap --}}
    {{ HTML::style('assets/css/bootstrap.min.css', array('media' => 'screen')) }}
    {{ HTML::style('assets/css/themes/base/jquery-ui.css', array('media' => 'screen')) }}
    {{ HTML::style('assets/css/main.css', array('media' => 'all')) }}

    {{-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries --}}
    <!--[if lt IE 9]>
        {{ HTML::script('assets/js/html5shiv.js') }}
        {{ HTML::script('assets/js/respond.min.js') }}
    <![endif]-->
  </head>
  <body>
    {{-- Wrap all page content here --}}
    <div class="page">
      <nav class="navbar navbar-inverse navbar-fixed-top color" role="navigation">
        <div class="container">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
              <span class="sr-only">Menu Principal</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a href="{{URL::to('admin')}}" class="'navbar-brand pull-left'">{{HTML::image('images/logosypelc.png', 'Estadisticas Spelc', array('width' => 120, 'height' => 48))}}</a> 
           
          </div>
          <div class="collapse navbar-collapse navbar-ex1-collapse">
            <ul class="nav navbar-nav">
              <li class="active">{{ HTML::link('admin', 'Inicio')}}</li>
              <li class="active">{{ HTML::link('admin/import', 'Importar')}}</li>
              <li class="active">{{ HTML::link('admin/estadisticas', 'Estadisticas')}}</li>
              <li class="dropdown">
                <a class="dropdown-toggle" id="administrar" data-toggle="dropdown" href="#">
                  Administrar
                  <span class="caret"></span>
                </a>
                <ul class="dropdown-menu" role="menu">
                  <li>{{ HTML::link('admin/tecnicos', 'Tecnicos')}}</li>
                  <li>{{ HTML::link('admin/campanas', 'Campañas')}}</li>
                  <li>{{ HTML::link('admin/proyectos', 'Proyectos')}}</li>
                  <li>{{ HTML::link('admin/municipios', 'Municipios')}}</li>
                  <li>{{ HTML::link('admin/clientes', 'Clientes')}}</li>
                  <li>{{ HTML::link('admin/medidores', 'Medidores')}}</li>
                  <li class="divider"></li>
                  <li>{{ HTML::link('admin/revisiones', 'Revisiones')}}</li>
                  <li>{{ HTML::link('admin/solicitudes', 'Solicitudes')}}</li>
                </ul>
              </li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
            @if(!Auth::check())
              <li>{{ HTML::link('login', 'Iniciar Sesión') }}</li>  
            @else
              <p class="navbar-text" style="font-size:16px;">Hola, {{Auth::user()->name}}</p>
              <li >{{ HTML::link('logout', 'Cerrar Sesión') }}</li>
            @endif
            </ul>
          </div>
      </nav>
      <div class="container wrap">   
        <div class="row">
          <div class="col-md-12">
            @yield('breadcrumbs', Breadcrumbs::render('admin'))
            
            @yield('content', 'sin contenido')
          </div>
        </div>  
      </div>
    </div>


    {{-- jQuery (necessary for Bootstrap's JavaScript plugins) --}}
    {{ HTML::script('assets/js/jquery.js') }}
    {{-- Include all compiled plugins (below), or include individual files as needed --}}
    {{ HTML::script('assets/js/bootstrap.min.js') }}
    {{ HTML::script('assets/js/admin.js') }}
    {{ HTML::script('assets/js/jquery-ui.js') }}

<link id="bs-css" rel="stylesheet" href="http://netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css">

    <script>
    $(document).ready(function(){
      $(function() {
        $("#content-fecha input").datepicker();
        $('#content-fecha input').datepicker('option', {dateFormat: 'dd/mm/yy'});
      });
      $("#startDate").datepicker({dateFormat: 'dd/mm/yy'});
    });

    </script>

    <script>
      $('form input[type=file]').change(function () {
        $(this).parents('form').find('button').removeClass('disabled');
      });
    </script>

    <script>
      $('form .input-group :checkbox').change(function () {
          if($(this).is(':checked')){
            $(this).parents('.input-group').children('select').prop('disabled', false);
          }
          else{
            $(this).parents('.input-group').children('select').prop('disabled', true);
          }
      });
    </script>

    <script>
      $('form .date-requerid').change(function () {
          if($(this).parents('form').find('.date-requerid').val()){  
            //$(this).parents('form').css('width', '500px');
            $(this).parents('form').find('button').removeClass('disabled');
          }
          else{
            $(this).parents('form').find('button').addClass('disabled');
          }
      });
    </script>

    <script>
      $(document).ready(function(){
        $('form #enable-input').change(function () {  
         var optionvalue = $(this).val();
          $(this).parents('.form-group').find('select#'+optionvalue).css('display', 'initial');
          $(this).parents('.form-group').find('select#'+optionvalue).prop('disabled', false);
          $(this).parents('.form-group').find('#enable-inputs select').each(function(){
            if($(this).attr('id') != optionvalue){
              $(this).css('display', 'none');
              $(this).prop('disabled', true);
            }
          });
        });  
      });
    </script>

  </body>
</html>