<?php

class Admin_ResultadosimporController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$resultados = Importacion::joinArchivo()
			->select('total', 'tab_importacion.id', 'creadas', 'actualizadas', 'updated_at', 'created_at', 'no_sypelc', 'no_encontradas', 'nombre', 'descartadas')
				->orderBy('created_at', 'desc')
					->paginate(12);
		return View::make('admin/import/list', compact('resultados'));  //Muestra los datos
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
		$resultado = Importacion::find($id);
		if (is_null($resultado)) {
            App::abort(404);
        }
        $descartadas = ImportacionDescarte::where('tab_importacion_descarte.importacion_id', '=', $resultado->id)
       		->join('tab_motivo_descarte', 'tab_motivo_descarte.id', '=', 'motivo_id')
       			->select('tab_motivo_descarte.nombre', 'orden_id', 'veces')
       				->get();


		return View::make('admin/import/see', compact('resultado', 'descartadas'));
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