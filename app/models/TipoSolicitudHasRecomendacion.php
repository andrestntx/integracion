<?php


class TipoSolicitudHasRecomendacion extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'tab_tipo_solicitud_has_recomendacion';
	protected $fillable = array('tipo_id', 'dependencia_id', 'accion_id', 'recomendacion_id');
	public $timestamps = false;
	public $incrementing = false; 
	public $errors;

	public function crear($tipoSolicitud, $recomendacion){
	    $this->dependencia_id = $tipoSolicitud->dependencia_id;
	    $this->tipo_id = $tipoSolicitud->tipo_id;
	    $this->accion_id = $tipoSolicitud->accion_id;
	    $this->recomendacion_id = $recomendacion->id;  
	}

	public static function buscar($tipoSolicitud, $recomendacion){
		$ordenPQR_has_recomendacion = TipoSolicitudHasRecomendacion:: //Busca si el medidor ya está asociado al cliente
			where('tipo_id' , '=' , $tipoSolicitud->tipo_id)
				->where('dependencia_id', '=' , $tipoSolicitud->dependencia_id)
					->where('accion_id', '=' , $tipoSolicitud->accion_id)
						->where('recomendacion_id', '=' , $recomendacion->id)
							->first();
		return $ordenPQR_has_recomendacion;
   	}
}