<?php


class OrdenSolicitud extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'tab_orden_solicitud';
	protected $fillable = array('solicitud', 'consecutivo', 'dependencia_id', 'tipo_id', 'accion_id', 'direccion', 'observacion');
	public $timestamps = false;
	public $incrementing = false; 
	public $errors;

	public function crear($solicitud, $consecutivo, $tipoSolicitud, $orden_id){
	    $this->solicitud = $solicitud;
	    $this->consecutivo = $consecutivo;
	    $this->dependencia_id = $tipoSolicitud->dependencia_id;
	    $this->tipo_id = $tipoSolicitud->tipo_id;
	    $this->accion_id = $tipoSolicitud->accion_id;
	    $this->orden_id = $orden_id;
	}

	public function agregarDireccionObservacion($direccion, $observacion){
		$this->direccion = $direccion;
	    $this->observacion = $observacion;
	}

	public static function buscar($solicitud, $consecutivo, $tipoSolicitud){
		$ordenPqr = OrdenSolicitud::where('solicitud', '=', $solicitud)
			->where('consecutivo', '=', $consecutivo)	
				->where('dependencia_id', '=', $tipoSolicitud->dependencia_id)
					->first();
		return $ordenPqr;
	}

	public static function buscar_orden($dependencia_id, $solicitud, $consecutivo){
		$ordenPqr = OrdenSolicitud::where('solicitud', '=', $solicitud)
			->where('consecutivo', '=', $consecutivo)	
				->where('dependencia_id', '=', $dependencia_id)
					->first();
		return $ordenPqr;
	}

	public static function buscarOrden($solicitud, $consecutivo){
		$orden = DB::select(DB::raw("select * from fun_buscar_orden('".$solicitud."','".$consecutivo."')"));	
		if($orden){
			return $orden[0];
		}
		else{
			return null;
		}
	}

}






