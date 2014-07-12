<?php


class Cliente extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'tab_cliente';
	protected $fillable = array('id', 'municipio_id', 'direccion', 'ubicacion_ur', 'macro', 'servicio_id', 'nombre', 'numero_nodo', 'created_at', 'updated_at');
	public $timestamps = true;
	public $incrementing = false; 
	public $errors;

	public function crear($id, $municipio_id, $servicio_id, $ubicacion_ur){
		if(is_numeric($id)){
			$this->id = $id;
			$this->municipio_id = $municipio_id;
			$this->servicio_id = $servicio_id;
			$this->ubicacion_ur = $ubicacion_ur;
			return true;
		}
		return false;
	}

	public function crearNombreDireccion($id, $municipio, $servicio, $ubicacion_ur, $nombre, $direccion){
		if($this->crear($id, $municipio, $servicio, $ubicacion_ur)){
			$this->nombre = $nombre;
			$this->direccion = $direccion;
			return true;
		}
		return false;
	}

	public function crearNodoMacroDireccion($id, $municipio, $servicio, $ubicacion_ur, $nodo, $macro, $direccion){
		if($this->crear($id, $municipio, $servicio, $ubicacion_ur)){
			if($nodo){
				$this->numero_nodo = trim($nodo);
			}
			if($macro){
				$this->macro = trim($macro);
			}
			if($direccion){
				$this->direccion = $direccion;
			}
			return true;
		}
		return false;
	}

	public function crearCicloNombreDireccion($id, $municipio, $servicio, $ubicacion_ur, $ciclo, $nombre, $direccion){
		if($this->crear($id, $municipio, $servicio, $ubicacion_ur)){
			$this->ciclo = trim($ciclo);
			$this->nombre = $nombre;
			$this->direccion = $direccion;
			return true;
		}
		return false;
	}

	public function crearCicloRutaNombreDireccion($id, $municipio, $servicio, $ubicacion_ur, $ciclo, $ruta, $nombre, $direccion){
		if($this->crear($id, $municipio, $servicio, $ubicacion_ur)){
			$this->ciclo = trim($ciclo);
			$this->ruta = trim($ruta);
			$this->nombre = $nombre;
			$this->direccion = $direccion;
			return true;
		}
		return false;
	}

	public static function actualizarNodo($cliente, $nodo){
		Cliente::where('id', '=', $cliente->id) //Actualiza la base de datos
			->update(array('numero_nodo' => $nodo));
	}

	public static function actualizarMacro($cliente, $macro){
		Cliente::where('id', '=', $cliente->id) //Actualiza la base de datos
			->update(array('macro' => $macro));
	}

	public static function actualizarNodoMacroDireccion($cliente, $nodo,  $macro, $direccion){
		if($nodo && $macro && $direccion){
		Cliente::where('id', '=', $cliente->id) //Actualiza la base de datos
			->update(array('numero_nodo' => $nodo, 'macro' => $macro, 'direccion' => $direccion));
		}
	}

	public function agregarCicloRutaNombreDireccion($ciclo, $ruta, $nombre, $direccion){
		$this->ciclo = trim($ciclo);
		$this->ruta = trim($ruta);
		$this->nombre = $nombre;
		$this->direccion = $direccion;	
	}

	public function agregarCicloRutaNombreDireccionNodo($ciclo, $ruta, $nombre, $direccion, $nodo){
		if(is_numeric($ciclo)){
			$this->ciclo = trim($ciclo);
		}
		if(is_numeric($ruta)){
			$this->ruta = trim($ruta);
		}
		if($nombre && $nombre!= ' '){
			$this->nombre = $nombre;
		}
		if($direccion && $direccion!= ' '){
			$this->direccion = $direccion;
		}
		if($nodo && $nodo!= ' '){	
			$this->numero_nodo = $nodo;
		}
	}

	public function agregarCicloRutaNodo($ciclo, $ruta, $nodo){
		$this->ciclo = trim($ciclo);
		$this->ruta = trim($ruta);
		$this->numero_nodo = $nodo;
	}

	public function agregarCicloNombreDireccion($ciclo, $nombre, $direccion){
		$this->ciclo = trim($ciclo);
		$this->nombre = $nombre;
		$this->direccion = $direccion;	
	}
	public function agregarNombreDireccion($nombre, $direccion){
		$this->nombre = $nombre;
		$this->direccion = $direccion;	
	}

	public static function prueba($data)
	{
		$prueba = new Prueb;
			$prueba->ddd = 56;
			$prueba->save();
	}
}