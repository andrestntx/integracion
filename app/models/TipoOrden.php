<?php


class TipoOrden extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'tab_tipo_orden';
	protected $fillable = array('id', 'nombre');
	public $timestamps = false;
	public $incrementing = false; 
	public $errors;

	public static function buscarPorNombre($nombre){
		$tipoOrden = TipoOrden::where('nombre', '=', trim($nombre))
		    ->first();
		if($tipoOrden){
			return $tipoOrden->id;
		}
	}

}