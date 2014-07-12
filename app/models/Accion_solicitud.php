<?php


class Accion_solicitud extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'tab_accion_solicitud';
	protected $fillable = array('id', 'descripcion');
	public $timestamps = false;
	public $incrementing = false; 
	public $errors;

	public function crear($id, $descripcion = null){
		$this->id = $id;
		if($descripcion){
	    	$this->descripcion = $descripcion;
	    }
	}
}