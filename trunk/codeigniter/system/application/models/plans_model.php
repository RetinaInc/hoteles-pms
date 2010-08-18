<?php 

class Plans_model extends Model
{
	function Plans_model()
	{
		parent::Model();
	}
	
	
/*	function getPlanInfo($hotel, $field, $value)
	{
		if ($field != null and $value != null) {
		
  			$this->db->where($field, $value);
  		}
		
		$this->db->where('HP.disable', 1);
		$this->db->where('HP.fk_plan = P.id_plan');
		$this->db->where('HP.fk_hotel', $hotel);
		
		$query = $this->db->get('PLAN P, HOTEL_PLAN HP');
		return $query->result_array();
	}
	*/
	
	
	
	
	
}
?>