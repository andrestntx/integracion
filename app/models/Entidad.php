<?php

class Entidad extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'tab_entidad';
	protected $fillable = array('id', 'nombre');
	public $timestamps = false;
	public $incrementing = false; 
	public $errors;

}