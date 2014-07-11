<?php

class Admin_CampanasController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */

	public function index()
	{
		$models = Campana::paginate(10);
		$modelsName = 'campanas';
		$attributes = array('id','nombre', 'proyecto_id');
        $attributeNames = array('Id','Nombre', 'Proyecto');

        $buscarpor = array('id' => 'Numero', 'nombre' => 'Nombre');
		$tableName = 'tab_campana';
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
        $model = new Campana;
        $form_data = array('route' => 'admin.campanas.store', 'method' => 'POST');
        $estadoid ='';
        $modelsName = 'campanas';	
        $actionName  = 'Crear';
        $action = 'create';
        //$proyectos = Proyecto::all(array('nombre', 'id'));
        $proyectos = Proyecto::all(array('id','nombre'));
        $proyectosSelect = array();
        foreach ($proyectos as $proyecto) {
        	$proyectosSelect[$proyecto->id]=$proyecto->nombre;
        }
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
        $campana = new Campana;
        // Obtenemos la data enviada por el usuario
        $data = Input::all();
        $campana->fill($data);
        $campana->save();
        return Redirect::route('admin.campanas.index');
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
			$model = Campana::find($id);
		}
		if (is_null ($model)){
			App::abort(404);
		}

		$action = 'show';
		$modelsName = 'campanas';
		$attributes = array('id','nombre', 'idProyecto');
        $attributeNames = array('Id','Nombre', 'Proyecto');

        $buscarpor = array('id' => 'Numero');
		$tableName = 'tab_campana';

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
		$model = Campana::find($id);
		if (is_null ($model)){
			App::abort(404);
		}

		$form_data = array('route' => array('admin.campanas.update', $model->id), 'method' => 'PATCH');
        $actionName    = 'Editar';
        $action = 'edit';
        $estadoid  = 'disabled';
        $modelsName = 'campanas';
        $proyectos = Proyecto::all(array('id','nombre'));
        $proyectosSelect = array();
        foreach ($proyectos as $proyecto) {
        	$proyectosSelect[$proyecto->id]=$proyecto->nombre;
        }
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
        $campana = Campana::find($id);
        
        // Si el usuario no existe entonces lanzamos un error 404 :(
        if (is_null ($campana))
        {
            App::abort(404);
        }
        
        // Obtenemos la data enviada por el usuario
        $data = Input::all();
        $campana->nombre = $data['nombre'];
        $campana->idProyecto = $data['idProyecto'];
        $campana->save();
    	return Redirect::route('admin.campanas.index');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$campana = Campana::find($id);
        
        if (is_null ($campana))
        {
            App::abort(404);
        }
        
        $campana->delete();

        if (Request::ajax())
        {
            return Response::json(array (
                'success' => true,
                'msg'     => 'Campana ' . $campana->nombre . ' eliminado',
                'id'      => $campana->id
            ));
        }
        else
        {
            return Redirect::route('admin.campanas.index');
        }
	}

}