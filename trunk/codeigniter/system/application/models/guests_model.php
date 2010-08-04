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
		
			$this->db->where('GUEST.disable', 1);
		}

	    $this->db->select('DISTINCT(GUEST.id_guest), GUEST.name, GUEST.lastName, GUEST.telephone, GUEST.email, GUEST.address');
		$this->db->where('GUEST.id_guest = RESERVATION.fk_guest and RESERVATION.id_reservation = ROOM_RESERVATION.fk_reservation and ROOM_RESERVATION.fk_room = ROOM.id_room and ROOM.fk_room_type = ROOM_TYPE.id_room_type');
		$this->db->where('ROOM_TYPE.fk_hotel', $hotel);
	
		$query = $this->db->get('GUEST, RESERVATION, ROOM_RESERVATION, ROOM, ROOM_TYPE', $lim1, $lim2);
		return $query->result_array();
	}
	
	
	
	
	
}
?>