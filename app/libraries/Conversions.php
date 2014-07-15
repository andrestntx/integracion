<?php 

class Conversions{

	static $monthnumbersES = array('ENE' => 1, 'FEB' => 2, 'MAR' => 3, 'ABR' => 4, 'MAY' => 5, 
            'JUN' => 6, 'JUL' => 7, 'AGO' => 8, 'SEP' => 9, 'OCT' => 10, 'NOV' => 11, 'DIC' => 12);

	public static function to_pg_array($set) { 
		settype($set, 'array'); // can be called with a scalar or array 
		$result = array(); 
		foreach ($set as $t) { 
			if (is_array($t)) { 
				$result[] = MyQueue::to_pg_array($t); 
			} 
			else { 
				$t = str_replace('"', '\\"', $t); // escape double quote 
				if (! is_numeric($t)) // quote only non-numeric values 
				$t = '"' . $t . '"'; $result[] = $t; } 
		}
		return '{' . implode(",", $result) . '}'; // format 
	}
	public static function remove_key_from_array($array){
		$result = array();
		if(is_object($array)){
			$array = get_object_vars($array);
		}
		foreach ($array as $value) {
			if(is_array($value) || is_object($value)){
				$result[] = Conversions::remove_key_from_array($value); 	
			}
			else{
				array_push($result, $value);
			}
		}
		return $result;	
	}
	public static function dateES_to_dateEN($dateES, $delimiter ='-'){
        $date = explode($delimiter, $dateES);
        if(sizeof($date) >= 2){
            return date('d-m-y', strtotime($date[2].'-'.self::$monthnumbersES[strtoupper($date[1])].'-'.$date[0]));
        }
        else{
            return null;
        }
    }
    public static function removeAccents($word){

       return  utf8_decode(str_replace('Ñ', 'N',strtr(utf8_decode($word), 'aeiouÁÉÍÓÚ', 'aeiouAEIOU')));
    }
    public static function word_to_date($word, $delimiter ='-'){ 
        $part_of_date = explode($delimiter, $word);
        return $part_of_date[0].'/'.$part_of_date[1].'/'.$part_of_date[2];
    }
    public static function array_to_utf8($array){
    	$words = count($array);
    	for($i=0 ; $i<$words; $i++){
        	$array[$i] = utf8_decode(str_replace('Ñ','N',utf8_encode(str_replace('Ñ', 'N', $array[$i]))));
        	$array[$i] = trim(htmlentities($array[$i], ENT_QUOTES | ENT_IGNORE, "UTF-8"));
    	}
    	return $array;
    }
}