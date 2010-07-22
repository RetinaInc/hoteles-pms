<?php 

class Reservations_model extends Model
{
	function Reservations_model()
	{
		parent::Model();
	}
	
	
	function getWhereInRoom()
	{
		$where = "id_room_type IN (SELECT DISTINCT(fk_room_type) FROM ROOM)";
		
		$this->db->where($where);
		
		$query = $this->db->get('ROOM_TYPE');
		return $query->result_array();
	}
	
	
	function getReservationRoom($field, $value, $order)
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
		
		$query = $this->db->get();
		return $query->result_array();
	}
	
	
	function getAvailability($roomType, $checkIn, $checkOut)
	{
		$where = "id_room NOT IN(SELECT RO.id_room FROM ROOM RO, ROOM_RESERVATION RR, RESERVATION RE WHERE RO.fk_room_type = ".$roomType." AND RO.id_room = RR.fk_room AND RR.fk_reservation = RE.id_reservation AND RE.status != 'Canceled' AND ((RE.checkIn <= '".$checkIn."' AND RE.checkOut > '".$checkIn."') OR (RE.checkIn < '".$checkOut."' AND RE.checkOut >= '".$checkOut."') OR (RE.checkIn >= '".$checkIn."' AND RE.checkOut <= '".$checkOut."')))";
		
		$this->db->select('id_room, number');
		$this->db->from('ROOM');
		$this->db->where('fk_room_type', $roomType);
		$this->db->where('status', 'Running');
		$this->db->where('disable', 1);
		$this->db->where($where);
		$query = $this->db->get();
		return $query->result_array();
	}
	
	
	function getAvailabilityOther($checkIn, $checkOut, $totalPer)
	{
		$where = "RO.id_room NOT IN(SELECT RO.id_room FROM ROOM RO, ROOM_RESERVATION RR, RESERVATION RE WHERE RO.id_room = RR.fk_room AND RR.fk_reservation = RE.id_reservation AND RE.status != 'Canceled' AND ((RE.checkIn <= '".$checkIn."' AND RE.checkOut > '".$checkIn."') OR (RE.checkIn < '".$checkOut."' AND RE.checkOut >= '".$checkOut."') OR (RE.checkIn >= '".$checkIn."' AND RE.checkOut <= '".$checkOut."')))";
		
		$this->db->select('RO.id_room, RO.number, RO.fk_room_type, RT.abrv');
		$this->db->from('ROOM RO, ROOM_TYPE RT');
		$this->db->where('RO.status', 'Running');
		$this->db->where('RO.disable', 1);
		$this->db->where('RO.fk_room_type = RT.id_room_type');
		$this->db->where('RT.paxMax >=', $totalPer);
		$this->db->where($where);
		
		$query = $this->db->get();
		return $query->result_array();
	}
	
	
	function doubleUpdate($table, $field1, $value1, $field2, $value2, $data)
	{
		if ($field2 != null and $value2 != null) {
		
  			$this->db->where($field2, $value2);
  		}
		
		$this->db->where($field1, $value1);
		$this->db->update($table, $data);
	}
	
	
	
	
	
	
	
	
	
	
}
?>