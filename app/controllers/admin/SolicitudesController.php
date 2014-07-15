<?php

class Admin_SolicitudesController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$models  = ViewSolicitudes::paginate(12);

		$buscarpor = array('id' => 'Orden', 'solicitud' => 'Solicitud');
		$tableName = 'view_solicitudes';

		$modelsName = 'solicitudes';
		$attributes = array('consecutivo', 'dependencia_id','solicitud', 'cliente_id', 'nombre');
		$attributeNames = array('Consecutivo', 'Dependencia','Solicitud', 'Cliente', 'Municipio');
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

	public function show($id){
		
		$modelsName = 'solicitudes';
		$action = 'show';
		$orden = ViewSolicitudesAsignadas::where('orden_id', '=', $id)->first();
		
		if (is_null ($orden)){
			App::abort(404);
		}								

		$attributes = array('entidad','estado', 'fecha', 'tecnico_nombre', 'updated_at');
		$attributeNames = array('Entidad','Estado', 'Fecha', 'Tecnico', 'Actualización');

		
		$states = ViewOrdenesHasEstados::where('orden_id', '=', $id)
			->orderBy('fecha', 'asc')
				->get();

		return View::make('admin/ordenes/show', compact('orden', 'states', 'attributes', 'attributeNames', 'modelsName', 'action'));
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