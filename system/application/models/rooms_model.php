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
		
		$this->db->select('RT.ABRV, (RT.NAME)RTNAME, RO.ID_ROOM, RO.NUMBER, RR.ADULTS, RR.CHILDREN, RE.ID_RESERVATION, RE.CHECK_IN, RE.CHECK_OUT, RE.STATUS, RE.FK_ID_GUEST, G.NAME, G.LAST_NAME');
		$this->db->from('ROOM_TYPE RT, ROOM RO, ROOM_RESERVATION RR, RESERVATION RE, GUEST G');
		$this->db->where('RT.ID_ROOM_TYPE = RO.FK_ID_ROOM_TYPE AND RO.ID_ROOM = RR.FK_ID_ROOM AND RR.FK_ID_RESERVATION = RE.ID_RESERVATION AND RE.FK_ID_GUEST = G.ID_GUEST' );
		
		$query = $this->db->get();
		return $query->result_array();
	}
	
	
	
	/*
	function getRoomsReservations($field, $value)
	{	
		$query = $this->db->query('SELECT * FROM ROOM, ROOM_RESERVATION, RESERVATION WHERE '.$field.'='.$value.' AND ROOM.ID_ROOM = ROOM_RESERVATION.FK_ID_ROOM AND ROOM_RESERVATION.FK_ID_RESERVATION = RESERVATION.ID_RESERVATION');
		return $query->result_array();
	}
	
	
	function get_rooms_reservations($field, $value, $order)
	{
		if ($field != null and $value != null){
  			$this->db->where($field, $value);
  		}
		
		if ($order != null){
  			$this->db->order_by($order);
  		}
		
		$this->db->select('*');
		$this->db->from('ROOM, ROOM_RESERVATION, RESERVATION');
		$this->db->where('ROOM.ID_ROOM = ROOM_RESERVATION.FK_ID_ROOM AND ROOM_RESERVATION.FK_ID_RESERVATION = RESERVATION.ID_RESERVATION' );
		
		$query = $this->db->get();
		return $query->result_array();
	}
	*/
	
	
	
	
	
	
	
}
?>