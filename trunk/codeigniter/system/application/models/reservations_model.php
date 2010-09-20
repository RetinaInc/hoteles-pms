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

		$this->db->select('DISTINCT(RE.id_reservation), RE.resDate, RE.status, RE.checkIn, RE.checkOut, RE.details, RE.paymentStat, RE.billingStat, RE.fk_rate, RE.fk_plan, RE.fk_guest, (G.lastName)gLname');
		$this->db->select('RATE.name as ratename');
		$this->db->select('PLAN.name as planname');
		$this->db->where('RE.id_reservation = RR.fk_reservation and RR.fk_room = RO.id_room and RO.fk_room_type = RT.id_room_type and RE.fk_guest = G.id_guest');
		$this->db->where('RT.fk_hotel', $hotel);
		$this->db->join('RATE','RATE.id_rate = RE.fk_rate','left'); 
		$this->db->join('PLAN','PLAN.id_plan = RE.fk_plan','left'); 
	
		$query = $this->db->get('RESERVATION RE, ROOM_RESERVATION RR, ROOM RO, ROOM_TYPE RT, GUEST G', $lim1, $lim2);
		return $query->result_array();
	}
	
	
	function getPaymentInfo($hotel, $field, $value, $reservationId)
	{
		if ($field != null and $value != null) {
		
  			$this->db->where($field, $value);
  		}
	
		$this->db->select('DISTINCT(PA.id_payment), PA.*');
		$this->db->where('PA.fk_reservation', $reservationId);
		$this->db->where('PA.fk_reservation = RE.id_reservation and RE.id_reservation = RR.fk_reservation and RR.fk_room = RO.id_room and RO.fk_room_type = RT.id_room_type');
		$this->db->where('RT.fk_hotel', $hotel);
		$query = $this->db->get('PAYMENT PA, RESERVATION RE, ROOM_RESERVATION RR, ROOM RO, ROOM_TYPE RT');
		return $query->result_array();
	}
	
	
	/* OJOOO!!!
	function updateRR($hotel, $field1, $value1, $field2, $value2, $data)
	{
		if ($field2 != null and $value2 != null) {
		
  			$this->db->where($field2, $value2);
  		}
		
		$this->db->where($field1, $value1);
		$this->db->where('RE.id_reservation = RR.fk_reservation and RR.fk_room = RO.id_room and RO.fk_room_type = RT.id_room_type');
		$this->db->where('RT.fk_hotel', $hotel);
		$this->db->update('ROOM_RESERVATION', $data);
	}
	*/
	
	
	
	
	
	
	
	
	
}
?>