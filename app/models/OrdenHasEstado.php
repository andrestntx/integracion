<?php

class OrdenHasEstado extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'tab_orden_has_estado';
	protected $fillable = array('orden_id', 'estado_id', 'fecha', 'entidad_id', 'tecnico_id', 'oficio_id');
	public $timestamps = false;
	public $incrementing = false; 
	public $errors;

	public function crear($orden_id, $fecha, $estado_id, $entidad_id, $tecnico_id = 0){
		$this->orden_id = $orden_id;
		$this->fecha = trim($fecha);
		$this->estado_id = $estado_id;
		$this->entidad_id = $entidad_id;
		$this->tecnico_id = $tecnico_id;
		$this->created_at = date('Y-m-d H:i:s');
		$this->updated_at = date('Y-m-d H:i:s');
	}

	public static function buscar($orden_id, $fecha, $estado_id, $entidad_id){
		$orden_has_estado = OrdenHasEstado::where('orden_id', '=', $orden_id) //Busca si ya existe el estado pendiente en esta orden
			->where('fecha', '=', $fecha)		
				->where('estado_id', '=', $estado_id)
					->where('entidad_id', '=', $entidad_id)
						->first();	
		return $orden_has_estado;
	}

	public static function actualizarTecnico($tecnico, $orden_has_estado){
		if($orden_has_estado->tecnico_id != $tecnico->id){
			OrdenHasEstado::where('orden_id', '=', $orden_has_estado->orden_id) //Actualiza la base de datos
				->where('fecha', '=', $orden_has_estado->fecha)		
					->where('estado_id', '=', $orden_has_estado->estado_id)
						->update(array('tecnico_id' => $tecnico->id));	
		}	
	}

	public static function scopeActualizar($query, $orden_has_estado){
		return $query->where('orden_id', '=', $orden_has_estado->orden_id) //Actualiza la base de datos
					->where('fecha', '=', $orden_has_estado->fecha)		
						->where('estado_id', '=', $orden_has_estado->estado_id);
	}

	

	public function scopeJoinEntidad($query){
		return $query->join('tab_entidad', 'entidad_id', '=', 'entidad.id');
	}

	public function scopeJoinEstado($query){
		return $query->join('tab_estado_orden', 'estado_id', '=', 'estado_orden.id');
	}

	public function scopeConEstado($query, $estado){
		return $query->where('estado_id', '=', $estado);
	}

	public function scopeConEntidad($query, $entidad){
		return $query->where('entidad_id', '=', $entidad);
	}

	public function scopeEntreFecha($query, $fechaInicio, $fechaFinal){
		return $query->where('fecha', '>', $fechaInicio)
			->where('fecha', '<', $fechaFinal);
	}	

	public function scopeJoinTecnico($query){
		return $query->join('tab_tecnico', 'tecnico_id', '=', 'tecnico.id');
	}

	public function scopeJoinPendientes($query){
		return $query->join('tab_pendientes', 'orden_id', '=', 'pendientes.id');
	}

	public function scopeJoinOrden($query, $tipo){
		if($tipo){
			return $query->join('tab_orden', 'orden_id', '=', 'orden.id')
				->where('tipoOrden_id' , '=' , $tipo);
		}
		return $query->join('tab_orden', 'orden_id', '=', 'orden.id');
	}

	public function scopeJoinEjecucion_has_valor($query){
		return $query->join('tab_ejecucion', function ($join){
			$join->on('orden_has_estado.orden_id', '=', 'ejecucion.orden_id')
				->on('orden_has_estado.entidad_id', '=', 'ejecucion.entidad_id')
					->on('orden_has_estado.estado_id', '=', 'ejecucion.estado_id')
						->on('orden_has_estado.fecha', '=', 'ejecucion.fecha');
		})
			->join('tab_ejecucion_has_valor', function ($join){
				$join->on('ejecucion.orden_id', '=', 'ejecucion_has_valor.orden_id')
					->on('ejecucion.entidad_id', '=', 'ejecucion_has_valor.entidad_id')
						->on('ejecucion.estado_id', '=', 'ejecucion_has_valor.estado_id')
							->on('ejecucion.fecha', '=', 'ejecucion_has_valor.fecha');
			})
				->join('tab_valor', function ($join){
					$join->on('ejecucion_has_valor.valor_id', '=', 'valor.id')
						->on('ejecucion_has_valor.valor_ubicacionRU', '=', 'valor.ubicacionRU');
				});
	}

	public function scopeJoinEjecucion($query){
		return $query->join('tab_ejecucion', function ($join){
			$join->on('orden_has_estado.orden_id', '=', 'ejecucion.orden_id')
				->on('orden_has_estado.entidad_id', '=', 'ejecucion.entidad_id')
					->on('orden_has_estado.estado_id', '=', 'ejecucion.estado_id')
						->on('orden_has_estado.fecha', '=', 'ejecucion.fecha');
		});
	}
}