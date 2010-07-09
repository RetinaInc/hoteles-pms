<?php 

class Reservations_model extends Model
{
	function Reservations_model()
	{
		parent::Model();
	}
	
	
	function get_reservation_room($field, $value, $order)
	{
		if ($field != null and $value != null)
		{
  			$this->db->where($field, $value);
  		}
		
		if ($order != null)
		{
  			$this->db->order_by($order);
  		}
		
		$this->db->select('RT.ABRV, (RT.NAME)RTNAME, RT.DETAILS, RO.ID_ROOM, RO.NUMBER, (RO.NAME)RNAME, RR.ADULTS, RR.CHILDREN, RE.ID_RESERVATION, (RE.STATUS)RESTATUS, RE.CHECK_IN, RE.CHECK_OUT, RE.FK_ID_GUEST');
		$this->db->from('ROOM_TYPE RT, ROOM RO, ROOM_RESERVATION RR, RESERVATION RE');
		$this->db->where('RT.ID_ROOM_TYPE = RO.FK_ID_ROOM_TYPE AND RO.ID_ROOM = RR.FK_ID_ROOM AND RR.FK_ID_RESERVATION = RE.ID_RESERVATION');
		
		$query = $this->db->get();
		return $query->result_array();
	}
	
	
	function get_availability($room_type, $check_in, $check_out)
	{
		$where = "ID_ROOM NOT IN(SELECT RO.ID_ROOM FROM ROOM RO, ROOM_RESERVATION RR, RESERVATION RE WHERE RO.FK_ID_ROOM_TYPE = ".$room_type." AND RO.ID_ROOM = RR.FK_ID_ROOM AND RR.FK_ID_RESERVATION = RE.ID_RESERVATION AND RE.STATUS != 'Canceled' AND ((RE.CHECK_IN <= '".$check_in."' AND RE.CHECK_OUT > '".$check_in."') OR (RE.CHECK_IN < '".$check_out."' AND RE.CHECK_OUT >= '".$check_out."') OR (RE.CHECK_IN >= '".$check_in."' AND RE.CHECK_OUT <= '".$check_out."')))";
		
		$this->db->select('ID_ROOM, NUMBER');
		$this->db->from('ROOM');
		$this->db->where('FK_ID_ROOM_TYPE', $room_type);
		$this->db->where('STATUS', 'Running');
		$this->db->where('DISABLE', 1);
		$this->db->where($where);
		$query = $this->db->get();
		return $query->result_array();
	}
	
	
	
	
	/*
	function get_availability($room_type, $check_in, $check_out)
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
	
	
	function get_available($room_type, $occupied)
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