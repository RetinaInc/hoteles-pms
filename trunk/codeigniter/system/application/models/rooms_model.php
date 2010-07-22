<?php 

class Rooms_model extends Model
{
	function Rooms_model()
	{
		parent::Model();
	}
	
	
	function getReservationRoomGuest($field, $value, $order)
	{
		if ($field != null and $value != null){
  			$this->db->where($field, $value);
  		}
		
		if ($order != null){
  			$this->db->order_by($order);
  		}
		
		$this->db->select('RT.abrv, (RT.name)rtname, RO.id_room, RO.number, RR.adults, RR.children, RE.id_reservation, RE.checkIn, RE.checkOut, RE.status, RE.fk_guest, G.name, G.lastName');
		$this->db->from('ROOM_TYPE RT, ROOM RO, ROOM_RESERVATION RR, RESERVATION RE, GUEST G');
		$this->db->where('RT.id_room_type = RO.fk_room_type AND RO.id_room = RR.fk_room AND RR.fk_reservation = RE.id_reservation AND RE.fk_guest = G.id_guest' );
		
		$query = $this->db->get();
		return $query->result_array();
	}
	
	
	
	
	
	
	
	
}
?>