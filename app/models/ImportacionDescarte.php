<?php


class ImportacionDescarte extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'tab_importacion_descarte';
	protected $fillable = array('importacion_id');
	public $timestamps = false;
	public $incrementing = false; 
	public $errors;


	public static function buscar($importacion_id, $orden_id, $motivo_id){
		$descartada = ImportacionDescarte::where('importacion_id', '=', $importacion_id) //Busca si ya existe el estado pendiente en esta orden
			->where('orden_id', '=', $orden_id)		
				->where('motivo_id', '=', $motivo_id)
						->first();	
		return $descartada;
	}


}