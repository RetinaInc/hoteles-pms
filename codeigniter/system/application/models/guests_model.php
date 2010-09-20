<?php 

class Guests_model extends Model
{
	function Guests_model()
	{
		parent::Model();
	}
	
	
	function getGuestInfo($hotel, $field, $value, $order, $lim1, $lim2, $disable)
	{
		if ($field != null and $value != null) {
		
  			$this->db->where($field, $value);
  		}
		
		if ($order != null) {
		
  			$this->db->order_by($order);
  		}
		
		if ($disable != null) {
		
			$this->db->where('G.disable', 1);
		}

	    $this->db->select('DISTINCT(G.id_guest), G.ci, G.name, G.name2, G.lastName, G.lastName2, G.telephone, G.email, G.address, G.disable');
		$this->db->where('G.id_guest = RE.fk_guest and RE.id_reservation = RR.fk_reservation and RR.fk_room = RO.id_room and RO.fk_room_type = RT.id_room_type');
		$this->db->where('RT.fk_hotel', $hotel);
	
		$query = $this->db->get('GUEST G, RESERVATION RE, ROOM_RESERVATION RR, ROOM RO, ROOM_TYPE RT', $lim1, $lim2);
		return $query->result_array();
	}
	
	
	function getOtherGuestInfo($hotel, $field1, $value1, $field2, $value2, $order)
	{
		if ($field1 != null and $value1 != null) {
		
  			$this->db->where($field1, $value1);
  		}
		
		if ($field2 != null and $value2 != null) {
		
  			$this->db->where($field2, $value2);
  		}
		
		if ($order != null) {
		
  			$this->db->order_by($order);
  		}

	    $this->db->select('DISTINCT(OG.id_other_guest), OG.*');
		$this->db->where('OG.fk_reservation = RE.id_reservation and RE.id_reservation = RR.fk_reservation and RR.fk_room = RO.id_room and RO.fk_room_type = RT.id_room_type');
		$this->db->where('RT.fk_hotel', $hotel);
	
		$query = $this->db->get('OTHER_GUEST OG, RESERVATION RE, ROOM_RESERVATION RR, ROOM RO, ROOM_TYPE RT');
		return $query->result_array();
	}
	
	
	function autocompleteGetGuestNames($hotel)
	{
		$this->db->select('DISTINCT(G.id_guest), G.name, G.name2, G.lastName, G.lastName2');
		$this->db->where('G.disable', 1);
		$this->db->where('G.id_guest = RE.fk_guest and RE.id_reservation = RR.fk_reservation and RR.fk_room = RO.id_room and RO.fk_room_type = RT.id_room_type');
		$this->db->where('RT.fk_hotel', $hotel);
		$query = $this->db->get('GUEST G, RESERVATION RE, ROOM_RESERVATION RR, ROOM RO, ROOM_TYPE RT', $lim1, $lim2);
		return $query->result_array();
	}

	
	function getSearchGuest($hotel, $search_string, $page=-1)
    {	
        // This variable is stored in the config.php file
        $letter_replace_array = $this->config->item('letter_replace_array');
        
        // Replaces the accents and common words for the corresponding letters / words
        $search_input = strtr($search_string, $letter_replace_array);
        
        // Generates an array of search words
        $search_words_array = explode(',',trim($search_input));
		
		/*
		echo 'se0: ', $search_words_array[0]."<br>";
		echo 'se1: ', $search_words_array[1]."<br>";
		echo 'se2: ', $search_words_array[2]."<br>";
		echo 'se3: ', $search_words_array[3]."<br>";
		*/
		
		$search_array_name1 = explode(' ',trim($search_words_array[0]));
		$search_array_name2 = explode(' ',trim($search_words_array[1]));
		
		/*
		echo 'name1: ', $search_array_name1[0]."<br>";
		echo 'name2: ', $search_array_name1[1]."<br>";
		echo 'name5: ', $search_array_name1[2]."<br>";
		echo 'name6: ', $search_array_name1[3]."<br>";
		echo 'name3: ', $search_array_name2[0]."<br>";
		echo 'name4: ', $search_array_name2[1]."<br>";
		*/
		
		$name1 = $search_array_name1[0];
		$name2 = $search_array_name1[1];
		$name5 = $search_array_name1[2];
		$name6 = $search_array_name1[3];
		$name3 = $search_array_name2[0];
		$name4 = $search_array_name2[1];
		
		$allNames = array(); 
		
		if ($name1 != NULL) {
		
			$allNames[] = $name1;  
		}
		
		if ($name2 != NULL) {
		
			$allNames[] = $name2;  
		}
		
		if ($name3 != NULL) {
		
			$allNames[] = $name3;  
		}
		
		if ($name4 != NULL) {
		
			$allNames[] = $name4;  
		}
		
		if ($name5 != NULL) {
		
			$allNames[] = $name5;  
		}
		
		if ($name6 != NULL) {
		
			$allNames[] = $name6;  
		}
		
		//print_r($allNames);
		
        if ($page != '-1')
        {
            // So far we just check page number greater than 1. Pending top page number lower than total_pages results
            $page = max (1, $page);

            $limit_offset = ($page - 1) * PAGINATION_PER_PAGE_LIMIT;
            
            $this->db->limit(PAGINATION_PER_PAGE_LIMIT, $limit_offset);            
        }
        
          //
        // QyeryString creation
        // Copy/Paste from the original version from Hugo Aponte. Too lazy to translate using Active Record :)
        //
        
		
		$name_like_string = "'%" . implode("%' OR G.name LIKE '%",$allNames) . "%'";
		$name2_like_string = "'%" . implode("%' OR G.name2 LIKE '%",$allNames) . "%'";
		$last_name_like_string = "'%" . implode("%' OR G.lastName LIKE '%",$allNames) . "%'";
		$last_name2_like_string = "'%" . implode("%' OR G.lastName2 LIKE '%",$allNames) . "%'";
		$ci_like_string = "'%" . implode("%' OR G.ci LIKE '%",$allNames) . "%'";
				
		$nameCount = count($allNames);
		echo 'COUNT: ', $nameCount;
		
		if ($nameCount == 1) {
			
			$where_string = "( (G.name like $name_like_string) OR
						       (G.name2 like $name2_like_string) OR 
							   (G.lastName like $last_name_like_string) OR
						       (G.lastName2 like $last_name2_like_string) OR
						       (G.ci like $ci_like_string)
						     )";
		}
		
