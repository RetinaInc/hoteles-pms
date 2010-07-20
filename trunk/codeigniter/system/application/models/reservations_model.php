<?php 

class Reservations_model extends Model
{
	function Reservations_model()
	{
		parent::Model();
	}
	
	
	function getReservationRoom($field, $value, $order)
	{
		if ($field != null and $value != null){
  			$this->db->where($field, $value);
  		}
		
		if ($order != null){
  			$this->db->order_by($order);
  		}
		
		$this->db->select('RT.ID_ROOM_TYPE, RT.ABRV, (RT.NAME)RTNAME, RT.DESCRIPTION, RO.ID_ROOM, RO.NUMBER, (RO.NAME)RNAME, RR.ADULTS, RR.CHILDREN, RE.ID_RESERVATION, (RE.STATUS)RESTATUS, RE.CHECKIN, RE.CHECKOUT, RE.FK_GUEST');
		$this->db->from('ROOM_TYPE RT, ROOM RO, ROOM_RESERVATION RR, RESERVATION RE');
		$this->db->where('RT.ID_ROOM_TYPE = RO.FK_ROOM_TYPE AND RO.ID_ROOM = RR.FK_ROOM AND RR.FK_RESERVATION = RE.ID_RESERVATION');
		
		$query = $this->db->get();
		return $query->result_array();
	}
	
	
	function getAvailability($roomType, $checkIn, $checkOut)
	{
		$where = "ID_ROOM NOT IN(SELECT RO.ID_ROOM FROM ROOM RO, ROOM_RESERVATION RR, RESERVATION RE WHERE RO.FK_ROOM_TYPE = ".$roomType." AND RO.ID_ROOM = RR.FK_ROOM AND RR.FK_RESERVATION = RE.ID_RESERVATION AND RE.STATUS != 'Canceled' AND ((RE.CHECKIN <= '".$checkIn."' AND RE.CHECKOUT > '".$checkIn."') OR (RE.CHECKIN < '".$checkOut."' AND RE.CHECKOUT >= '".$checkOut."') OR (RE.CHECKIN >= '".$checkIn."' AND RE.CHECKOUT <= '".$checkOut."')))";
		
		$this->db->select('ID_ROOM, NUMBER');
		$this->db->from('ROOM');
		$this->db->where('FK_ROOM_TYPE', $roomType);
		$this->db->where('STATUS', 'Running');
		$this->db->where('DISABLE', 1);
		$this->db->where($where);
		$query = $this->db->get();
		return $query->result_array();
	}
	
	
	function getAvailabilityOther($checkIn, $checkOut, $totalPer)
	{
		$where = "RO.ID_ROOM NOT IN(SELECT RO.ID_ROOM FROM ROOM RO, ROOM_RESERVATION RR, RESERVATION RE WHERE RO.ID_ROOM = RR.FK_ROOM AND RR.FK_RESERVATION = RE.ID_RESERVATION AND RE.STATUS != 'Canceled' AND ((RE.CHECKIN <= '".$checkIn."' AND RE.CHECKOUT > '".$checkIn."') OR (RE.CHECKIN < '".$checkOut."' AND RE.CHECKOUT >= '".$checkOut."') OR (RE.CHECKIN >= '".$checkIn."' AND RE.CHECKOUT <= '".$checkOut."')))";
		
		$this->db->select('RO.ID_ROOM, RO.NUMBER, RO.FK_ROOM_TYPE, RT.ABRV');
		//$this->db->select('ROOM_TYPE.ABRV as RTAB');
		$this->db->from('ROOM RO, ROOM_TYPE RT');
		$this->db->where('RO.STATUS', 'Running');
		$this->db->where('RO.DISABLE', 1);
		$this->db->where('RO.FK_ROOM_TYPE = RT.ID_ROOM_TYPE');
		$this->db->where('RT.MAX >=', $totalPer);
		$this->db->where($where);
		//$this->db->join('ROOM_TYPE', 'ROOM_TYPE.ID_ROOM_TYPE = ROOM.FK_ID_ROOM_TYPE','left');
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
	
	
	
	/*
	function getAvailability($room_type, $check_in, $check_out)
	{
		$where = "((RE.CHECK_IN <= '".$check_in."' AND RE.CHECK_OUT > '".$check_in."') OR (RE.CHECK_IN < '".$check_out."' AND RE.CHECK_OUT >= '".$check_out."') OR (RE.CHECK_IN >= '".$check_in."' AND RE.CHECK_OUT <= '".$check_out."'))";
		
		$this->db->select('DISTINCT(RO.NUMBER)');
		$this->db->from('ROOM RO, ROOM_RESERVATION RR, RESERVATION RE');
		$this->db->where('RO.FK_ID_ROOM_TYPE', $room_type);
		$this->db->where('RO.ID_ROOM = RR.FK_ID_ROOM');
		$this->db->where('RR.FK_ID_RESERVATION = RE.ID_RESERVATION');
		$this->db->where($where);
		$query = $this->db->get();
		return $query->result_array();
	}
	
	
	function getAvailable($room_type, $occupied)
	{	
		foreach ($occupied as $row)
		{
			echo 'Habitaciones ocupadas: ', $row['NUMBER'];?><br /><br /><?php
		}
		
	//	$occ = array('101', '102');
					
		$this->db->select('NUMBER');
		$this->db->from('ROOM');
		$this->db->where('FK_ID_ROOM_TYPE', $room_type);
		$this->db->where_not_in('NUMBER', $occupied);
		$query = $this->db->get();
		return $query->result_array();
		
	}
	
	*/
	
	
	
	
	
	
	
	
	
}
?>