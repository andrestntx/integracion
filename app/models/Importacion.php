<?php


class Importacion extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'tab_importacion';
	protected $fillable = array('id');
	public $timestamps = true;
	public $incrementing = true; 
	public $errors;

	public function scopeJoinArchivo($query){
		return $query->join('tab_archivo', 'archivo_id', '=', 'tab_archivo.id');
	}

	public static function crear($id, $tipoArchivo_id){
		$resultado = new Importacion;
        $resultado->id = $id;
        $resultado->archivo_id = $tipoArchivo_id;
        $resultado->save();
        return $resultado;
    }

}