		if ($nameCount == 2) {
			
			$where_string = "( ((G.name like $name_like_string) AND (G.name2 like $name2_like_string)) OR
						       ((G.name like $name_like_string) AND (G.lastName like $last_name_like_string)) OR
							   ((G.name like $name_like_string) AND (G.lastName2 like $last_name2_like_string)) OR
							   ((G.name2 like $name2_like_string) AND (G.lastName like $last_name_like_string)) OR 
							   ((G.name2 like $name2_like_string) AND (G.lastName2 like $last_name2_like_string)) OR 
							   ((G.lastName like $last_name_like_string) AND (G.lastName2 like $last_name2_like_string)) 
						     )";
		}
		
		if ($nameCount == 3) {
	
			$where_string = "( ((G.name like $name_like_string) AND (G.name2 like $name2_like_string) AND (G.lastName like $last_name_like_string)) OR
						       ((G.name like $name_like_string) AND (G.name2 like $name2_like_string) AND (G.lastName2 like $last_name2_like_string)) OR
							   ((G.name like $name_like_string) AND (G.lastName like $last_name_like_string) AND (G.lastName2 like $last_name2_like_string)) OR
							   ((G.name2 like $name2_like_string) AND (G.lastName like $last_name_like_string) AND (G.lastName2 like $last_name2_like_string)) 
						     )";
		}
		
		if ($nameCount == 4) {
			
			$where_string = "( (G.name like $name_like_string) AND
						       (G.lastName like $last_name_like_string) AND
						       (G.name2 like $name2_like_string) AND 
						       (G.lastName2 like $last_name2_like_string)
						     )";
		}
		
		
		$this->db->select('DISTINCT(G.id_guest), G.*');
		$this->db->where('G.disable', 1);
		$this->db->where('G.id_guest = RE.fk_guest AND RE.id_reservation = RR.fk_reservation AND RR.fk_room = RO.id_room AND RO.fk_room_type = RT.id_room_type');
		$this->db->where('RT.fk_hotel', $hotel);
        $this->db->where($where_string);
        $this->db->order_by('G.lastName','asc');
        $this->db->from('GUEST G, RESERVATION RE, ROOM_RESERVATION RR, ROOM RO, ROOM_TYPE RT');
		
        $query = $this->db->get();
        return $query->result_array();
        
    }
	
	
	
	
}
?>