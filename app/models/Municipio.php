<?php


class Municipio extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'tab_municipio';
	protected $fillable = array('id', 'nombre', 'factor_distancia');
	public $timestamps = false;
	public $incrementing = false; 
	public $errors;

	public function crear($data){
		$this->id = $data[0]; 
	    $this->nombre = $data[1];
	    $this->factor_distancia = $data[2];
	    $this->save();
	}

	public static function buscarPorNombre($nombre){
		$municipio = Municipio::
			where('nombre', '=', $nombre)
		    	->first();
		if(!$municipio){
			$municipio = Municipio::find(0);	
		}
		return $municipio;
	}

	public static function buscarPorIdEmnsa($id_emsa){
		$municipio = null;
		if(is_numeric($id_emsa)){
			$municipio = Municipio::
				where('id_emsa', '=', $id_emsa)
			    	->first();	
		}
		if(!$municipio){
			return 0;	
		}
		return $municipio->id;
	}
}