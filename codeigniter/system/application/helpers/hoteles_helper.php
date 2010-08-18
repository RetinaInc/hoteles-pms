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


function getRRCount($hotel, $field1, $value1, $field2, $value2)
{
	$CI =& get_instance();

	$CI->load->model('rooms_model');
	
	$result = $CI->rooms_model->getRRCount($hotel, $field1, $value1, $field2, $value2);
		
	return $result;
}


function getInfo($hotel, $table, $field, $value, $order, $lim1, $lim2, $disable)
{
	$CI =& get_instance();

	$CI->load->model('general_model');
	
	$result = $CI->general_model->getInfo($hotel, $table, $field, $value, $order, $lim1, $lim2, $disable);
		
	return $result;
}

