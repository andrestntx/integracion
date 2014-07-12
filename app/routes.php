<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', function()
{
	return Redirect::to('admin');
});


Route::get('admin/pruebas', function()
{
	var_dump($_ENV);

});

Route::controller('admin/estadisticas', 'Admin_EstadisticasController', array(
	'getIndex' => 'estadisticas',
	'getTecnicos' => 'estadisticas/tecnicos',
	'getPendientes' => 'estadisticas/pendientes',
	'getProyectos' => 'estadisticas/proyectos',
	'getEjecuciones' => 'estadisticas/ejecuciones',
	'getEjecucionespqr' => 'estadisticas/ejecucionespqr',
	'getEjecucionesrev' => 'estadisticas/ejecucionesrev',
	'getFindmodel' => 'estadisticas/findmodel'
));

Route::get('admin/recomendaciones', array('as' => 'recomendaciones', function()
{
	return View::make('admin/recomendaciones');
	
}));

Route::resource('admin/import/resultado', 'Admin_ResultadosimporController');

Route::controller('admin/import', 'Admin_ImportController', array(
	'getIndex' => 'import',
	'getConsulta' => 'import/consulta',
	'postFactura' => 'import/factura',
	'postRevisiones' => 'import/revisiones',
	'postSolicitudes' => 'import/solicitudes',
	'postProgramacion' => 'import/programacion',
	'postDevoluciones' => 'import/devoluciones',
	'postArchivo' => 'import/archivo'
));

//Admin de Modelos
	Route::resource('admin/users', 'Admin_UsersController');
	Route::resource('admin/proyectos', 'Admin_ProyectosController');
	Route::resource('admin/municipios', 'Admin_MunicipiosController');
	Route::resource('admin/tecnicos', 'Admin_TecnicosController');
	Route::resource('admin/campanas', 'Admin_CampanasController');
	Route::resource('admin/revisiones', 'Admin_RevisionesController');
	Route::resource('admin/solicitudes', 'Admin_SolicitudesController');
	Route::resource('admin/clientes', 'Admin_ClientesController');
	Route::resource('admin/medidores', 'Admin_MedidoresController');

// route to general admin
	Route::get('admin', array('before' => 'auth', 'as' => 'admin', function(){
		$ruta = Route::currentRouteName();
		return View::make('admin/inicio', compact('ruta'));
	}));

// route to show the login form
	Route::get('login', array('uses' => 'HomeController@showLogin'));

// route to process the form
	Route::post('login', array('uses' => 'HomeController@doLogin'));

// route to Logout
	Route::get('logout', array('uses' => 'HomeController@doLogout'));

// route to Login 
	Route::filter('auth', function()
	{
	   if (Auth::guest()) return Redirect::guest('login');
	});

// Rout to Queue

	Route::get('queue/add', 'QueueController@add');