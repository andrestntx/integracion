<?php


class Proyecto extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'tab_proyecto';
	protected $fillable = array('id', 'nombre');
	public $timestamps = false;
	public $incrementing = false; 
	public $errors;

	public function crear($data){	
		$this->id = $data[0]; 
	    $this->nombre = $data[1];
	    $this->save();
	}

	public static function buscar($id){
		$proyecto = Proyecto::find($id);
		if(!$proyecto){
			$proyecto = Proyecto::find(0);
		}
		return $proyecto;
	}

}