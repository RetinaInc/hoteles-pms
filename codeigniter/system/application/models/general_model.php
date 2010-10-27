<?php 

class General_model extends Model
{
	function General_model()
	{
		parent::Model();
	}
	
	
	function getInfo($hotel, $table, $field, $value, $order, $lim1, $lim2, $disable)
	{
		if ($field != null && $value != null) {
		
  			$this->db->where($field, $value);
  		}
		
		if ($order != null) {
		
  			$this->db->order_by($order);
  		}
		
		if ($disable != null) {
		
			$this->db->where($table.'.'.'disable', 1); 
		}
		
		if ($hotel != null) {
		
  			$this->db->where('fk_hotel', $hotel);
  		}
		
		$query = $this->db->get($table, $lim1, $lim2);
		return $query->result_array();
	}
	
	
	function getCount($hotel, $table, $field1, $value1, $field2, $value2, $disable)
	{
		if ($field1 != null && $value1 != null) {
		
  			$this->db->where($field1, $value1);
  		}
		
		if ($field2 != null && $value2 != null) {
		
  			$this->db->where($field2, $value2);
  		}
		
		if ($disable != null) {
		
			$this->db->where($table.'.'.'disable', 1); 
		}
		
		if ($hotel != null) {
		
  			$this->db->where('fk_hotel', $hotel);
  		}
		
		$this->db->from($table);
		$query = $this->db->count_all_results();
		return $query;
	}
	
	
	function getTotalRows($hotel, $table, $field, $value, $disable)
	{
		if ($field != null && $value != null)
		{
  			$this->db->where($field, $value);
  		}
		
		if ($disable != null) {
		
			$this->db->where($table.'.'.'disable', 1); 
		}
		
		$this->db->where('fk_hotel', $hotel);
		$this->db->from($table);
		$query = $this->db->count_all_results();
		return $query;
	}
	
	/*
	function getName($hotel, $table, $field1, $value1, $field2, $value2)
	{
		if ($hotel != null) {
		
  			$this->db->where('fk_hotel', $hotel);
  		}
		
		if ($field2 != null && $value2 != null) {
		
  			$this->db->where($field2, $value2);
  		}
		
		$this->db->where($field1, $value1);
		$this->db->select('name');
		$query = $this->db->get($table);
		return $query->result_array();
	}
	*/
	
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
	
	function delete($table, $field, $value)
	{
		$this->db->where($field, $value);
		$this->db->delete($table); 
	}
	
	
	function validationCheck($hotel, $table, $field1, $value1, $field2, $value2, $disable)
	{
		if ($field1 != null && $value1 != null) {
		
  			$this->db->where($field1, $value1);
  		}
		
		if ($field2 != null && $value2 != null) {
		
  			$this->db->where($field2, $value2);
  		}
		
		if ($disable != null) {
		
			$this->db->where('disable', 1); 
		}
		
		if ($hotel != null) {
		
  			$this->db->where('fk_hotel', $hotel);
  		}
		
		$query = $this->db->get($table);
		return $query->result_array();
	}
	
	
	function doubleUpdate($table, $field1, $value1, $field2, $value2, $data)
	{
		if ($field2 != null && $value2 != null) {
		
  			$this->db->where($field2, $value2);
  		}
		
		$this->db->where($field1, $value1);
		$this->db->update($table, $data);
	}
	
	
	
	
}
?>