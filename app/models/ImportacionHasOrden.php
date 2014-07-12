<?php


class ImportacionHasOrden extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'tab_importacion_has_orden';
	protected $fillable = array('orden_id', 'importacion_id');
	public $timestamps = false;
	public $incrementing = false; 
	public $errors;

	public static function crear($orden_id, $importacion_id){
		$importacion_has_orden = new ImportacionHasOrden;
	    $importacion_has_orden->orden_id = $orden_id;
	    $importacion_has_orden->importacion_id = $importacion_id;
	    $importacion_has_orden->save();
	    return $importacion_has_orden;
	}

	public static function buscar($orden_id, $importacion_id){
		return $resultado = ImportacionHasOrden::where('orden_id' , '=' , $orden_id) //Busca si ya existe el medidor
			->where('importacion_id', '=' , $importacion_id)
				->first();
	}
}