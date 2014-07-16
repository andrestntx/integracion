<?php

class Validations{
	public static function date($date, $format = "d/m/Y"){
		$d = DateTime::createFromFormat($format, $date);
		return $d && $d->format($format) == $date;
	}

	public static function fileType($fileType, $line, $posiciones){
        $motivo = 7;
        if(count($line)>=$fileType->lineamenor && count($line)<=$fileType->lineamayor){
            $motivo = 0;
            switch ($fileType->funcion_importar) {
                case 'solicitudes':
                    $orden_id = $line[$posiciones['dependencia_id']].$line[$posiciones['solicitud_numero']].$line[$posiciones['consecutivo']];
                    if(!is_numeric($orden_id)){
                        $motivo = 1;
                    }
                    else if(!Validations::date($line[$posiciones['fechaAsignacion']], 'm-d-y') && !Validations::date($line[$posiciones['fechaAsignacion']], 'm-d-Y') && !Validations::date($line[$posiciones['fechaAsignacion']], 'Y-m-d') && !Validations::date($line[$posiciones['fechaAsignacion']])){
                        $motivo = 3;    
                    }
                    break;
                case 'revisiones':
                    if(!is_numeric($line[$posiciones['cliente_cuenta']])){
                        $motivo = 2;       
                    } 
                    else if (!is_numeric($line[$posiciones['proyecto_numero']])){
                        $motivo = 8;    
                    }
                    else if ($line[$posiciones['revisor_nombre']]!='SYPELC'){
                        $motivo = 100;
                    } 
                    else if (!is_numeric($line[$posiciones['orden_numero']])){
                        $motivo = 1;
                    }
                    break;
                case 'factura':
                    if((!is_numeric($line[$posiciones['orden_numero']]) || $line[$posiciones['orden_numero']] <= 0) && !is_numeric($line[$posiciones['orden_acta']])){
                        $motivo = 1;
                    }
                    else if(!Validations::date($line[$posiciones['fechaRealizacion']])){
                        $motivo = 4;    
                    }
                    else if(!Validations::date($line[$posiciones['fechaEntregaOficio']])){
                        $motivo = 5;
                    }
                break;
                case 'devoluciones':
                    if(!is_numeric($line[$posiciones['orden_numero']])){
                        $motivo = 1;
                    }
                    else if(!Validations::date($line[$posiciones['fechaDevolucion']])) {
                        $motivo = 6;
                    }            
                break;
                case 'estados':
                    if(!is_numeric($line[$posiciones['orden_numero']])){
                        $motivo = 1;   
                    }
                    break;
                case 'consumos':
                    if(!Validations::date(Conversions::dateES_to_dateEN($line[$posiciones['fecha_lectura_final']]), 'd-m-y') && !Validations::date(Conversions::dateES_to_dateEN($line[$posiciones['fecha_lectura_inicial']]), 'd-m-y')){
                        $motivo = 13;
                    }
                    else if(!is_numeric($line[$posiciones['lectura_inicial']]) && !is_numeric($line[$posiciones['lectura_final']])){
                        $motivo = 14;
                    }
                break;
                case 'programacionsol':
                    if(!is_numeric($line[$posiciones['orden_numero']])){
                        $motivo = 1;   
                    }
                    else if(!is_numeric($line[$posiciones['consecutivo']])){
                        $motivo = 1;   
                    }
                    else if(!is_numeric($line[$posiciones['dependencia_id']])){
                        $motivo = 1;   
                    }
                break;
                default:
                break;
            }
        }
        return $motivo;
    }
}