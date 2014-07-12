<?php


class Devolucion extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	
	protected $table = 'tab_devolucion';
	protected $fillable = array('fecha', 'motivo', 'fecha_correcion', 'corregido_sn', 'orden_id', 'estado_id', 'entidad_id', 'oficio', 'lugar_devolucion_id');
	public $timestamps = false;
	public $incrementing = false; 
	public $errors;


	public function crear($orden_has_estado, $lugar_devolucion_id, $motivo, $corregido_sn, $fecha_correccion){
		$this->orden_id = $orden_has_estado->orden_id;
		$this->fecha = $orden_has_estado->fecha;
		$this->estado_id = $orden_has_estado->estado_id;
		$this->entidad_id = $orden_has_estado->entidad_id;
		$this->motivo = $motivo;
		$this->corregido_sn = $corregido_sn;
		$this->lugar_devolucion_id = $lugar_devolucion_id;
		if(!is_null($fecha_correccion) && Importer::validarFecha($fecha_correccion)){
			$this->fecha_correccion = $fecha_correccion;
		}
	}

	public static function buscar($orden_has_estado, $lugar_devolucion_id){
		$devolucion = Devolucion::where('orden_id', '=', $orden_has_estado->orden_id)
			->where('fecha', '=', $orden_has_estado->fecha)	
				->where('estado_id', '=', $orden_has_estado->estado_id)
					->where('entidad_id', '=', $orden_has_estado->entidad_id)
						->where('lugar_evolucion_id', '=', $lugar_devolucion_id)
							->first();
		return $devolucion;
	}
}