<?php


class Tecnico extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'tab_tecnico';
	protected $fillable = array('id', 'nombre', 'nick');
	public $timestamps = false;
	public $incrementing = false; 
	public $errors;

	public static function buscar($nombre_nick){
		$tecnico = Tecnico::where('nombre', '=', $nombre_nick)->first();
		if(!$tecnico){
			$tecnico = Tecnico::where('nick', '=', $nombre_nick)->first();	
		}
		if($tecnico){
			return $tecnico->id;
		}
		else{
			return 0;
		}
	}

}