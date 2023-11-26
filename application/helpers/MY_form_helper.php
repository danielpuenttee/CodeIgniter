<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('form_dropdown_num_records')) {
	function form_dropdown_num_records($name = '', $value = '', $id_form = '') {
		$options = array('1' => '1', '2' => '2', '5' => '5', '10' => '10', '25' => '25', '50' => '50', '100' => '100');
		if (!array_key_exists($value, $options) || empty($value)) {
			$value = '5';
		}
		$onchange = ($id_form !== '') ? "document.getElementById('$id_form').submit();" : '';
		return form_dropdown($name, $options, $value, "onchange=\"$onchange\"");
	}
}
