<?php


class Irregularidad extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'tab_irregularidad';
	protected $fillable = array('id', 'descripcion');
	public $timestamps = false;
	public $incrementing = false; 
	public $errors;



}