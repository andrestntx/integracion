<?php


class ViewOrdenesHasEstados extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'view_ordenes_has_estados';
	protected $fillable = null;
	public $timestamps = false;
	public $incrementing = false; 
	public $errors;

	protected function getDateFormat(){
		return 'Y-m-d H:i:s+';
	}
}