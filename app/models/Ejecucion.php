<?php


class Ejecucion extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'tab_ejecucion';
	protected $fillable = array('entidad_id', 'orden_id', 'fecha', 'estado_id', 'estado_fv', 'acta');
	public $timestamps = false;
	public $incrementing = false; 
	public $errors;

	public function crear($orden_has_estado){
		$this->orden_id = $orden_has_estado->orden_id; 
		$this->fecha = $orden_has_estado->fecha;
		$this->estado_id = $orden_has_estado->estado_id;
		$this->entidad_id = $orden_has_estado->entidad_id;
	}

	public function agregarEstadoActaAforo($estado_fv, $acta, $aforo){
		$this->estado_fv = $estado_fv;
		$this->acta = $acta;
		$this->aforo = $aforo;
	}

	public static function buscarPorActa($orden, $acta, $entidad){
		if($orden && $acta){
			$ejecucion = Ejecucion::where('orden_id', '=', $orden->id)	
				->where('entidad_id', '=', $entidad->id)	
					->where('acta', '=', $acta)
						->get();
			if(count($ejecucion) == 1){
				$ejecucion = Ejecucion::where('orden_id', '=', $orden->id)	
				->where('entidad_id', '=', $entidad->id)	
					->where('acta', '=', $acta)
						->first();
				return $ejecucion;
			}
		}
	}

	public static function buscar($orden_has_estado){
		$ejecucion = Ejecucion::where('orden_id', '=', $orden_has_estado->orden_id)
			->where('fecha', '=', $orden_has_estado->fecha)
				->where('estado_id', '=', $orden_has_estado->estado_id)
					->first();
		return $ejecucion;
	}

	public static function scopeActualizar($query, $orden_has_estado){
		return $query->where('orden_id', '=', $orden_has_estado->orden_id)
			->where('fecha', '=', $orden_has_estado->fecha)
				->where('estado_id', '=', $orden_has_estado->estado_id);
	}

	public static function buscarComoSea($acta, $entidad_id){
		if($acta){
			$ejecucion = Ejecucion::where('entidad_id', '=', $entidad_id)	
					->where('acta', '=', $acta)
						->get();
			if(count($ejecucion) == 1){
				$ejecucion = Ejecucion::where('entidad_id', '=', $entidad_id)	
						->where('acta', '=', $acta)
							->first();
				return $ejecucion;
			}
		}
		else if($acta){
			$ejecucion = Ejecucion::where('acta', '=', $acta)
				->get();
			if(count($ejecucion) == 1){
				return $ejecucion;
			}
		}
		return false;
	}
}