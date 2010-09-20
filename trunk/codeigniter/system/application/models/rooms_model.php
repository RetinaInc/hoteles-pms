<?php 

class Rooms_model extends Model
{
	function Rooms_model()
	{
		parent::Model();
	}
	
	
	function getRoomInfo($hotel, $field, $value, $order, $lim1, $lim2, $disable)
	{
		if ($field != null and $value != null) {
		
  			$this->db->where($field, $value);
  		}
		
		if ($order != null) {
		
  			$this->db->order_by($order);
  		}
		
		if ($disable != null) {
		
			$this->db->where('ROOM.disable', 1); 
		}

		$this->db->select('ROOM.*');
		$this->db->select('ROOM_TYPE.id_room_type as rtid');
		$this->db->select('ROOM_TYPE.abrv as rtabrv');
		$this->db->select('ROOM_TYPE.description as rtdescription');
		$this->db->where('ROOM.fk_room_type = ROOM_TYPE.id_room_type');
		$this->db->where('ROOM_TYPE.fk_hotel', $hotel);
	
		$query = $this->db->get('ROOM, ROOM_TYPE', $lim1, $lim2);
		return $query->result_array();
	}
	
	
	function getRoomCount($hotel, $field1, $value1, $field2, $value2, $disable)
	{
		if ($field1 != null and $value1 != null) {
		
  			$this->db->where($field1, $value1);
  		}
		
		if ($field2 != null and $value2 != null) {
		
  			$this->db->where($field2, $value2);
  		}
		
		$this->db->where('RO.disable', 1); 
		$this->db->where('RO.fk_room_type = RT.id_room_type');
		$this->db->where('RT.fk_hotel', $hotel);
		$this->db->from('ROOM RO, ROOM_TYPE RT');
		$query = $this->db->count_all_results();
		return $query;
	}
	
	
	function getRRInfo($hotel, $field, $value)
	{
		if ($field != null and $value != null) {
		
  			$this->db->where($field, $value);
  		}

		$this->db->where('RE.id_reservation = RR.fk_reservation and RR.fk_room = RO.id_room and RO.fk_room_type = RT.id_room_type');
		$this->db->where('RT.fk_hotel', $hotel);
	
		$query = $this->db->get('RESERVATION RE, ROOM_RESERVATION RR, ROOM RO, ROOM_TYPE RT');
		return $query->result_array();
	}
	
	
	function getRRCount($hotel, $field1, $value1, $field2, $value2)
	{
		if ($field1 != null and $value1 != null) {
		
  			$this->db->where($field1, $value1);
  		}
		
		if ($field2 != null and $value2 != null) {
		
  			$this->db->where($field2, $value2);
  		}
		
		//$this->db->where('RESERVATION.disable', 1); 
		$this->db->where('RE.id_reservation = RR.fk_reservation and RR.fk_room = RO.id_room and RO.fk_room_type = RT.id_room_type');
		$this->db->where('RT.fk_hotel', $hotel);
		$this->db->from('RESERVATION RE, ROOM_RESERVATION RR, ROOM RO, ROOM_TYPE RT');
		$query = $this->db->count_all_results();
		return $query;
	}
	
	
	function getRoomReservationsGuest($hotel, $field, $value, $order)
	{
		if ($field != null and $value != null){
		
  			$this->db->where($field, $value);
  		}
		
		if ($order != null){
		
  			$this->db->order_by($order);
  		}
		
		$this->db->select('RT.id_room_type, RT.abrv, (RT.name)rtname, RT.description, RO.id_room, RO.number, (RO.name)rname, (RO.status)rstatus, RR.adults, RR.children, RR.total, RE.id_reservation, (RE.status)restatus, RE.checkIn, RE.checkOut, RE.fk_guest, G.name, G.lastName');
		$this->db->from('ROOM_TYPE RT, ROOM RO, ROOM_RESERVATION RR, RESERVATION RE, GUEST G');
		$this->db->where('RT.id_room_type = RO.fk_room_type AND RO.id_room = RR.fk_room AND RR.fk_reservation = RE.id_reservation AND RE.fk_guest = G.id_guest' );
		$this->db->where('RT.fk_hotel', $hotel);
		
		$query = $this->db->get();
		return $query->result_array();
	}
	
	
	function getMaxRoomNumber($hotel)
	{
		$this->db->select_max('number');
		$this->db->where('ROOM.disable', 1); 
		$this->db->where('ROOM.fk_room_type = ROOM_TYPE.id_room_type');
		$this->db->where('ROOM_TYPE.fk_hotel', $hotel); 
		$query = $this->db->get('ROOM, ROOM_TYPE');
		return $query->result_array();
	}
	
