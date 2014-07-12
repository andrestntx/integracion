<?php

class estadoEjecucion extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'tab_estado_ejecucion';
	protected $fillable = array('id', 'nombre', 'descripcion');
	public $timestamps = true;
	public $incrementing = false; 
	public $errors;

	public function crear($id, $nombre, $descripcion){
		$this->id = $id; 
		$this->nombre = $nombre;
		$this->descripcion = $descripcion;
	}

	public static function scopeBuscarPorNombre($query, $nombre){
		return $query->where('nombre', '=', $nombre);
	}

	public static function scopeBuscarPorLetra($query, $letra_id){
		return $query->where('letra_id', '=', $letra_id);
	}

}