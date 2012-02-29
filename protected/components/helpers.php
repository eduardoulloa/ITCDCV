<?php
	
	function getEmailAddress($matricula) 
	{
		$address = "";
		if(strlen($matricula) == 6){
			$address .= 'A00'.$matricula.'@itesm.mx';
		} else if (strlen($mat) == 7){
			$address .= 'A0'.$matricula.'@itesm.mx';
		}
		return $address;
	}