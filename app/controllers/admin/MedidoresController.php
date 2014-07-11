<?php

class Admin_MedidoresController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */

	public function index()
	{
		$models = Medidor::paginate(12);
		$modelsName = 'medidores';
		$attributes = array('id','marca', 'cliente_id', 'tipo', 'carga_instalada', 'carga_contratada', 'factor_multiplicacion');
        $attributeNames = array('Serie','Marca', 'Cliente', 'Tipo', 'Carga Instalada', 'Carga Contratada', 'Factor Multiplicacion');

        $buscarpor = array('id' => 'Serie');
		$tableName = 'tab_medidor';
        return View::make('admin/layoutlist', compact('models', 'modelsName', 'attributes', 'attributeNames', 'buscarpor', 'tableName'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
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
		$model = Medidor::find($id);
		
		if (is_null ($model)){
			App::abort(404);
		}

		$action = 'show';
		$modelsName = 'medidores';
		$attributes = array('id','marca', 'cliente_id', 'tipo', 'carga_instalada', 'carga_contratada', 'factor_multiplicacion');
        $attributeNames = array('Serie','Marca', 'Cliente', 'Tipo', 'Carga Instalada', 'Carga Contratada', 'Factor Multiplicacion');

        $buscarpor = array('id' => 'Serie');
		$tableName = 'tab_medidor';

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