	/*
	function getWhereInRoom($hotel)
	{
		$where = "id_room_type IN (SELECT DISTINCT(fk_room_type) from ROOM)";
		
		$this->db->where($where);
		
		$this->db->where('fk_hotel', $hotel); 
		$query = $this->db->get('ROOM_TYPE');
		return $query->result_array();
	}
	*/
	
	function getAsRoomType($hotel, $pers, $totalPers)
	{
		$where = "id_room_type IN (SELECT DISTINCT(fk_room_type) from ROOM where status = 'Running')";
		
		$this->db->where('fk_hotel', $hotel);
		$this->db->where('paxMax >=', $pers);
		$this->db->where('paxStd <=', $totalPers);
		$this->db->where($where);
		$this->db->order_by('paxMax');
		$query = $this->db->get('ROOM_TYPE');
		return $query->row_array(); 
	}
	
	
	function getAsRoom($hotel, $roomType, $checkIn, $checkOut)
	{	
		$where = "id_room NOT IN(SELECT RO.id_room FROM ROOM RO, ROOM_RESERVATION RR, RESERVATION RE WHERE RO.fk_room_type = ".$roomType." AND RO.id_room = RR.fk_room AND RR.fk_reservation = RE.id_reservation AND RE.status != 'Canceled' AND ((RE.checkIn <= '".$checkIn."' AND RE.checkOut > '".$checkIn."') OR (RE.checkIn < '".$checkOut."' AND RE.checkOut >= '".$checkOut."') OR (RE.checkIn >= '".$checkIn."' AND RE.checkOut <= '".$checkOut."')))";
		
		$this->db->select('RO.id_room, RO.number');
		$this->db->where('RO.status', 'Running');
		$this->db->where('RO.disable', 1);
		$this->db->where('RO.fk_room_type = RT.id_room_type');
		$this->db->where('RT.fk_hotel', $hotel);
		$this->db->where('RT.id_room_type', $roomType);
		$this->db->where($where);
		$query = $this->db->get('ROOM RO, ROOM_TYPE RT');
		return $query->row_array(); 
	}
	
	/*
	function getOtRoomType($hotel, $totalPers)
	{
		$where = "id_room_type IN (SELECT DISTINCT(fk_room_type) from ROOM where status = 'Running')";
		
		$this->db->where('fk_hotel', $hotel);
		$this->db->where('paxMax >=', $totalPers);
		$this->db->where($where);
		$this->db->order_by('paxMax');
		$query = $this->db->get('ROOM_TYPE');
		return $query->row_array(); 
	}
	*/
	
	function getAvailability($hotel, $roomType, $checkIn, $checkOut)
	{	
		$where = "id_room NOT IN(SELECT RO.id_room FROM ROOM RO, ROOM_RESERVATION RR, RESERVATION RE WHERE RO.fk_room_type = ".$roomType." AND RO.id_room = RR.fk_room AND RR.fk_reservation = RE.id_reservation AND RE.status != 'Canceled' AND ((RE.checkIn <= '".$checkIn."' AND RE.checkOut > '".$checkIn."') OR (RE.checkIn < '".$checkOut."' AND RE.checkOut >= '".$checkOut."') OR (RE.checkIn >= '".$checkIn."' AND RE.checkOut <= '".$checkOut."')))";
		
		$this->db->select('RO.id_room, RO.number');
		$this->db->where('RO.status', 'Running');
		$this->db->where('RO.disable', 1);
		$this->db->where('RO.fk_room_type = RT.id_room_type');
		$this->db->where('RT.fk_hotel', $hotel);
		$this->db->where('RT.id_room_type', $roomType);
		$this->db->where($where);
		$query = $this->db->get('ROOM RO, ROOM_TYPE RT');
		return $query->result_array();
	}
	
	
	/*
	function getAvailability($hotel, $roomType, $checkIn, $checkOut)
	{
		$where = "id_room NOT IN(SELECT RO.id_room FROM ROOM RO, ROOM_RESERVATION RR, RESERVATION RE WHERE RO.fk_room_type = ".$roomType." AND RO.id_room = RR.fk_room AND RR.fk_reservation = RE.id_reservation AND RE.status != 'Canceled' AND ((RE.checkIn <= '".$checkIn."' AND RE.checkOut > '".$checkIn."') OR (RE.checkIn < '".$checkOut."' AND RE.checkOut >= '".$checkOut."') OR (RE.checkIn >= '".$checkIn."' AND RE.checkOut <= '".$checkOut."')))";
		
		$this->db->select('RO.id_room, RO.number');
		$this->db->where('RO.status', 'Running');
		$this->db->where('RO.disable', 1);
		$this->db->where('RO.fk_room_type = RT.id_room_type');
		$this->db->where('RT.fk_hotel', $hotel);
		$this->db->where('RT.id_room_type', $roomType);
		$this->db->where($where);
		$query = $this->db->get('ROOM RO, ROOM_TYPE RT');
		return $query->result_array();
	}
	*/
	
