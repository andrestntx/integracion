<?php

class Admin_TecnicosController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */


	public function index()
	{
		$models = Tecnico::orderBy('nombre')->paginate(12);
		$modelsName = 'tecnicos';
		$attributes = array('id','nombre', 'nick');
		$attributeNames = array('Id','Nombre', 'Nick');

		$buscarpor = array('id' => 'Cedula', 'nombre' => 'Nombre', 'nick' => 'Nick');
		$tableName = 'tab_tecnico';

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
        $model = new Tecnico;
        $form_data = array('route' => 'admin.tecnicos.store', 'method' => 'POST');
        $actionName    = 'Crear';  
        $action = 'create';
        $estadoid ='';
        $modelsName = 'tecnicos';	
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
        $tecnico = new Tecnico;
        // Obtenemos la data enviada por el usuario
        $data = Input::all();
        $tecnico->fill($data);
        $tecnico->save();
        return Redirect::route('admin.tecnicos.index');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id){
		$model = null;
		if(is_numeric($id)){
			$model = Tecnico::find($id);
		}
		if (is_null ($model)){
			App::abort(404);
		}

		$action = 'show';
		$modelsName = 'tecnicos';
		$attributes = array('id','nombre', 'nick');
		$attributeNames = array('Id','Nombre', 'Nick');

		$buscarpor = array('id' => 'Cedula', 'nombre' => 'Nombre', 'nick' => 'Nick');
		$tableName = 'tab_tecnico';

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
		$model = null;
		if(is_numeric($id)){
			$model = Tecnico::find($id);
		}
		if (is_null ($model)){
			App::abort(404);
		}

		$form_data = array('route' => array('admin.tecnicos.update', $model->id), 'method' => 'PATCH');
        $actionName = 'Editar';  
        $action = 'edit';
        $estadoid  = 'disabled';
        $modelsName  = 'tecnicos';
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
		$tecnico = null;
		if(is_numeric($id)){
			// Creamos un nuevo objeto para nuestro nuevo usuario
        	$tecnico = Tecnico::find($id);
        }
        
        // Si el usuario no existe entonces lanzamos un error 404 :(
        if (is_null ($tecnico))
        {
            App::abort(404);
        }
        
        // Obtenemos la data enviada por el usuario
        $data = Input::all();
        $tecnico->nombre = $data['nombre'];
        $tecnico->nick = $data['nick'];
        $tecnico->save();
    	return Redirect::route('admin.tecnicos.index');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$tecnico = Tecnico::find($id);
        
        if (is_null ($tecnico))
        {
            App::abort(404);
        }
        
        $tecnico->delete();

        if (Request::ajax())
        {
            return Response::json(array (
                'success' => true,
                'msg'     => 'Tecnico ' . $tecnico->nombre . ' eliminado',
                'id'      => $tecnico->id
            ));
        }
        else
        {
            return Redirect::route('admin.tecnicos.index');
        }
	}

}