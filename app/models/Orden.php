<?php


class Orden extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'tab_orden';
	protected $fillable = array('id', 'tipo_orden_id', 'medidor_id');
	public $timestamps = true;
	public $incrementing = false; 
	public $errors;

	public function crear($id, $tipo_orden_id, $medidor_id){
		$this->id = $id;
		$this->tipo_orden_id = $tipo_orden_id;
		$this->medidor_id = $medidor_id;
	}

	public static function findSelectId($id){ 
		return DB::table('orden')->select ('id')->where('id', '=' ,$id)->first();
	}

	public function scopeJoinCliente($query){
		return $query->join('cliente', 'cliente_id', '=', 'cliente.id');
	}

	public function scopeConId($query, $id){
		return $query->where('orden.id', '=', $id);
	}
}