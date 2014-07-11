<?php

class Admin_ProyectosController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */

	public function index()
	{
		$models = Proyecto::paginate(10);
		$modelsName = 'proyectos';
		$attributes = array('id','nombre');
        $attributeNames = array('Id','Nombre');

        $buscarpor = array('id' => 'Numero', 'nombre' => 'Nombre');
		$tableName = 'tab_proyecto';

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
        $model = new Proyecto;
        $form_data = array('route' => 'admin.proyectos.store', 'method' => 'POST');
        $actionName    = 'Crear';  
        $action = 'create';
        $estadoid ='';
        $modelsName = 'proyectos';
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
        $proyecto = new Proyecto;
        // Obtenemos la data enviada por el usuario
        $data = Input::all();
        $proyecto->fill($data);
        $proyecto->save();
        return Redirect::route('admin.proyectos.index');
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
			$model = Proyecto::find($id);
		}
		if (is_null ($model)){
			App::abort(404);
		}

		$action = 'show';
		$modelsName = 'proyectos';
		$attributes = array('id','nombre');
        $attributeNames = array('Id','Nombre');

        $buscarpor = array('id' => 'Numero', 'nombre' => 'Nombre');
		$tableName = 'tab_proyecto';
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
		$model = Proyecto::find($id);
		if (is_null ($model)){
			App::abort(404);
		}

		$form_data = array('route' => array('admin.proyectos.update', $model->id), 'method' => 'PATCH');
        $actionName    = 'Editar';
        $action = 'edit';
        $estadoid  = 'disabled';
        $modelsName = 'proyectos';
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
        $proyecto = Proyecto::find($id);
        
        // Si el usuario no existe entonces lanzamos un error 404 :(
        if (is_null ($proyecto))
        {
            App::abort(404);
        }
        
        // Obtenemos la data enviada por el usuario
        $data = Input::all();
        $proyecto->nombre = $data['nombre'];
        $proyecto->save();
    	return Redirect::route('admin.proyectos.index');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$proyecto = Proyecto::find($id);
        
        if (is_null ($proyecto))
        {
            App::abort(404);
        }
        
        $proyecto->delete();

        if (Request::ajax())
        {
            return Response::json(array (
                'success' => true,
                'msg'     => 'Proyecto ' . $proyecto->nombre . ' eliminado',
                'id'      => $proyecto->id
            ));
        }
        else
        {
        	return Response::json(array (
                'success' => true,
                'msg'     => 'Proyecto ' . $proyecto->nombre . ' NO eliminado',
                'id'      => $proyecto->id
            ));
            //return Redirect::route('admin.proyectos.index');
        }
	}

	public function import(){
		$models = Proyecto::paginate(8);
		$modelsName = 'proyectos';
		$attributes = array('id','nombre');
        return View::make('admin/layoutlist', compact('models', 'modelsName', 'attributes'));	
	}

}