<?php

class Admin_RevisionesController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(){
		
		$models  = ViewRevisiones::paginate(12);
		$modelsName = 'revisiones';
		$attributes = array('id', 'proyecto_id', 'cliente_id', 'municipio_nombre', 'ultimo_estado');
		$attributeNames = array('Número','Proyecto', 'Cliente', 'Municipio', 'Estado Actual');

		$buscarpor = array('orden_id' => 'Orden');
		$tableName = 'tab_orden_revision';
        return View::make('admin/layoutlist', compact('models', 'modelsName', 'attributes', 'attributeNames', 'buscarpor', 'tableName'));	
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		
		$modelsName = 'revisiones';
		$action = 'show';
		$orden = ViewRevisionesAsignadas::where('orden_id', '=', $id)->first();
		if (is_null ($orden)){
			App::abort(404);
		}

		$attributes = array('entidad','estado', 'fecha', 'tecnico_nombre', 'updated_at');
		$attributeNames = array('Entidad','Estado', 'Fecha', 'Tecnico', 'Actualización');
		$buscarpor = array('orden_id' => 'Orden');
		$tableName = 'tab_orden_revision';
		
		$states = ViewOrdenesHasEstados::where('orden_id', '=', $id)
			->orderBy('fecha', 'asc')
				->get();

		return View::make('admin/ordenes/show', compact('orden', 'states', 'attributes', 'attributeNames', 'modelsName', 'action', 'buscarpor', 'tableName'));	

	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}