	function getRoomAvailability($hotel, $room, $reservationId, $checkIn, $checkOut)
	{
		$where = "id_room NOT IN(SELECT RO.id_room FROM ROOM RO, ROOM_RESERVATION RR, RESERVATION RE WHERE RO.fk_room_type = ".$roomType." AND RO.id_room = RR.fk_room AND RR.fk_reservation = RE.id_reservation AND RE.status != 'Canceled' AND ((RE.checkIn <= '".$checkIn."' AND RE.checkOut > '".$checkIn."') OR (RE.checkIn < '".$checkOut."' AND RE.checkOut >= '".$checkOut."') OR (RE.checkIn >= '".$checkIn."' AND RE.checkOut <= '".$checkOut."')))";
		
		$this->db->select('RO.id_room, RO.number');
		$this->db->where('RO.status', 'Running');
		$this->db->where('RO.disable', 1);
		$this->db->where('RO.fk_room_type = RT.id_room_type');
		$this->db->where('RT.fk_hotel', $hotel);
		$this->db->where('RT.id_room_type', $roomType);
		$this->db->where($where);
		$query = $this->db->get('ROOM RO, ROOM_TYPE RT');
		return $query->result_array();
	}
	
	
	function getAvailabilityOther($hotel, $checkIn, $checkOut, $totalPer)
	{
		$where = "RO.id_room NOT IN(SELECT RO.id_room FROM ROOM RO, ROOM_RESERVATION RR, RESERVATION RE WHERE RO.id_room = RR.fk_room AND RR.fk_reservation = RE.id_reservation AND RE.status != 'Canceled' AND ((RE.checkIn <= '".$checkIn."' AND RE.checkOut > '".$checkIn."') OR (RE.checkIn < '".$checkOut."' AND RE.checkOut >= '".$checkOut."') OR (RE.checkIn >= '".$checkIn."' AND RE.checkOut <= '".$checkOut."')))";
		
		//$this->db->select('RO.id_room, RO.number, RO.fk_room_type, RT.abrv');
		$this->db->where('RO.status', 'Running');
		$this->db->where('RO.disable', 1);
		$this->db->where('RO.fk_room_type = RT.id_room_type');
		$this->db->where('RT.fk_hotel', $hotel);
		$this->db->where('RT.paxMax >=', $totalPer);
		$this->db->where('RT.paxStd <=', $totalPer);
		$this->db->where($where);
		$query = $this->db->get('ROOM RO, ROOM_TYPE RT');
		return $query->result_array();
	}
	
	
	function validationCheckRoom($hotel, $field1, $value1, $field2, $value2)
	{
		if ($field1 != null and $value1 != null) {
		
  			$this->db->where($field1, $value1);
  		}
		
		if ($field2 != null and $value2 != null) {
		
  			$this->db->where($field2, $value2);
  		}
		
		$this->db->where('ROOM.disable', 1); 
		$this->db->where('ROOM.fk_room_type = ROOM_TYPE.id_room_type');
		$this->db->where('ROOM_TYPE.fk_hotel', $hotel); 
		$query = $this->db->get('ROOM, ROOM_TYPE');
		return $query->result_array();
	}
	
	
	
}
?>