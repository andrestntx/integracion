<?php 

class Estadisticas{

	public static function ejecuciones($fechaInicio, $fechaFinal){
		return DB::table('view_ejecuciones_sypelc')
			->where('fecha', '>', $fechaInicio)
				->where('fecha', '<', $fechaFinal)
						->orderBy('fecha', 'desc');
	}

	public static function ejecucionesRevision($fechaInicio, $fechaFinal){
		return DB::table('view_ejecuciones_sypelc')
			->where('fecha', '>', $fechaInicio)
				->where('fecha', '<', $fechaFinal)
					->where('nombre', '=', 'REVISION')	
						->orderBy('fecha', 'desc');
	}

	public static function ejecucionesSolicitud($fechaInicio, $fechaFinal){
		return DB::table('view_ejecuciones_sypelc')
			->where('fecha', '>', $fechaInicio)
				->where('fecha', '<', $fechaFinal)
					->where('nombre', '=', 'SOLICITUD')	
						->orderBy('fecha', 'desc');
	}
	
}