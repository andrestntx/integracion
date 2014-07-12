<?php

class EstadoOrden extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'tab_estado_orden';
	protected $fillable = array('id', 'nombre', 'descripcion');
	public $timestamps = false;
	public $incrementing = false; 
	public $errors;

}