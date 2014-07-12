<?php
    class Fechas
    {
    	public static function isValidDateTime($dateTime)
		{
	    if (trim($dateTime) == '') {
        	return true;
	    }
	    if (preg_match('/^(\d{1,2})\/(\d{1,2})\/(\d{2,4})(\s+(([01]?[0-9])|(2[0-3]))(:[0-5][0-9]){0,2}(\s+(am|pm))?)?$/i', $dateTime, $matches)) {
	        list($all,$mm,$dd,$year) = $matches;
	        if ($year <= 99) {
	            $year += 2000;
	        }
	        return checkdate($mm, $dd, $year);
	    }
	    return false;
		}
    }