<?php


class Archivo extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'tab_archivo';
	public $timestamps = false;
	public $incrementing = false; 
	public $errors;

}