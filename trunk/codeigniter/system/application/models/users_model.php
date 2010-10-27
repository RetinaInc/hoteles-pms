<?php 

class Users_model extends Model
{
	function Users_model()
	{
		parent::Model();
	}
	
	
	function getConfirmHotelUser($userId, $username, $password)
	{
			
		if ($userId != null)
		{
			$this->db->where('id_user', $userId);
		}
		
		$this->db->where('username', $username);
		$this->db->where('password', $password);
		$this->db->where('disable', 1);
		
		$query = $this->db->get('USER');
		return $query->result_array();
	}
	
	
	function getUserInfo($hotel, $field, $value, $order, $lim1, $lim2, $disable)
	{
		if ($field != null && $value != null) {
		
  			$this->db->where($field, $value);
  		}
		
		if ($order != null) {
		
  			$this->db->order_by($order);
  		}
		
		if ($disable != null) {
		
			$this->db->where('disable', 1); 
		}
		 
		$this->db->where('fk_hotel', $hotel);
	
		$query = $this->db->get('USER', $lim1, $lim2);
		return $query->result_array();
	}
	
	
	function getCheckEmail($username, $userEmail)
	{	
		$this->db->where('username', $username);
		$this->db->where('email', $userEmail);
		$this->db->where('disable', 1);
		
		$query = $this->db->get('USER');
		return $query->result_array();
	}
	
	
	function getTelInfo($field1, $value1, $field2, $value2)
	{		
		if ($field2 != null && $value2 != null) {
		
  			$this->db->where($field2, $value2);
  		}
	
		$this->db->where($field1, $value1);
		$query = $this->db->get('TELEPHONE');
		return $query->result_array();
	}
	
	
}
?>