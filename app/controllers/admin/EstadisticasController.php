<?php

class Admin_EstadisticasController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */

	public function __construct() {
   		$this->beforeFilter('csrf', array('on'=>'post'));
   		$this->beforeFilter('auth', array('only'=>
   			array('getIndex', 'getPendientes', 'postSavefraudes', 'postSavetecnicos', 
   				'postSaveproyectos', 'getFraudes', 'getRecuperacion', 'getRecomendaciones','getDatostecnicos', 'getDatosproyectos')));
	}


	public function getIndex(){
		$ruta = Route::currentRouteName();
		$revision = Importacion::where('archivo_id', '=', 'rev')->orderBy('created_at', 'desc')->lists('created_at', 'id');
		$solicitudes = Importacion::where('archivo_id', '=', 'sol')->orderBy('created_at', 'desc')->lists('created_at', 'id');
		$devolucion = Importacion::where('archivo_id', '=', 'dev')->orderBy('created_at', 'desc')->lists('created_at', 'id');
		$sistemas = Importacion::where('archivo_id', '=', 'sist')->orderBy('created_at', 'desc')->lists('created_at', 'id');

		$tipo_orden = TipoOrden::orderBy('id', 'asc')->lists('nombre', 'id');

		$estadisticas = array(
			'estadisticas/ejecuciones' => 'Todas las Ejecuciones', 
			'estadisticas/ejecucionespqr' => 'Solicitudes Ejecutadas', 
			'estadisticas/ejecucionesrev' => 'Campañas Ejecutadas', 
			'estadisticas/tecnicos' => 'Tecnicos', 
			'estadisticas/proyectos' => 'Proyectos'
		);
		return View::make('admin/estadisticas/inicio', compact('ruta', 'revision', 'solicitudes', 'estadisticas', 'devolucion', 'sistemas', 'tipo_orden'));
	}

	public function getConfecha(){
		$fechaInicio = Input::get('fechaInicio');
		$fechaFinal = Input::get('fechaFinal');

		return Redirect::route(Input::get('ruta'), array('fechaInicio' => $fechaInicio, 'fechaFinal' => $fechaFinal));
	}

	public function getPendientes(){
		$importacion_id = Input::get('importacion');
		$devolucion_importacion_id = Input::get('importacion_dev');
		$fechaInterventoria = Input::get('fechaInterventoria');
		$sistemas_importacion_id = Input::get('importacion_sist');	
		$tipo_orden = Input::get('tipo_orden');	
		
		$nombresAtributos = array('Cuenta','Nombre', 'Direccion', 'Municipio', 'Servicio', 'U','Medidor', 'Orden','Generacion', 'Estado');
		$nombreEstadistica = 'Ordenes Pendientes';
		$nombreModelo = 'pendientes';

		if($tipo_orden == 1){
			$resultado = DB::select(DB::raw("select * from fun_pendientes_revisiones('".$fechaInterventoria."','".$importacion_id."','".$devolucion_importacion_id."','".$sistemas_importacion_id."')"));	
			$atributos = array('cliente_id', 'cliente_nombre', 'cliente_direccion', 'municipio', 'servicio_id', 'ubicacion_ur', 'medidor' ,'orden_id','fechageneracion', 'estado');

		}
		else{
			$resultado = DB::select(DB::raw("select * from fun_pendientes_solicitudes('".$fechaInterventoria."','".$importacion_id."','".$devolucion_importacion_id."','".$sistemas_importacion_id."')"));		
			$atributos = array('cliente_id', 'cliente_nombre', 'cliente_direccion', 'municipio', 'servicio_id', 'ubicacion_ur', 'medidor' ,'orden_id','fecha_generacion', 'estado');

		}
		if(!$resultado){
			return View::make('admin/estadisticas/notfound', 
    			compact('modelos', 'nombreEstadistica', 'nombresAtributos', 'nombreModelo'
    		)); 	
		}
		else{
			$page = Input::get('page', 1);
			$pages = array_chunk($resultado, 12);
			$modelos = Paginator::make($pages[$page -1], count($resultado), 12);
		 	
	    	return View::make('admin/estadisticas/layoutlist', 
	    		compact('modelos', 'nombreEstadistica', 'atributos', 'nombresAtributos', 'nombreModelo', 'importacion_id', 
	    			'devolucion_importacion_id', 'fechaInterventoria','check_sist', 'sistemas_importacion_id', 'tipo_orden'
	    	));  // Muestra los datos 
	    }
	}

	public function postPendientes(){
		$importacion_id = Input::get('importacion');
		$devolucion_importacion_id = Input::get('importacion_dev');
		$fechaInterventoria = Input::get('fechaInterventoria');
		$sistemas_importacion_id = Input::get('importacion_sist');
		$tipo_orden = Input::get('tipo_orden');	

		if($tipo_orden == 1){
			$datos = DB::select(DB::raw("select * from fun_pendientes_revisiones('".$fechaInterventoria."','".$importacion_id."','".$devolucion_importacion_id."','".$sistemas_importacion_id."')"));	
			$titulos = array('Cuenta','Nombre', 'Direccion', 'Municipio', 'Servicio', 'Ubicacion','Medidor', 'Proyecto', 'Orden','Generacion', 'Estado', 'Prog', 'Eje', 'Dev', 'Updated', 'Entrega', 'Sistemas');

		}
		else{
			$datos = DB::select(DB::raw("select * from fun_pendientes_solicitudes('".$fechaInterventoria."','".$importacion_id."','".$devolucion_importacion_id."','".$sistemas_importacion_id."')"));		
			$titulos = array('Orden', 'Dependencia', 'Solicitud', 'Consecutivo', 'Cuenta','Nombre', 'Direccion', 'Ubicacion', 'Municipio', 'Servicio','Medidor', 'Generacion', 'Estado', 'Prog', 'Eje', 'Dev', 'Updated', 'Entrega', 'Sistemas');

		}

		SimpleCsv::export($datos, $titulos);	
	}

	public function getEjecuciones(){
		$fechaInicio = Input::get('fechaInicio');
		$fechaFinal = Input::get('fechaFinal');

		$atributos = array('orden_id', 'fecha', 'cliente_id','servicio_id', 'medidor_id', 'municipio_nombre', 'tecnico_nombre', 'estado_fv', 'proyecto_id', 'aforo', 'produccion', 'recuperacion');
		$nombresAtributos = array('Orden', 'Fecha Atencion', 'Cuenta', 'Servicio', 'Medidor', 'Municipio', 'Tecnico', 'Estado', 'Proyecto', 'Aforo', 'Produccion', 'Recuperacion');
		$nombreEstadistica = 'Todas las Ejecuciones';
		$nombreModelo = 'ejecuciones';

		$modelos = DB::table('view_ejecuciones_sypelc')
			->where('fecha', '>', $fechaInicio)
				->where('fecha', '<', $fechaFinal)
						->orderBy('fecha', 'desc')
							->paginate(12);
		
		return View::make('admin/estadisticas/layoutlist', compact('fechaInicio', 'fechaFinal', 'nombreEstadistica', 'nombreModelo', 'atributos', 'nombresAtributos', 'modelos', 'totales'));
	}

	public function postEjecuciones(){
		$fechaInicio = Input::get('fechaInicio');
		$fechaFinal = Input::get('fechaFinal');

		$datos= DB::table('view_ejecuciones_sypelc')
			->where('fecha', '>', $fechaInicio)
				->where('fecha', '<', $fechaFinal)
					->orderBy('recuperacion', 'asc')
						->select('orden_id', 'fecha', 'cliente_id', 'servicio_id', 'medidor_id', 'municipio_nombre', 'tecnico_nombre', 'estado_fv', 'proyecto_id', 'aforo', 'produccion', 'recuperacion')
							->get();

		$titulos = array('Orden', 'Fecha Atencion', 'Cuenta', 'Servicio', 'Medidor', 'Municipio', 'Tecnico', 'Estado', 'Proyecto', 'Aforo', 'Produccion', 'Recuperacion');

		SimpleCsv::export($datos, $titulos);	
	}

	public function getEjecucionesrev(){
		$fechaInicio = Input::get('fechaInicio');
		$fechaFinal = Input::get('fechaFinal');

		$atributos = array('orden_id', 'fecha', 'cliente_id', 'tecnico_nombre', 'estado_fv', 'proyecto_id', 'produccion', 'recuperacion');
		$nombresAtributos = array('Orden', 'Fecha Atencion', 'Cuenta', 'Tecnico', 'Estado', 'Proyecto', 'Produccion', 'Recuperacion');
		$nombreEstadistica = 'Ejecuciones de Campañas';
		$nombreModelo = 'ejecucionesrev';

		$modelos = DB::table('view_ejecuciones_sypelc')
			->where('fecha', '>', $fechaInicio)
				->where('fecha', '<', $fechaFinal)
					->where('nombre', '=', 'REVISION')	
						->orderBy('fecha', 'desc')
							->paginate(12);
		
		return View::make('admin/estadisticas/layoutlist', compact('fechaInicio', 'fechaFinal', 'nombreEstadistica', 'nombreModelo', 'atributos', 'nombresAtributos', 'modelos', 'totales'));
	}

	public function postEjecucionesrev(){
		$fechaInicio = Input::get('fechaInicio');
		$fechaFinal = Input::get('fechaFinal');

		$datos= DB::table('view_ejecuciones_sypelc')
			->where('fecha', '>', $fechaInicio)
				->where('fecha', '<', $fechaFinal)
					->where('nombre', '=', 'REVISION')	
						->orderBy('recuperacion', 'asc')
							->select('orden_id', 'fecha', 'cliente_id', 'tecnico_nombre', 'estado_fv', 'proyecto_id', 'produccion', 'recuperacion')
								->get();

		$titulos = array('Orden', 'Fecha Atencion', 'Cuenta', 'Tecnico', 'Estado', 'Proyecto', 'Produccion', 'Recuperacion');

		SimpleCsv::export($datos, $titulos);	
	}

	public function getEjecucionespqr(){
		$fechaInicio = Input::get('fechaInicio');
		$fechaFinal = Input::get('fechaFinal');

		$atributos = array('orden_id', 'fecha', 'cliente_id', 'municipio_nombre', 'tecnico_nombre', 'estado_fv', 'produccion', 'recuperacion');
		$nombresAtributos = array('Orden', 'Fecha Atencion', 'Cuenta', 'Municipio', 'Tecnico', 'Estado', 'Produccion', 'Recuperacion');
		$nombreEstadistica = 'Ejecuciones de Pqr';
		$nombreModelo = 'ejecucionespqr';

		$modelos = DB::table('view_ejecuciones_sypelc')
			->where('fecha', '>', $fechaInicio)
				->where('fecha', '<', $fechaFinal)
					->where('nombre', '=', 'SOLICITUD')	
						->orderBy('fecha', 'desc')
							->paginate(12);
		
		return View::make('admin/estadisticas/layoutlist', compact('fechaInicio', 'fechaFinal', 'nombreEstadistica', 'nombreModelo', 'atributos', 'nombresAtributos', 'modelos', 'totales'));
	}

	public function postEjecucionespqr(){
		$fechaInicio = Input::get('fechaInicio');
		$fechaFinal = Input::get('fechaFinal');

		$datos= DB::table('view_ejecuciones_sypelc')
			->where('fecha', '>', $fechaInicio)
				->where('fecha', '<', $fechaFinal)
					->where('nombre', '=', 'SOLICITUD')	
						->orderBy('fecha', 'desc')
							->select('orden_id', 'fecha', 'cliente_id', 'municipio_nombre', 'tecnico_nombre', 'estado_fv', 'proyecto_id', 'produccion', 'recuperacion')
								->get();

		$titulos = array('Orden', 'Fecha Atencion', 'Cuenta', 'Municipio', 'Tecnico', 'Estado', 'Proyecto', 'Produccion', 'Recuperacion');

		SimpleCsv::export($datos, $titulos);	
	}

	public function getTecnicos(){
		$fechaInicio = Input::get('fechaInicio');
		$fechaFinal = Input::get('fechaFinal');
		$page = Input::get('page', 1);
		$nombreEstadistica = 'Datos por Tecnico';
		$nombreModelo = 'tecnicos';

		$resultado = DB::select(DB::raw("select * from fun_ejecuciones_groupby_tecnico('".$fechaInicio."','".$fechaFinal."') "));

		$pages = array_chunk($resultado, 12);
		$modelos = Paginator::make($pages[$page -1], count($resultado), 12);
		$atributos = array('nombre', 'ejecutadas_sypelc', 'fraudes_sypelc', 'verificadas_sypelc', 'produccion_sypelc', 'recuperacion_sypelc');
		$nombresAtributos = array('Tecnico', 'EjecutadasSypelc', 'Fraude', 'Verificadas', 'Produccion', 'Recuperacion');

		return View::make('admin/estadisticas/layoutlist', compact('fechaInicio', 'fechaFinal', 'nombreEstadistica', 'nombreModelo', 'atributos', 'nombresAtributos', 'modelos'));
	}

	public function postTecnicos(){
		$fechaInicio = Input::get('fechaInicio');
		$fechaFinal = Input::get('fechaFinal');

		$resultado = DB::select(DB::raw("select * from fun_ejecuciones_groupby_tecnico('".$fechaInicio."','".$fechaFinal."') "));

		$titulos = array('Cedula Tecnico', 'Nick Tecnico', 'Nombre Tecnico', 'EjecutadasSypelc', 'Fraude', 'Verificadas', 'Produccion', 'Recuperacion');
		SimpleCsv::export($resultado, $titulos);	
	}

	public function getProyectos(){
		$fechaInicio = Input::get('fechaInicio');
		$fechaFinal = Input::get('fechaFinal');
		$page = Input::get('page', 1);

		$resultado = DB::select(DB::raw("select * from fun_ejecuciones_groupby_proyectos('".$fechaInicio."','".$fechaFinal."')"));
		$pages = array_chunk($resultado, 12);
		$datos = Paginator::make($pages[$page -1], count($resultado), 12);
		$atributos = array('proyecto_id', 'asignadas_emsa', 'ejecutadas_emsa', 'ejecutadas_sypelc', 'fraudes_sypelc', 'verificadas_sypelc', 'produccion_sypelc', 'recuperacion_sypelc');
		$nombresAtributos = array('Proyecto', 'Asignadas', 'EjecutadasEmsa', 'EjecutadasSypelc', 
				'Fraude', 'Verificadas', 'Produccion', 'Recuperacion'
		);

		return View::make('admin/estadisticas/proyectos', compact('fechaInicio', 'fechaFinal', 'datos', 'atributos', 'nombresAtributos'));
	}

	public function postProyectos(){
		$fechaInicio = Input::get('fechaInicio');
		$fechaFinal = Input::get('fechaFinal');

		$titulos = array('Proyecto', 'Asignadas', 'EjecutadasEmsa', 'EjecutadasSypelc', 'Fraude', 'Verificadas', 'Produccion', 'Recuperacion');

		$datos = DB::select(DB::raw("select * from fun_ejecuciones_groupby_proyectos('".$fechaInicio."','".$fechaFinal."')"));


		SimpleCsv::export($datos, $titulos);	
	}

	public function getFindmodel(){
		$modelsName = Input::get('modelsName');
		$tableName = Input::get('tableName');
		$value = Input::get('value');
		$buscarpor = Input::get('buscarpor');

		try {
			$model = DB::table($tableName)->where($buscarpor, '=', $value)->first();	
		} catch (Exception $e) {
			App::abort(404);	
		}

		if($model){
			if($modelsName == 'revisiones' || $modelsName == 'solicitudes'){
				return Redirect::route('admin.'.$modelsName.'.show', array($model->orden_id));	
			}
			else{
				return Redirect::route('admin.'.$modelsName.'.show', array($model->id));
			}
		}
		else{
			App::abort(404);
		}
	}
}