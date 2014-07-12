<?php


class Valor extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	
	protected $table = 'tab_valor';
	protected $fillable = array('id', 'ubicacion_ur', 'valor_unitario', 'puntos');
	public $timestamps = false;
	public $incrementing = false; 
	public $errors;


	public static function buscar($id, $ubicacion_ur){
		$valor = Valor::where('id', '=', $id) //Busca si ya existe el estado pendiente en esta orden
			->where('ubicacion_ur', '=', $ubicacion_ur)
				->first();
		return $valor;
	}
}