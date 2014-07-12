<?php


class Variable extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	
	protected $table = 'tab_variable';
	protected $fillable = null;
	public $timestamps = false;
	public $incrementing = false; 
	public $errors;

}