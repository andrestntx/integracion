<?php

class Admin_ImportController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function getIndex()
	{
		$importsypelc = array('fact' => 'Conslidado Factura', 'dev' => 'Devoluciones', 'prog' => 'Programación Campañas', 'progs' => 'Programación Solicitudes', 'sist' => 'Sistemas');
		$importemsa = array('rev' => 'Revisiones', 'sol' => 'Solicitudes', 'cons' => 'Consumos');
		$delimitador = array(';' => 'punto y coma ;', '|' => 'palito |');
		return View::make('admin/import/form', compact('importemsa', 'importsypelc', 'delimitador'));
	}

	public function __construct() {
   		$this->beforeFilter('csrf', array('on'=>'post'));
   		$this->beforeFilter('auth', array('only' => array('postFactura', 'postSolicitudes', 'getIndex', 'postProgramacion', 'postDevoluciones')));
	}

	public function getConsulta(){
		return View::make('admin/import/respuesta');
	}

	public function postArchivo(){
		$file = Input::file('archivo');
		$delimitador = Input::get('delimitador');
		if(Input::get('tipo') == 'prog' || Input::get('tipo') == 'sist' || Input::get('tipo') == 'progs'){
			$date = explode('.',$file->getClientOriginalName());
			$fechareal= Conversions::word_to_date($date[0]);
			if(Validations::date($fechareal)){
				$respuesta = ImportFile::fire($file, Input::get('tipo'), $delimitador, array('fecha' => $fechareal, 'tipo_archivo' => Input::get('tipo')));
			}
			else{
				$respuesta = array('error' => false, 'mensaje' => 'Fecha Incorrecta', 'id' => '0');
			}
		}
		else{
			$respuesta = ImportFile::fire($file, Input::get('tipo'), $delimitador);
		}
		
		return View::make('admin/import/respuesta', compact('respuesta'));	
	}



}