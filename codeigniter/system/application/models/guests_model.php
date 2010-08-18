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

	    $this->db->select('DISTINCT(G.id_guest), G.name, G.lastName, G.telephone, G.email, G.address, G.disable');
		$this->db->where('G.id_guest = RE.fk_guest and RE.id_reservation = RR.fk_reservation and RR.fk_room = RO.id_room and RO.fk_room_type = RT.id_room_type');
		$this->db->where('RT.fk_hotel', $hotel);
	
		$query = $this->db->get('GUEST G, RESERVATION RE, ROOM_RESERVATION RR, ROOM RO, ROOM_TYPE RT', $lim1, $lim2);
		return $query->result_array();
	}
	
	
	
	
	
}
?>