<?php 

class General_model extends Model
{
	function General_model()
	{
		parent::Model();
	}
	
	function getInfo($table, $field, $value, $order, $lim1, $lim2, $disable)
	{
		if ($field != null and $value != null) {
		
  			$this->db->where($field, $value);
  		}
		
		if ($order != null) {
		
  			$this->db->order_by($order);
  		}
		
		if ($disable != null) {
		
			$this->db->where($table.'.'.'disable', 1); 
		}
		
		if ($table == 'ROOM') {
		
			$this->db->select('ROOM.*');
			$this->db->select('ROOM_TYPE.abrv as rtabrv');
			$this->db->select('ROOM_TYPE.description as rtdescrption');
			$this->db->join('ROOM_TYPE', 'ROOM_TYPE.id_room_type = ROOM.fk_room_type','left');
		}
		
		if ($table == 'RESERVATION') {
		
			$this->db->select('RESERVATION.*');
			$this->db->select('GUEST.name as gname');
			$this->db->select('GUEST.lastName as gLname');
			$this->db->join('GUEST', 'GUEST.id_guest = RESERVATION.fk_guest','left');
		}
		
		$query = $this->db->get($table, $lim1, $lim2);
		return $query->result_array();
	}
	
	
	function getCount($table, $field1, $value1, $field2, $value2, $disable)
	{
		if ($field1 != null and $value1 != null) {
		
  			$this->db->where($field1, $value1);
  		}
		
		if ($field2 != null and $value2 != null) {
		
  			$this->db->where($field2, $value2);
  		}
		
		if ($disable != null) {
		
			$this->db->where($table.'.'.'disable', 1); 
		}
		
		$this->db->from($table);
		$query = $this->db->count_all_results();
		return $query;
	}
	
	
	function getMax($table, $field)
	{
		$this->db->select_max($field);
		$this->db->where('disable', 1); 
		$query = $this->db->get($table);
		return $query->result_array();
	}
	
	
	function validationCheck($table, $field1, $value1, $field2, $value2)
	{
		if ($field1 != null and $value1 != null) {
		
  			$this->db->where($field1, $value1);
  		}
		
		if ($field2 != null and $value2 != null) {
		
  			$this->db->where($field2, $value2);
  		}
		
		$this->db->where('disable', 1); 
		$query = $this->db->get($table);
		return $query->result_array();
	}
	
	
	function insert($table, $data)
	{
		$this->db->insert($table, $data);
	}
	
	
	function update($table, $field, $value, $data)
	{
		$this->db->where($field, $value);
		$this->db->update($table, $data);
	}
	
	
	function disable($table, $field, $value)
	{
		$this->db->set('disable', 0); 
		$this->db->where($field, $value); 
		$this->db->update($table); 
	}
	
	
}
?>