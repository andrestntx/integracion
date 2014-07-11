<?php

class Admin_MunicipiosController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$models = Municipio::paginate(10);
		$modelsName = 'municipios';
		$attributes = array('id','nombre', 'factorDistancia');
        $attributeNames = array('Id','Nombre', 'Factor Distancia');

        $buscarpor = array('id' => 'Numero', 'nombre' => 'Nombre');
		$tableName = 'tab_municipio';

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
        $model = new Municipio;
        $form_data = array('route' => 'admin.municipios.store', 'method' => 'POST');
        $actionName    = 'Crear';  
        $action = 'create';
        $estadoid ='';
        $modelsName = 'municipios';	
      	$proyectosSelect = null;
        return View::make('admin/layoutform', compact('model', 'form_data', 'modelsName', 'action', 'actionName', 'estadoid', 'proyectosSelect'));
    }

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		// Creamos un nuevo objeto para nuestro nuevo usuario
        $municipio = new Municipio;
        // Obtenemos la data enviada por el usuario
        $data = Input::all();
        $municipio->fill($data);
        $municipio->save();
        return Redirect::route('admin.municipios.index');
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
			$model = Municipio::find($id);
		}
		if (is_null ($model)){
			App::abort(404);
		}

		$action = 'show';
		$modelsName = 'municipios';
		$attributes = array('id','nombre', 'factorDistancia');
        $attributeNames = array('Id','Nombre', 'Factor Distancia');

        $buscarpor = array('id' => 'Numero', 'nombre' => 'Nombre');
		$tableName = 'tab_municipio';

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
		$model = Municipio::find($id);
		if (is_null ($model)){
			App::abort(404);
		}

		$form_data = array('route' => array('admin.municipios.update', $model->id), 'method' => 'PATCH');
        $actionName    = 'Editar';
        $action = 'edit';
        $estadoid  = 'disabled';
        $modelsName = 'municipios';
		$proyectosSelect = null;
        return View::make('admin/layoutform', compact('model', 'form_data', 'modelsName', 'action', 'actionName', 'estadoid', 'proyectosSelect'));
    }

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		// Creamos un nuevo objeto para nuestro nuevo usuario
        $municipio = Municipio::find($id);
        
        // Si el usuario no existe entonces lanzamos un error 404 :(
        if (is_null ($municipio))
        {
            App::abort(404);
        }
        
        // Obtenemos la data enviada por el usuario
        $data = Input::all();
        $municipio->nombre = $data['nombre'];
        $municipio->factorDistancia = $data['factorDistancia'];
        $municipio->save();
    	return Redirect::route('admin.municipios.index');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$municipio = Municipio::find($id);
        
        if (is_null ($municipio))
        {
            App::abort(404);
        }
        
        $municipio->delete();

        if (Request::ajax())
        {
            return Response::json(array (
                'success' => true,
                'msg'     => 'Municipio ' . $municipio->nombre . ' eliminado',
                'id'      => $municipio->id
            ));
        }
        else
        {
            return Redirect::route('admin.municipios.index');
        }
	}


}