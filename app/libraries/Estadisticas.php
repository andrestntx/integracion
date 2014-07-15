<?php 

class Estadisticas{

	public static function ejecuciones($fechaInicio, $fechaFinal, $itemsPorPagina){
		return DB::table('view_ejecuciones_sypelc')
			->where('fecha', '>', $fechaInicio)
				->where('fecha', '<', $fechaFinal)
						->orderBy('fecha', 'desc')
							->paginate($itemsPorPagina);
	}

	public static function ejecucionesRevision($fechaInicio, $fechaFinal, $itemsPorPagina){
		return DB::table('view_ejecuciones_sypelc')
			->where('fecha', '>', $fechaInicio)
				->where('fecha', '<', $fechaFinal)
					->where('nombre', '=', 'REVISION')	
						->orderBy('fecha', 'desc')
							->paginate($itemsPorPagina);
	}

	public static function ejecucionesSolicitud($fechaInicio, $fechaFinal, $itemsPorPagina){
		return DB::table('view_ejecuciones_sypelc')
			->where('fecha', '>', $fechaInicio)
				->where('fecha', '<', $fechaFinal)
					->where('nombre', '=', 'SOLICITUD')	
						->orderBy('fecha', 'desc')
							->paginate($itemsPorPagina);
	}
	
}