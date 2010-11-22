<?php 

class Reservations_model extends Model
{
	function Reservations_model()
	{
		parent::Model();
	}
	
	
	function getReservationInfo($hotel, $field, $value, $order, $lim1, $lim2, $disable)
	{
		if ($field != null && $value != null) {
		
  			$this->db->where($field, $value);
  		}
		
		if ($order != null) {
		
  			$this->db->order_by($order);
  		}
		
		if ($disable != null) {
		
			$this->db->where('RE.disable', 1);
		}

		$this->db->select('DISTINCT(RE.id_reservation), RE.resDate, RE.status, RE.checkIn, RE.checkOut, RE.details, RE.paymentStat, RE.billingStat, RE.cancelDate, RE.totalFee, RE.fk_rate, RE.fk_plan, RE.fk_guest, (G.lastName)gLname');
		$this->db->select('RATE.name as ratename');
		$this->db->select('PLAN.name as planname');
		$this->db->where('RE.id_reservation = RR.fk_reservation AND RR.fk_room = RO.id_room AND RO.fk_room_type = RT.id_room_type AND RE.fk_guest = G.id_guest');
		$this->db->where('RT.fk_hotel', $hotel);
		$this->db->join('RATE','RATE.id_rate = RE.fk_rate','left'); 
		$this->db->join('PLAN','PLAN.id_plan = RE.fk_plan','left'); 
	
		$query = $this->db->get('RESERVATION RE, ROOM_RESERVATION RR, ROOM RO, ROOM_TYPE RT, GUEST G', $lim1, $lim2);
		return $query->result_array();
	}
	
	
	function getQuotationInfo($hotel, $field, $value)
	{
		if ($field != null && $value != null) {
		
  			$this->db->where($field, $value);
  		}

		$this->db->select('DISTINCT(RE.id_reservation), RE.resDate, RE.status, RE.checkIn, RE.checkOut, RE.details, RE.paymentStat, RE.billingStat, RE.cancelDate, RE.totalFee, RE.fk_rate, RE.fk_plan');
		$this->db->where('RE.id_reservation = RR.fk_reservation AND RR.fk_room = RO.id_room AND RO.fk_room_type = RT.id_room_type');
		$this->db->where('RT.fk_hotel', $hotel);
	
		$query = $this->db->get('RESERVATION RE, ROOM_RESERVATION RR, ROOM RO, ROOM_TYPE RT');
		return $query->result_array();
	}
	
	
	function getPaymentInfo($hotel, $field, $value, $reservationId)
	{
		if ($field != null && $value != null) {
		
  			$this->db->where($field, $value);
  		}
	
		$this->db->select('DISTINCT(PA.id_payment), PA.*');
		$this->db->where('PA.fk_reservation', $reservationId);
		$this->db->where('PA.fk_reservation = RE.id_reservation AND RE.id_reservation = RR.fk_reservation AND RR.fk_room = RO.id_room AND RO.fk_room_type = RT.id_room_type');
		$this->db->where('RT.fk_hotel', $hotel);
		$query = $this->db->get('PAYMENT PA, RESERVATION RE, ROOM_RESERVATION RR, ROOM RO, ROOM_TYPE RT');
		return $query->result_array();
	}
	
	
	function getNoShows($hotel, $date)
	{
		$this->db->select('DISTINCT(RE.id_reservation)');
		$this->db->where('RE.checkIn < ', $date);
		$this->db->where('RE.status != "Canceled" AND RE.status != "Checked Out" AND RE.status != "Checked In"');
		$this->db->where('RE.id_reservation = RR.fk_reservation AND RR.fk_room = RO.id_room AND RO.fk_room_type = RT.id_room_type AND RE.fk_guest = G.id_guest');
		$this->db->where('RT.fk_hotel', $hotel);
		$this->db->where('RE.disable', 1);
		$query = $this->db->get('RESERVATION RE, ROOM_RESERVATION RR, ROOM RO, ROOM_TYPE RT, GUEST G');
		return $query->result_array();
	}
	
	
	function getTotalRowsReservations($hotel, $field1, $value1, $field2, $value2, $disable)
	{
		if ($field1 != null && $value1 != null)
		{
  			$this->db->where($field1, $value1);
  		}
		
		if ($field2 != null && $value2 != null)
		{
  			$this->db->where($field2, $value2);
  		}
		
		if ($disable != null) {
		
			$this->db->where('RE.disable', 1);
		}
		
		$this->db->select('DISTINCT(RE.id_reservation)');
		$this->db->where('RE.id_reservation = RR.fk_reservation AND RR.fk_room = RO.id_room AND RO.fk_room_type = RT.id_room_type AND RE.fk_guest = G.id_guest');
		$this->db->where('RT.fk_hotel', $hotel);
		$this->db->from('RESERVATION RE, ROOM_RESERVATION RR, ROOM RO, ROOM_TYPE RT, GUEST G');
		$query = $this->db->get();
		
		$rows = count($query->result_array());
		
		return $rows;
	}
	
	
	function deleteReservation($hotel, $field, $value)
	{
		$this->db->where($field, $value);
		$this->db->where('RT.fk_hotel', $hotel);
		$this->db->where('RE.id_reservation = RR.fk_reservation AND RR.fk_room = RO.id_room AND RO.fk_room_type = RT.id_room_type AND RE.fk_guest = G.id_guest');
		
		$this->db->from('RESERVATION RE, ROOM_RESERVATION RR, ROOM RO, ROOM_TYPE RT, GUEST G');
		$this->db->delete('RESERVATION'); 
	}
	
	
	function getReservationsReport($hotel, $field1, $value1, $field2, $value2, $month, $year)
	{	
		//$where = "((RE.checkIn LIKE '%-".$month."-%' AND RE.checkIn LIKE '".$year."-%') OR (RE.checkOut LIKE '%-".$month."-%' AND RE.checkOut LIKE '".$year."-%'))";
		
		if ($field1 != NULL && $value1 != NULL) {
		
  			$this->db->where($field1, $value1);
  		}
		
		if ($field2 != NULL && $value2 != NULL) {
		
  			$this->db->where($field2, $value2);
  		}

		$this->db->select('DISTINCT(RE.id_reservation), RE.*');
		$this->db->where('RE.id_reservation = RR.fk_reservation AND RR.fk_room = RO.id_room AND RO.fk_room_type = RT.id_room_type AND RE.fk_guest = G.id_guest');
		$this->db->where('RT.fk_hotel', $hotel);
		//$this->db->where($where);
		$this->db->like('RE.checkIn', '-'.$month.'-'); 
		$this->db->like('RE.checkIn', $year.'-'); 
		//$this->db->or_like('RE.checkOut', '-'.$month.'-');
		//$this->db->or_like('RE.checkOut', $year.'-');
		
		$query = $this->db->get('RESERVATION RE, ROOM_RESERVATION RR, ROOM RO, ROOM_TYPE RT, GUEST G');
		return $query->result_array();
	}
	
	
	function getRoomResReport($hotel, $field1, $value1, $field2, $value2, $field3, $value3, $month, $year)
	{	
		if ($field1 != NULL && $value1 != NULL) {
		
  			$this->db->where($field1, $value1);
  		}
		
		if ($field2 != NULL && $value2 != NULL) {
		
  			$this->db->where($field2, $value2);
  		}

		if ($field3 != NULL && $value3 != NULL) {
		
  			$this->db->where($field3, $value3);
  		}
		
		$this->db->where('RE.id_reservation = RR.fk_reservation AND RR.fk_room = RO.id_room AND RO.fk_room_type = RT.id_room_type AND RE.fk_guest = G.id_guest');
		$this->db->where('RT.fk_hotel', $hotel);
		$this->db->like('RE.checkIn', '-'.$month.'-'); 
		$this->db->like('RE.checkIn', $year.'-'); 
		
		$query = $this->db->get('RESERVATION RE, ROOM_RESERVATION RR, ROOM RO, ROOM_TYPE RT, GUEST G');
		return $query->result_array();
	}
	
	
	
	/* OJOOO!!!
	function updateRR($hotel, $field1, $value1, $field2, $value2, $data)
	{
		if ($field2 != null && $value2 != null) {
		
  			$this->db->where($field2, $value2);
  		}
		
		$this->db->where($field1, $value1);
		$this->db->where('RE.id_reservation = RR.fk_reservation AND RR.fk_room = RO.id_room AND RO.fk_room_type = RT.id_room_type');
		$this->db->where('RT.fk_hotel', $hotel);
		$this->db->update('ROOM_RESERVATION', $data);
	}
	*/
	
	
	
	
	
	
	
	
	
}
?>