<?php


class Servicio extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'tab_servicio';
	protected $fillable = array('id', 'nombre');
	public $timestamps = false;
	public $incrementing = false; 
	public $errors;

	public static function buscarPorNombre($nombre){
		$servicio = Servicio::
			where('nombre', '=', $nombre)
		    	->first();
		if(!$servicio){
			return 'ZZ';	
		}
		return $servicio->id;
	}
}