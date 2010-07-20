<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * hoteles_helper
 *
 */	


/*
 * get_	count
 *
 * Returns how many rooms are in a reservation 
 *
 * @access	public
 * @return	string
 */	


function getCount($table, $field1, $value1, $field2, $value2, $disable)
{
	$CI =& get_instance();

	$CI->load->model('general_model');
	
	$result = $CI->general_model->getCount($table, $field1, $value1, $field2, $value2, $disable);
		
	return $result;
}


