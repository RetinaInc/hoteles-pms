<?php 

class Seasons_model extends Model
{
	function Seasons_model()
	{
		parent::Model();
	}
	
	
	function getInSeason($hotel, $date, $seasonId, $fkSeason, $checkFKNull)
	{	
		/*
		echo 'HOTEL: ', $hotel."<br>";
		echo 'DATE: ', $date."<br>";
		echo 'SEASONID: ', $seasonId."<br>";
		echo 'FKSEASON: ', $fkSeason."<br>";
		echo 'CHECKFKNULL: ', $checkFKNull."<br><br>";
		*/
		
		if ($seasonId != NULL) {
		
			$where = "id_season != ".$seasonId." AND (fk_season != '".$seasonId."' OR fk_season IS NULL)";
			
  			$this->db->where($where);			
  		}
		
		if ($fkSeason != NULL) {
		
  			$this->db->where('id_season !=', $fkSeason);			
  		}
		
		if ($checkFKNull == 1) {
		
  			$this->db->where('fk_season IS NOT NULL');			
  		}
		
		$this->db->where('dateStart <=', $date);
		$this->db->where('dateEnd >=', $date);  //OJO, se modifico. Antes era $dateEnd > $date
		$this->db->where('fk_hotel', $hotel);
		
		$query = $this->db->get('SEASON'); 
		return $query->result_array();
	}
	
	
	function getCheckSeason($hotel, $dateStart, $dateEnd, $seasonId)
	{	
		if ($seasonId != null) {
		
  			$this->db->where('id_season !=', $seasonId);
  		}
		
		$this->db->where('dateStart', $dateStart);
		$this->db->where('dateEnd', $dateEnd); 
		$this->db->where('fk_hotel', $hotel);
		
		$query = $this->db->get('SEASON'); 
		return $query->result_array();
	}

	
	
	
}
?>