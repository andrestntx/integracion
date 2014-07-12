<?php


class Medidor extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'tab_medidor';
	protected $fillable = array('id','cliente_id', 'marca', 'fecha', 'tipo', 'factor_multiplicacion', 'tipo_energia');
	public $timestamps = true;
	public $incrementing = false; 
	public $errors;


	public function crear($id, $cliente_id, $marca = null, $tipo =null, $factor_multiplicacion = null, $tipo_energia = null, $carga_contratada = null, $carga_instalada = null){
		$this->id = $id;
		$this->cliente_id = $cliente_id;
		if($marca){
			$this->marca = $marca;
		}
		if($tipo){
		    $this->tipo = $tipo;
		}
		if($factor_multiplicacion){
		    $this->factor_multiplicacion = $factor_multiplicacion;
		}
		if($tipo_energia){
		    $this->tipo_energia = $tipo_energia;
		}
		if($carga_instalada && is_numeric($carga_instalada)){
            $this->carga_instalada = $carga_instalada;
        }
        if($carga_contratada && is_numeric($carga_contratada)){
            $this->carga_contratada = $carga_contratada;
        }
	}
}