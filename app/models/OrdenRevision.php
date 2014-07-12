<?php


class OrdenRevision extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'tab_orden_revision';
	protected $fillable = array('orden_id', 'proyecto_id');
	public $timestamps = false;
	public $incrementing = false; 
	public $errors;

	public function crear($orden_id, $proyecto_id){
	    $this->orden_id = $orden_id;
        $this->proyecto_id = $proyecto_id;
	}

}
