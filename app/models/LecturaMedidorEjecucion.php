<?php


class LecturaMedidorEjecucion extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	
	protected $table = 'tab_lectura_medidor_ejecucion';
	protected $fillable = array('id', 'marca', 'lectura', 'estado_ei');
	public $timestamps = false;
	public $incrementing = false; 
	public $errors;

	public function crear($medidor_id,$ejecucion,$lectura,$estado_ei){
		if(is_numeric($lectura)){
			$this->estado_ei = $estado_ei;
			$this->orden_id = $ejecucion->orden_id;
			$this->fecha = $ejecucion->fecha;

			$this->entidad_id = $ejecucion->entidad_id;
			$this->medidor_id = $medidor_id;
			$this->lectura = $lectura;
			
			return true;
		}
		return false;
	}

	public static function buscar($ejecucion, $estado_ei){
		$lectura = LecturaMedidorEjecucion::where('orden_id', '=', $ejecucion->orden_id)
			->where('fecha', '=', $ejecucion->fecha)	
				->where('entidad_id', '=', $ejecucion->entidad_id)
					->where('estado_ei', '=', $estado_ei)
						->first();
		return $lectura;
	}
}