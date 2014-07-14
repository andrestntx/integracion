<html>
  	<head>
	    <title>Inicia Sesión - Sypelc Ltda</title>
	    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	    {{-- Bootstrap --}}
	    {{ HTML::style('assets/css/bootstrap.min.css', array('media' => 'screen')) }}

	    {{-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries --}}
	    <!--[if lt IE 9]>
	        {{ HTML::script('assets/js/html5shiv.js') }}
	        {{ HTML::script('assets/js/respond.min.js') }}
	    <![endif]-->
  	</head>
	<body>
	    {{-- Wrap all page content here --}}
	    <div id="wrap">
	    	{{-- Begin page content --}}
	      	<div class="container" style="margin-top:50px;">
			<div class="row col-sm-12">
				<div class="row col-sm-6">
					{{HTML::image('images/inicio.jpg', 'Sypelc', array('style' => 'width:90%; margin: 0 5% 0 5%') ) }}
				</div>
			<div class="row col-sm-6">
				<h3>Iniciar Sesión</h3>
				{{ Form::open(array('url' => 'login', 'class' => 'form-horizontal')) }}
					<div class="form-group">
						<!-- if there are login errors, show them here -->
						{{ $errors->first('username') }}
						{{ $errors->first('password') }}
					</div>

					<div class="form-group">
						<div class="col-sm-12">
							{{ Form::text('username', Input::old('username'), array('placeholder' => 'Usuario', 'class'=> 'form-control')) }}
						</div>
					</div>

					<div class="form-group">
						<div class="col-sm-12">
							{{ Form::password('password', array('class'=> 'form-control', 'placeholder' => 'Contraseña')) }}
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-12">
							{{ Form::submit('Iniciar', array('type'=>'button', 'class' => 'btn btn-primary'))}}
						</div>
					</div>
					
				{{ Form::close() }}
			</div>
		</div>	
	</body>
</html>

