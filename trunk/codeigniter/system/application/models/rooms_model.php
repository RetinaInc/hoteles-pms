<?php 

class Rooms_model extends Model
{
	function Rooms_model()
	{
		parent::Model();
	}
	
	
	/*
	function get_rooms_reservations($field, $value)
	{	
		$query = $this->db->query('SELECT * FROM ROOM, ROOM_RESERVATION, RESERVATION WHERE '.$field.'='.$value.' AND ROOM.ID_ROOM = ROOM_RESERVATION.FK_ID_ROOM AND ROOM_RESERVATION.FK_ID_RESERVATION = RESERVATION.ID_RESERVATION');
		return $query->result_array();
	}
	
	
	function get_rooms_reservations($field, $value, $order)
	{
		if ($field != null and $value != null)
		{
  			$this->db->where($field, $value);
  		}
		
		if ($order != null)
		{
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