<?php


class TipoSolicitud extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'tab_tipo_solicitud';
	protected $fillable = array('tipo_id', 'dependencia_id', 'accion_id', 'clase');
	public $timestamps = false;
	public $incrementing = false; 
	public $errors;

	public function crear($tipo, $dependencia, $accion, $clase){
	    $this->tipo_id = $tipo->id;
	    $this->dependencia_id = $dependencia->id;
	    $this->accion_id = $accion->id;
	    if($clase){
	    	$this->clase = $clase;
	    }
	}

	public static function buscar($tipo_id, $dependencia_id, $accion_id){
		$tipoPQR = Tipo_solicitud:: //Busca si el medidor ya está asociado al cliente
			where('tipo_id' , '=' , $tipo_id)
				->where('dependencia_id', '=' , $dependencia_id)
					->where('accion_id', '=' , $accion_id)
						->first();
		return $tipoPQR;
   	}
}






