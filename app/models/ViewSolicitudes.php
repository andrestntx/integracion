<?php


class ViewSolicitudes extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'view_solicitudes';
	protected $fillable = null;
	public $timestamps = false;
	public $incrementing = false; 
	public $errors;


}