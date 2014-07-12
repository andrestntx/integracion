@extends ('admin/layout')

@section ('title') Recomendaciones y Creditos @stop

@section ('content')

<header class="row">
	<h2 class="text-primary">Recomendaciones y Creditos</h2>
</header>
<div class="row">
    <div class="col-md-11">
    	
		<div class="panel panel-primary">
			<!-- Default panel contents -->
			<div class="panel-heading">Recomendaciones</div>
			<div class="panel-body">
				<ul style="font-size:16px; text-align:justify">
					<li > 
						<p>El archivo excel "Consolidado Factura" generado por Sypelc contiene "columnas basura".
							<br>A partir de la columna 44 trae alrededor de 16 columnas más sin contenido, pero que al 
							importarlo genera un gasto innecesario de memoria. 
							<br><b>Antes de subir el archivo por favor</b>
							eliminelas.
						</p>
					</li>
					<li>
						<p>La columna <b> aforo </b> del archivo "Consolidado Factura (que es usada para generar una de 
						las estadisticas de la aplicacion) trae más de el 40% de casillas en 0, nulas o vacias. 
						Lo cual hace que la estadistica sea de mucha desconfianza.
						</p>
					</li>
					<li>
						<p>Los formatos de las distintas casillas de fechas en el archivo "Consolidado Factura" son incoherentes.
						Esto hace que no se puedan ralizar las estadisticas de forma completa teniendo en cuenta rangos de fechas.
						Lo ideal es que todas las casillas tengan el siguiente formato <b>2013/12/31</b>.
						</p>
					</li>
					<li>
						<p>La casilla tecnicos no está estandarizada, <b>hay hasta 5 diferentes nombre para un mismo tecnico</b>, lo cual
						hace que sea casi imposible obtener estadisticas a partir de ellos. Por favor cambiar el nombre del tecnico
						por el número de cedula del mismo. Así el sistema inmediatamente los reconocerá. 
						</p>
					</li>
					<li>
						<p>Antes de importar los archivos verifique que todos los tecnicos, proyectos y municipios se encuentren
						en el sistema. Sino se encuentra puede agregarlo desde la interfaz inicial. 
						</p>
					</li>
				</ul>	
			</div>
		</div>

		<div class="panel panel-primary">
			<!-- Default panel contents -->
			<div class="panel-heading">Creditos</div>
			<div class="panel-body" style="font-size:16px;">
				<p>Desarrollado con: -Lenguaje: <b>PHP</b> -Framework: <b>Laravel 4.0</b> -Bases de Datos: <b>Postgresql</b>
				-Version html: <b>Html5</b> -CSS: <b>Bootstrap</b>	
				</p>
				<p>Ubicación del Proyecto: <b>/var/www/campanas</b></p>
				<p>Desarrollado por: <b>Andrés Mauricio Pinzón</b> -Tw: <b>@andrestntx</b> -Email: <b>andrespinzon@nuestramarca.com</b></p>
				<a href="http://nuestramarca.com/">{{HTML::image('images/firma_andres.jpg')}}</a>
			</div>


		</div>

    </div>	
</div>
@stop