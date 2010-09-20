<?php 

class Seasons_model extends Model
{
	function Seasons_model()
	{
		parent::Model();
	}
	
	
	function getSeason($date)
	{	
		$this->db->where('dateStart <=', $date);
		$this->db->where('dateEnd >', $date);
		
		$query = $this->db->get('SEASON'); 
		return $query->result_array();
	}
	
	
	
	
}
?>