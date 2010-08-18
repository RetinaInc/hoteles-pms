<?php 

class Reservations_model extends Model
{
	function Reservations_model()
	{
		parent::Model();
	}
	
	
	function getReservationInfo($hotel, $field, $value, $order, $lim1, $lim2, $disable)
	{
		if ($field != null and $value != null) {
		
  			$this->db->where($field, $value);
  		}
		
		if ($order != null) {
		
  			$this->db->order_by($order);
  		}
		
		if ($disable != null) {
		
			$this->db->where('RE.disable', 1);
		}

		$this->db->select('DISTINCT(RE.id_reservation), RE.resDate, RE.status, RE.checkIn, RE.checkOut, RE.total, RE.details, RE.paymentStat, RE.billingStat, RE.fk_guest');
		$this->db->where('RE.id_reservation = RR.fk_reservation and RR.fk_room = RO.id_room and RO.fk_room_type = RT.id_room_type');
		$this->db->where('RT.fk_hotel', $hotel);
	
		$query = $this->db->get('RESERVATION RE, ROOM_RESERVATION RR, ROOM RO, ROOM_TYPE RT', $lim1, $lim2);
		return $query->result_array();
	}
	
	
	
	/*
	function getRoomReservations($hotel, $field, $value, $order)
	{
		if ($field != null and $value != null) {
  			$this->db->where($field, $value);
  		}
		
		if ($order != null) {
  			$this->db->order_by($order);
  		}
		
		$this->db->select('RT.id_room_type, RT.abrv, (RT.name)rtname, RT.description, RO.id_room, RO.number, (RO.name)rname, RR.adults, RR.children, RE.id_reservation, (RE.status)restatus, RE.checkIn, RE.checkOut, RE.fk_guest');
		$this->db->from('ROOM_TYPE RT, ROOM RO, ROOM_RESERVATION RR, RESERVATION RE');
		$this->db->where('RT.id_room_type = RO.fk_room_type AND RO.id_room = RR.fk_room AND RR.fk_reservation = RE.id_reservation');
		$this->db->where('RT.fk_hotel', $hotel);
		
		$query = $this->db->get();
		return $query->result_array();
	}
	*/
	
	
	
	
	
	
	
	
	
}
?>