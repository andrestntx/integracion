<?php 

class ImportFile{

	public static function fire($file, $tipo, $delimitador, $atributos = null){
        $tipoArchivo = Archivo::find($tipo);
        if($file){ 
            if($ubicacion = ImportFile::upload($file)){ // Sube el archivo al servidor
                ini_set('auto_detect_line_endings', true);
                if (is_file($ubicacion) AND is_readable($ubicacion)) {
                    if (($handle = fopen($ubicacion, "r")) !== false) {
                        $id = $tipoArchivo->id.str_random(8);
                        $importacion = Importacion::crear($id, $tipoArchivo->id);
                        $contador = 0;
                        $descartadas = 0;
                        $nosypelc = 0;
                        $respuesta = null;

                        $datosnovalidos = array();
                        $motivosDescarte = MotivoDescarte::lists('nombre', 'id');

                        $posiciones = ViewVariablesImportacion::where('archivo_id', '=', $tipoArchivo->id)->lists('posicion_csv', 'nombre');
                        
                        while (($line = fgetcsv($handle, null, $delimitador, "'", '"')) !== false ) {
                            $contador++;
                            if($contador > 2 && $contador <= 10){
                                if(count($line)<$tipoArchivo->lineamenor || count($line)>$tipoArchivo->lineamayor){
                                    return array('error' => true, 'mensaje' => 'El Archivo no contiene el numero de lineas correcto. Este contiene '.count($line).' y debería estar entre '.$tipoArchivo->lineamenor. ' y '.$tipoArchivo->lineamayor);
                                }
                            }

                            $line = Conversions::array_to_utf8($line);
                            $motivo = Validations::fileType($tipoArchivo, $line, $posiciones);
                            if($motivo == 0){
                                $respuesta = ImportFile::selectFileType($id, $line, $tipoArchivo->id, $posiciones, $atributos);
                                //Queue::push('MyQueue@'.$tipoArchivo->funcion_importar, array('resultado' => $id, 'line' => $line, 'atributos' => $atributos, 'estados' => $estados, 'entidades' => $entidades, 'posiciones' => $posiciones, 'contador' => $contador));
                                if($respuesta){
                                    array_push($line, $respuesta);
                                    array_push($datosnovalidos, $line);  
                                }
                            }
                            else if($motivo != 100){
                                $descartadas ++;
                                array_push($line, $motivosDescarte[$motivo]);
                                array_push($datosnovalidos, $line);
                            }
                            else{
                                $nosypelc++;
                            }
                        }
                        $resultado = Importacion::find($id);
                        $resultado->total = $contador;
                        $resultado->descartadas = $resultado->descartadas + $descartadas;
                        $resultado->no_sypelc = $resultado->no_sypelc + $nosypelc;
                        $resultado->save();
                        SimpleCsv::export($datosnovalidos);    
                    }
                }
            }
        }
       return array('error' => false, 'mensaje' => 'Archivo subido exitosamente', 'id' => $id);
    }
	public static function upload($file){
        $destinationPath ='/var/www/campanas/public/uploads';
        $filename = str_random(8).''.$file->getClientOriginalName();
        $uploadSuccess = Input::file('archivo')->move($destinationPath, $filename);
        if( $uploadSuccess ){
            return $ubicacion = $destinationPath.'/'.$filename;
        }
        else {
            return null;
      	}
    }
	public static function programacionSolicitudes($resultado, $line, $posiciones, $atributos){
		$orden = $line[$posiciones['consecutivo']].$line[$posiciones['dependencia_id']].$line[$posiciones['orden_numero']];
    	$datos = DB::select(DB::raw("select * from fun_import_archivo_programacion_solicitudes('".$resultado."',".$orden.",'".$line[$posiciones['tecnico_nick']]."','".$atributos['fecha']."')"));	
        if($datos[0]->error){
        	return $datos[0]->mensaje;	
        }
	}
	public static function devoluciones($resultado, $line, $posiciones, $atributos){		

		if(strtolower($line[$posiciones['devolucion_corregidoSN']]) == 'si'){
			$line[$posiciones['devolucion_corregidoSN']] = 'S';
		}
		else if(strtolower($line[$posiciones['devolucion_corregidoSN']]) == 'no'){
			$line[$posiciones['devolucion_corregidoSN']] = 'N';
		}

		if(strtolower($line[$posiciones['orden_tipo']]) == 'pqr'){
			$tipo_orden = 2;
		}
		else {
			$tipo_orden = 1;
		}

		if(Validations::date($line[$posiciones['fechaCorreccion']])){
			$datos = DB::select(DB::raw("select * from fun_import_archivo_devoluciones('".$resultado."',".$line[$posiciones['orden_numero']].",".$tipo_orden.",'".$line[$posiciones['fechaDevolucion']]."','".$line[$posiciones['fechaCorreccion']]."','".$line[$posiciones['devolucion_motivo']]."','".$line[$posiciones['devolucion_corregidoSN']]."')"));	
		}
		else{
			$datos = DB::select(DB::raw("select * from fun_import_archivo_devoluciones('".$resultado."',".$line[$posiciones['orden_numero']].",".$tipo_orden.",'".$line[$posiciones['fechaDevolucion']]."',null,'".$line[$posiciones['devolucion_motivo']]."','".$line[$posiciones['devolucion_corregidoSN']]."')"));	
		}
        if($datos[0]->error){
        	return $datos[0]->mensaje;	
        }
	}
	public static function programacionRevisiones($resultado, $line, $posiciones, $atributos){
		$datos = DB::select(DB::raw("select * from fun_import_archivo_programacion_revisiones('".$resultado."',".$line[$posiciones['orden_numero']].",'".$line[$posiciones['tecnico_nick']]."','".$atributos['fecha']."')"));	
        if($datos[0]->error){
        	return $datos[0]->mensaje;	
        }
	}
	public static function sistemas($resultado, $line, $posiciones, $atributos){
		$datos = DB::select(DB::raw("select * from fun_import_archivo_sistemas('".$resultado."',".$line[$posiciones['orden_numero']].",'".$atributos['fecha']."')"));	
        if($datos[0]->error){
        	return $datos[0]->mensaje;	
        }
	}
	public static function factura($resultado, $line, $posiciones, $atributos){
		
		if(is_numeric($line[$posiciones['orden_numero']]) && $line[$posiciones['orden_numero']] > 0){
			$orden_id = $line[$posiciones['orden_numero']]; 
		}
		else{
			$orden_id = -1 * $line[$posiciones['orden_acta']]; 
		}

		$aforo=0;
		if(is_numeric($line[$posiciones['aforo']])){
			$aforo = $line[$posiciones['aforo']];
		}

		$municipio_nombre = ucwords(strtolower($line[$posiciones['municipio_nombre']]));
		if(!is_numeric($line[$posiciones['medidorInstalado_lectura']])){
 			$line[$posiciones['medidorInstalado_lectura']] = 'null';
 		}
 		
 		if(!is_numeric($line[$posiciones['medidorEncontrado_lectura']])){
 			$line[$posiciones['medidorEncontrado_lectura']] = 'null';
 		}

 		if(!is_numeric($line[$posiciones['orden_consecutivo']])){
 			$line[$posiciones['orden_consecutivo']] = -1;
 		}
		
		$valores = array(-1);				
		for($irr=$posiciones['itemPago_primer']; $irr<=$posiciones['itemPago_ultimo']; $irr++){
			if($line[$irr] && is_numeric($line[$irr])){
				array_push($valores, $line[$irr]);
			}
		}
		$valorestexto = implode(",", $valores);

		$irregularidades = array(-1);
		for($irr=$posiciones['irregularidad_primer']; $irr<=$posiciones['irregularidad_ultimo']; $irr++){
			if($line[$irr] && is_numeric($line[$irr]) && $line[$irr]<200){
				array_push($irregularidades, $line[$irr]);
			}
		}
		$irregularidadestexto = implode(",", $irregularidades);

		$datos = DB::select( DB::raw("select * from fun_import_archivo_factura('".$resultado."','".$municipio_nombre."','".$line[$posiciones['cliente_ubicacionUR']]."',".$orden_id.",'".$line[$posiciones['orden_consecutivo']]."','".$line[$posiciones['fechaRealizacion']]."','".$line[$posiciones['orden_acta']]."','".$line[$posiciones['fechaEntregaOficio']]."','".$line[$posiciones['medidorEncontrado_serie']]."','".$line[$posiciones['medidorEncontrado_marca']]."',".round($line[$posiciones['medidorEncontrado_lectura']]).",'".$line[$posiciones['medidorInstalado_serie']]."','".$line[$posiciones['medidorInstalado_marca']]."',".round($line[$posiciones['medidorInstalado_lectura']]).",'".$line[$posiciones['tecnico_nombre']]."',".$aforo.",'".$line[$posiciones['orden_estadoFV']]."','{".$valorestexto."}','{".$irregularidadestexto."}')"));		
		if($datos[0]->error){
        	return $datos[0]->mensaje;	
        }
	}
	public static function revisiones($resultado, $line, $posiciones, $atributos){
		$fechaGeneracion = Conversions::dateES_to_dateEN($line[$posiciones['fechaGeneracion']]);
		$municipio_nombre = ucwords(strtolower($line[$posiciones['municipio_nombre']]));
		$estado_accion = strtolower($line[$posiciones['estadoAccion']]);

		$medidor = explode(' ', $line[$posiciones['medidor']]);
 		if(strtolower($medidor[1]) == 'contador' || !$medidor[1] || $medidor[1] == '' || $medidor[1] == ' '){
            $medidor[1] = -1 * $line[$posiciones['cliente_cuenta']];  
        }
  
 		if(Validations::date($line[$posiciones['fechaRealizacion']], 'd/m/Y H:i') || Validations::date($line[$posiciones['fechaRealizacion']])){
	 		if(Validations::date($line[$posiciones['fechaGrabacion']], 'd/m/Y H:i') || Validations::date($line[$posiciones['fechaGrabacion']])){
				$datos = DB::select( DB::raw("select * from fun_import_archivo_revisiones('".$resultado."',".$line[$posiciones['cliente_cuenta']].",'".$municipio_nombre."','".$line[$posiciones['servicio_nombre']]."','".$line[$posiciones['cliente_ubicacion']]."','".$medidor[1]."','".$medidor[0]."',".$line[$posiciones['orden_numero']].",".$line[$posiciones['proyecto_numero']].",'".$fechaGeneracion."','".$estado_accion."','".$line[$posiciones['fechaRealizacion']]."','".$line[$posiciones['orden_acta']])."','".$line[$posiciones['fechaGrabacion']]."')");	
	 		}
	 		else{
	 			$datos = DB::select( DB::raw("select * from fun_import_archivo_revisiones('".$resultado."',".$line[$posiciones['cliente_cuenta']].",'".$municipio_nombre."','".$line[$posiciones['servicio_nombre']]."','".$line[$posiciones['cliente_ubicacion']]."','".$medidor[1]."','".$medidor[0]."',".$line[$posiciones['orden_numero']].",".$line[$posiciones['proyecto_numero']].",'".$fechaGeneracion."','".$estado_accion."','".$line[$posiciones['fechaRealizacion']]."','".$line[$posiciones['orden_acta']])."', null )");	
	 		}
	 	}
	 	else{
			$datos = DB::select( DB::raw("select * from fun_import_archivo_revisiones('".$resultado."',".$line[$posiciones['cliente_cuenta']].",'".$municipio_nombre."','".$line[$posiciones['servicio_nombre']]."','".$line[$posiciones['cliente_ubicacion']]."','".$medidor[1]."','".$medidor[0]."',".$line[$posiciones['orden_numero']].",".$line[$posiciones['proyecto_numero']].",'".$fechaGeneracion."','".$estado_accion."', null,'".$line[$posiciones['orden_acta']])."', null)");	
	 	}

 		if($datos[0]->error){
        	return $datos[0]->mensaje;	
        }
	}
	public static function solicitudes($resultado, $line, $posiciones, $atributos){
        $orden_id = $line[$posiciones['consecutivo']].$line[$posiciones['dependencia_id']].$line[$posiciones['solicitud_numero']];	
		if(Validations::date($line[$posiciones['fechaRealizacion']], 'y-m-d')){
			$fechaEjecucion = $line[$posiciones['fechaRealizacion']];
		}
		else{
			$fechaEjecucion = $line[$posiciones['fechaAsignacion']];
		}

		$line[$posiciones['servicio_nombre']] = strtolower($line[$posiciones['servicio_nombre']]);

 		if(!is_numeric($line[$posiciones['cargaContratada']])){
 			$line[$posiciones['cargaContratada']] = 'null';
 		}
 		if(!is_numeric($line[$posiciones['cargaInstalada']])){
 			$line[$posiciones['cargaInstalada']] = 'null';
 		}
 		if(!is_numeric($line[$posiciones['cliente_ciclo']])){
 			$line[$posiciones['cliente_ciclo']] = 'null';
 		}
 		if(!is_numeric($line[$posiciones['municipio_id']])){
 			$line[$posiciones['municipio_id']] = 0;
 		}
 		if(!is_numeric($line[$posiciones['cliente_ruta']])){
 			$line[$posiciones['cliente_ruta']] = 'null';
 		}
 		if(!is_numeric($line[$posiciones['factorMultiplicacion']])){
 			$line[$posiciones['factorMultiplicacion']] = 'null';
 		}

 		if(!is_numeric($line[$posiciones['cliente_cuenta']])){
 			$line[$posiciones['cliente_cuenta']] = -1 * $orden_id;
 		}

 		if(strtolower($line[$posiciones['medidor_serie']]) == 'contador' || !$line[$posiciones['medidor_serie']] || $line[$posiciones['medidor_serie']] == '' || $line[$posiciones['medidor_serie']] == ' '){
            if($line[$posiciones['cliente_cuenta']] > 0){
            	$line[$posiciones['medidor_serie']] = -1 * $line[$posiciones['cliente_cuenta']];  
            }
            else{
            	$line[$posiciones['medidor_serie']] = $line[$posiciones['cliente_cuenta']]; 	
            }
        }

        $fechaEntrega = Conversions::dateES_to_dateEN($line[$posiciones['fechaEntrega']]);
        if(!Validations::date($fechaEntrega, 'd-m-y')){
        	$datos = DB::select( DB::raw("select * from fun_import_archivo_solicitudes('".$resultado."',".$line[$posiciones['cliente_cuenta']].",".$line[$posiciones['municipio_id']].",'".$line[$posiciones['servicio_nombre']]."','".$line[$posiciones['cliente_ubicacion']]."','".$line[$posiciones['cliente_nombre']]."','".$line[$posiciones['cliente_direccion']]."',".$line[$posiciones['cliente_ciclo']].",".$line[$posiciones['cliente_ruta']].",'".$line[$posiciones['cliente_nodo']]."','".$line[$posiciones['medidor_serie']]."','".$line[$posiciones['medidor_marca']]."','".$line[$posiciones['medidor_tipo']]."',".$line[$posiciones['factorMultiplicacion']].",'".$line[$posiciones['tipoEnergia']]."',".$line[$posiciones['cargaContratada']].",".$line[$posiciones['cargaInstalada']].",".$orden_id.",'".$line[$posiciones['fechaAsignacion']]."',".$line[$posiciones['solicitud_numero']].",".$line[$posiciones['consecutivo']].",".$line[$posiciones['dependencia_id']].",".$line[$posiciones['tipoAccion']].",".$line[$posiciones['tipoSolicitud']].",'".$line[$posiciones['direccionCuenta']]."','".$line[$posiciones['observacion']]."','".$line[$posiciones['estadoAccion']]."','".$fechaEjecucion."','".$line[$posiciones['orden_acta']])."', null)");	
 		}
 		else{
 			$datos = DB::select( DB::raw("select * from fun_import_archivo_solicitudes('".$resultado."',".$line[$posiciones['cliente_cuenta']].",".$line[$posiciones['municipio_id']].",'".$line[$posiciones['servicio_nombre']]."','".$line[$posiciones['cliente_ubicacion']]."','".$line[$posiciones['cliente_nombre']]."','".$line[$posiciones['cliente_direccion']]."',".$line[$posiciones['cliente_ciclo']].",".$line[$posiciones['cliente_ruta']].",'".$line[$posiciones['cliente_nodo']]."','".$line[$posiciones['medidor_serie']]."','".$line[$posiciones['medidor_marca']]."','".$line[$posiciones['medidor_tipo']]."',".$line[$posiciones['factorMultiplicacion']].",'".$line[$posiciones['tipoEnergia']]."',".$line[$posiciones['cargaContratada']].",".$line[$posiciones['cargaInstalada']].",".$orden_id.",'".$line[$posiciones['fechaAsignacion']]."',".$line[$posiciones['solicitud_numero']].",".$line[$posiciones['consecutivo']].",".$line[$posiciones['dependencia_id']].",".$line[$posiciones['tipoAccion']].",".$line[$posiciones['tipoSolicitud']].",'".$line[$posiciones['direccionCuenta']]."','".$line[$posiciones['observacion']]."','".$line[$posiciones['estadoAccion']]."','".$fechaEjecucion."','".$line[$posiciones['orden_acta']])."','".$fechaEntrega."')");	
 		}

 		if($datos[0]->error){
        	return $datos[0]->mensaje;	
        }
	}
	public static function consumos($resultado, $line, $posiciones, $atributos){
		$fecha_actual = Conversions::dateES_to_dateEN($line[$posiciones['fecha_lectura_final']]);
		$fecha_anterior = Conversions::dateES_to_dateEN($line[$posiciones['fecha_lectura_inicial']]);

		if(!is_numeric($line[$posiciones['lectura_inicial']])){
            $line[$posiciones['lectura_inicial']] = 0;
        }

		$ajuste = 0;
        if(!is_numeric($line[$posiciones['lectura_final']])){
        	if(is_numeric($line[$posiciones['consumo']])){
            	$ajuste = $line[$posiciones['consumo']];
            }
            $line[$posiciones['lectura_final']] = $line[$posiciones['lectura_inicial']];
        }

		if(Validations::date($fecha_actual, 'd-m-y') && Validations::date($fecha_anterior, 'd-m-y')){
			$datos = DB::select( DB::raw("select * from fun_import_archivo_consumos('".$resultado."','".$line[$posiciones['medidor_serie']]."','".$line[$posiciones['medidor_marca']]."','".$line[$posiciones['tipoEnergia']]."','".$fecha_actual."','".$fecha_anterior."',".round($line[$posiciones['lectura_final']]).",".round($line[$posiciones['lectura_inicial']]).",".$ajuste.",".$line[$posiciones['observacion_lectura']].",".$line[$posiciones['cliente_cuenta']].")" ));	
		}

		else if(Validations::date($fecha_actual, 'd-m-y')){
			$datos = DB::select( DB::raw("select * from fun_import_archivo_consumos('".$resultado."','".$line[$posiciones['medidor_serie']]."','".$line[$posiciones['medidor_marca']]."','".$line[$posiciones['tipoEnergia']]."','".$fecha_actual."',null,".round($line[$posiciones['lectura_final']]).",".round($line[$posiciones['lectura_inicial']]).",".$ajuste.",".$line[$posiciones['observacion_lectura']].",".$line[$posiciones['cliente_cuenta']].")"));	
		}
		else if(Validations::date($fecha_anterior, 'd-m-y')){
			$datos = DB::select( DB::raw("select * from fun_import_archivo_consumos('".$resultado."','".$line[$posiciones['medidor_serie']]."','".$line[$posiciones['medidor_marca']]."','".$line[$posiciones['tipoEnergia']]."',null,'".$fecha_anterior."',".round($line[$posiciones['lectura_final']]).",".round($line[$posiciones['lectura_inicial']]).",".$ajuste.",".$line[$posiciones['observacion_lectura']].",".$line[$posiciones['cliente_cuenta']].")"));	
		}
		else{
			return 'Ambas fchas incorrectas';
		}
		if($datos[0]->error){
        	return $datos[0]->mensaje;	
        }
	}
	public static function selectFileType($id, $line, $tipoArchivo_id, $posiciones, $atributos){
        switch ($tipoArchivo_id) {
            case 'cons':
                $respuesta = ImportFile::consumos($id, $line, $posiciones, $atributos);                                        
                break;
            case 'dev':
                $respuesta = ImportFile::devoluciones($id, $line, $posiciones, $atributos); 
                break;
            case 'fact':
                $respuesta = ImportFile::factura($id, $line, $posiciones, $atributos);                                         
            break;
            case 'prog':
                $respuesta = ImportFile::programacionRevisiones($id, $line, $posiciones, $atributos); 
                break;
            case 'progs':
               $respuesta = ImportFile::programacionSolicitudes($id, $line, $posiciones, $atributos);  
                break;
            case 'rev':
                $respuesta = ImportFile::revisiones($id, $line, $posiciones, $atributos); 
            break;
            case 'sist':
                $respuesta = ImportFile::sistemas($id, $line, $posiciones, $atributos); 
                break;
            case 'sol':
                $respuesta = ImportFile::solicitudes($id, $line, $posiciones, $atributos); 
                break;
            default:
            	$respuesta = null;
            break;
        }
		return $respuesta;
	}
}