<?php


class Recomendacion extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'tab_recomendacion';
	protected $fillable = array('id', 'descripcion');
	public $timestamps = false;
	public $incrementing = false; 
	public $errors;

	public function crear($id, $descripcion){
		$this->id = $id;
	    $this->descripcion = $descripcion;
	}
}