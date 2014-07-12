<?php


class EjecucionHasIrregulardidad extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	
	protected $table = 'tab_ejecucion_has_irregularidad';
	protected $fillable = array('orden_id', 'fehca','estado_id', 'irregularidad_id');
	public $timestamps = false;
	public $incrementing = false; 
	public $errors;

	public function crear($ejecucion, $irregularidad){
		$this->orden_id = $ejecucion->orden_id;
		$this->fecha = $ejecucion->fecha;
		$this->entidad_id = $ejecucion->entidad_id;
		
		$this->irregularidad_id = $irregularidad->id;
	
		$this->save();
	}

	public static function buscar($ejecucion, $irregularidad){
		$irregularidadEjecucion = EjecucionHasIrregulardidad::where('orden_id', '=', $ejecucion->orden_id)
			->where('fecha', '=', $ejecucion->fecha)	
				->where('entidad_id', '=', $ejecucion->entidad_id)
					->where('irregularidad_id', '=', $irregularidad->id)
						->first();
		return $irregularidadEjecucion;
	}
}