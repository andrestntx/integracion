<?php


class EjecucionHasValor extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	
	protected $table = 'tab_ejecucion_has_valor';
	//protected $fillable = array('id', 'ubicacionUR', 'valorUnitario', 'puntos');
	public $timestamps = false;
	public $incrementing = false; 
	public $errors;

	public function crear($ejecucion, $valor){
		$this->orden_id = $ejecucion->orden_id;
		$this->fecha = $ejecucion->fecha;
		$this->entidad_id = $ejecucion->entidad_id;

		$this->valor_id = $valor->id;
		$this->valor_ubicacion_ur = $valor->ubicacion_ur;
		$this->save();
	}

	public static function buscar($ejecucion, $valor){
		$valorEjecucion = EjecucionHasValor::where('orden_id', '=', $ejecucion->orden_id)
			->where('fecha', '=', $ejecucion->fecha)	
				->where('entidad_id', '=', $ejecucion->entidad_id)
					->where('valor_id', '=', $valor->id)
						->where('valor_ubicacion_ur', '=', $valor->ubicacion_ur)
							->first();
		return $valorEjecucion;
	}
}