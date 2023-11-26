<?php

defined('BASEPATH') OR exit('No direct script access allowed');


if (!function_exists('alt_text')) {
	function alt_text($cadena, $alternative = '-') {

		if (empty($cadena) || $cadena === '0000-00-00' || $cadena === '0000-00-00 00:00:00') {
			return $alternative;
		}
		return $cadena;
	}
}

