<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class ImportarConsumos extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'command:ImportarConsumos';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Command description.';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return void
	 */
	public function fire(){
		$atributos = null;
		$tipoArchivo = Archivo::find('cons');
		$id = $tipoArchivo->id.str_random(8);
        $importacion = Importacion::crear($id, $tipoArchivo->id);
	    $contador = 0;
	    $descartadas = 0;
	    $nosypelc = 0;
	    $respuesta = null;

	    $posiciones = ViewVariablesImportacion::where('archivo_id', '=', $tipoArchivo->id)->lists('posicion_csv', 'nombre');
		$datos = DB::connection('oracle')->select(DB::raw("select consecutivo_accion, periodo, cuenta, medidor, con_contador, marca, serie, tipo_energia, fecha_tomada, fecha_anterior, lectura_tomada, lectura_anterior, consumo, tipo_observacion, descripcion from sgd_consumos_orden_pda where fecha_ins >= to_date('01/10/2012') and fecha_ins <= to_date('01/12/2012', 'dd/mm/yyyy')"));

		$datos = Conversions::remove_key_from_array($datos);

		foreach ($datos as $line) {
			$contador++;
		    $line = Conversions::array_to_utf8($line);
            $motivo = Validations::fileType($tipoArchivo, $line, $posiciones);
		    if($motivo == 0){
                $respuesta = ImportFile::selectFileType($id, $line, $tipoArchivo->id, $posiciones, $atributos);
				if($respuesta){
			        $descartadas++;  
			    }
	    	}
		    else if($motivo != 100){
		        $descartadas ++;
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

		//return 'correcto';

		//SimpleCsv::export($datosnovalidos);
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return array(
			array('example', InputArgument::OPTIONAL, 'An example argument.'),
		);
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return array(
			array('example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null),
		);
	}

}