<?php

class Admin_ClientesController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */

	public function index()
	{
		$models = Cliente::select('tab_cliente.id as id', 'tab_cliente.nombre as cliente_nombre', 'direccion', 'tab_municipio.nombre as municipio_nombre', 'servicio_id', 'ubicacion_ur')
			->join('tab_municipio', 'tab_municipio.id', '=', 'municipio_id')
					->paginate(12);

		$modelsName = 'clientes';
		$attributes = array('id','cliente_nombre', 'direccion', 'municipio_nombre', 'servicio_id', 'ubicacion_ur');
        $attributeNames = array('Cedula','Nombre', 'Direccion', 'Municipio', 'Servicio', 'Ubicacion');

        $buscarpor = array('id' => 'Cedula');
		$tableName = 'tab_cliente';
        return View::make('admin/layoutlist', compact('models', 'modelsName', 'attributes', 'attributeNames', 'buscarpor', 'tableName'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		// Creamos un nuevo objeto User para ser usado por el helper Form::model
       	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{

	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$model = null;
		if(is_numeric($id)){
			$model = Cliente::select('tab_cliente.id as id', 'tab_cliente.nombre as cliente_nombre', 'direccion', 'tab_municipio.nombre as municipio_nombre', 'servicio_id', 'ubicacion_ur')
				->join('tab_municipio', 'tab_municipio.id', '=', 'municipio_id')
					->where('tab_cliente.id', '=', $id)
						->first();
		}
		if (is_null ($model)){
			App::abort(404);
		}

		$action = 'show';
		$modelsName = 'clientes';
		$attributes = array('id','cliente_nombre', 'direccion', 'municipio_nombre', 'servicio_id', 'ubicacion_ur');
        $attributeNames = array('Cedula','Nombre', 'Direccion', 'Municipio', 'Servicio', 'Ubicacion');

        $buscarpor = array('id' => 'Cedula');
		$tableName = 'tab_cliente';

        return View::make('admin/layoutshow', compact('model', 'modelsName', 'attributes', 'attributeNames', 'action', 'buscarpor', 'tableName'));	
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
	
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		
	}

}