<?php


class EjecucionHasEstado extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'tab_ejecucion_has_estado';
	protected $fillable = array('orden_id', 'fecha', 'estado_id', 'entidad_id', 'created_at', 'updated_at', 'estado_ejecucion_id' );
	public $timestamps = false;
	public $incrementing = false; 
	public $errors;

	public function crear($ejecucion, $estado_id){
		$this->orden_id = $ejecucion->orden_id; 
		$this->fecha = $ejecucion->fecha;
		$this->entidad_id = $ejecucion->entidad_id;
		$this->estado_ejecucion_id = $estado_id;
		$this->created_at = date('Y-m-d H:i:s');
		$this->updated_at = date('Y-m-d H:i:s');
	}

	public static function buscar($ejecucion, $estado_id){
		$resultado = EjecucionHasEstado::where('orden_id', '=', $ejecucion->orden_id)
			->where('fecha', '=', $ejecucion->fecha)
				->where('entidad_id', '=', $ejecucion->entidad_id)
					->where('estado_ejecucion_id', '=', $estado_id)
					->first();
		return $resultado;
	}

}
