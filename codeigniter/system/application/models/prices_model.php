<?php 

class Prices_model extends Model
{
	function Prices_model()
	{
		parent::Model();
	}
	
	
	function getPriceInfo($season, $rate, $plan, $roomType, $persType)
	{
		if ($season != null) {
		
  			$this->db->where('fk_season', $season);
  		}
		
		if ($rate != null) {
		
  			$this->db->where('fk_rate', $rate);
  		}
		
		if ($plan!= null) {
		
  			$this->db->where('fk_plan', $plan);
  		}
		
		if ($roomType != null) {
		
  			$this->db->where('fk_room_type', $roomType);
  		}
		
		if ($persType != null) {
		
  			$this->db->where('persType', $persType);
  		}
		
		$query = $this->db->get('PRICE');
		return $query->result_array();
	}
	
	
	function updatePrice($season, $rate, $plan, $roomType, $persType, $data)
	{
		$this->db->where('fk_season', $season);
		$this->db->where('fk_rate', $rate);
		$this->db->where('fk_plan', $plan);
		$this->db->where('persType', $persType);
		
		if ($roomType != null) {
		
  			$this->db->where('fk_room_type', $roomType);
  		}
		
		$this->db->update('PRICE', $data);
	}
	
	
	
	
}
?>