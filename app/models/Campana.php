<?php


class Campana extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'tab_campana';
	protected $fillable = array('id', 'nombre', 'proyecto_id');
	public $timestamps = false;
	public $incrementing = false; 
	public $errors;
}