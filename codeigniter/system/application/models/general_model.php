<?php 

class General_model extends Model
{
	function General_model()
	{
		parent::Model();
	}
	
	function get_info($table, $field, $value, $order, $lim1, $lim2)
	{
		if ($field != null and $value != null)
		{
  			$this->db->where($field, $value);
  		}
		if ($order != null)
		{
  			$this->db->order_by($order);
  		}
		
		$this->db->where($table.'.'.'DISABLE', 1); 
		
		if ($table == 'ROOM')
		{
			$this->db->select('ROOM.*');
			$this->db->select('ROOM_TYPE.ABRV as RTNAME');
			$this->db->join('ROOM_TYPE', 'ROOM_TYPE.ID_ROOM_TYPE = ROOM.FK_ID_ROOM_TYPE','left');
		}
		
		$query = $this->db->get($table, $lim1, $lim2);
		return $query->result_array();
	}
	
	
	function get_count($table, $field1, $value1, $field2, $value2)
	{
		if ($field1 != null and $value1 != null)
		{
  			$this->db->where($field1, $value1);
  		}
		
		if ($field2 != null and $value2 != null)
		{
  			$this->db->where($field2, $value2);
  		}
		
		$this->db->where('DISABLE', 1); 
		$this->db->from($table);
		$query = $this->db->count_all_results();
		return $query;
	}
	
	
	function get_max($table, $field)
	{
		$this->db->select_max($field);
		$this->db->where('DISABLE', 1); 
		$query = $this->db->get($table);
		return $query->result_array();
	}
	
	
	function validation_check($table, $field1, $value1, $field2, $value2)
	{
		if ($field1 != null and $value1 != null)
		{
  			$this->db->where($field1, $value1);
  		}
		
		if ($field2 != null and $value2 != null)
		{
  			$this->db->where($field2, $value2);
  		}
		
		$this->db->where('DISABLE', 1); 
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
		$this->db->set('DISABLE', 0); 
		$this->db->where($field, $value); 
		$this->db->update($table); 
	}
	
	
}
?>