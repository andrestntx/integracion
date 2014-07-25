<?php

class Admin_UsersController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */

    public function __construct() {
        $this->beforeFilter('csrf', array('on'=>'post'));
        $this->beforeFilter('auth', array('only'=>
            array('index', 'create', 'store', 'update', 
                'destroy', 'show', 'edit')));
    }

	public function index()
	{
		$users = User::paginate(12);
        return View::make('admin/users/list')->with('users', $users);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
   {
        // Creamos un nuevo objeto User para ser usado por el helper Form::model
        $user = new User;
        $form_data = array('route' => 'admin.users.store', 'method' => 'POST');
        $action    = 'Crear';  
      	return View::make('admin/users/form', compact('user', 'form_data', 'action'));
   }

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
    {
        // Creamos un nuevo objeto para nuestro nuevo usuario
        $user = new User;
        // Obtenemos la data enviada por el usuario
        $data = Input::all();
        
        // Revisamos si la data es válida y guardamos en ese caso
       if ($user->validAndSave($data))
        {
            // Y Devolvemos una redirección a la acción show para mostrar el usuario
            return Redirect::route('admin.users.show', array($user->id));
        }
        else
        {
            // En caso de error regresa a la acción create con los datos y los errores encontrados
			return Redirect::route('admin.users.create')->withInput()->withErrors($user->errors);
        }
    }

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
   {
       $user = User::find($id);
        
        if (is_null($user)) {
            App::abort(404);
        }
        
      return View::make('admin/users/see', array('user' => $user));
   }

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$user = User::find($id);
		if (is_null ($user)){
			App::abort(404);
		}

		$form_data = array('route' => array('admin.users.update', $user->id), 'method' => 'PATCH');
        $action    = 'Editar';
        
        return View::make('admin/users/form', compact('user', 'form_data', 'action'));
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
        $user = User::find($id);
        
        // Si el usuario no existe entonces lanzamos un error 404 :(
        if (is_null ($user))
        {
            App::abort(404);
        }
        
        // Obtenemos la data enviada por el usuario
        $data = Input::all();

        // Revisamos si la data es válida y guardamos en ese caso
        if ($user->validAndSave($data))
        {
            // Y Devolvemos una redirección a la acción show para mostrar el usuario
            return Redirect::route('admin.users.show', array($user->id));
        }
        else
        {
            // En caso de error regresa a la acción create con los datos y los errores encontrados
            return Redirect::route('admin.users.edit', $user->id)->withInput()->withErrors($user->errors);
        }
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
   {
       $user = User::find($id);
        
        if (is_null ($user))
        {
            App::abort(404);
        }
        
        $user->delete();

        if (Request::ajax())
        {
            /*return Response::json(array (
                'success' => true,
                'msg'     => 'Usuario ' . $user->name . ' eliminado',
                'id'      => $user->id
            ));*/
        }
        else
        {
            return Redirect::route('admin.users.index');
        }
    }
}