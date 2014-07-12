<?php


class LecturaMedidor extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'tab_lectura_medidor';
	protected $fillable = array('medidor_id','fecha_lectura', 'lectura');
	public $timestamps = false;
	public $incrementing = false; 
	public $errors;


	public function crear($medidor_id, $fecha_lectura, $lectura, $observacion_id = 0, $ajuste = 0){
		$this->medidor_id = $medidor_id;
		$this->fecha_lectura = $fecha_lectura;
		$this->lectura = $lectura;
		$this->observacion_id = $observacion_id;
		$this->ajuste = $ajuste;
	}

	public static function scopeActualizar($query, $lectura_medidor){
		return $query->where('medidor_id', '=', $lectura_medidor->medidor_id)
            ->where('fecha_lectura', '=', $lectura_medidor->fecha_lectura);
	}
}