<?php

class Guests extends Controller
{
	function Guests()
	{
		parent::Controller();
		$this->load->model('general_model','GM');
		$this->lang->load ('form_validation','spanish');
		$this->load->library('form_validation');
		$this->load->helper('form');
		$this->load->helper('date');
		$this->load->helper('url');
	}
	
	function index()
	{
		echo 'guests controller';
	}
	
	
	function view_guests()
	{
		$guests = $this->GM->get_info('GUEST', null, null, 'LAST_NAME', null, null);
		
		$data['guests'] = $guests;
		
		$this->load->view('guests/guests_view', $data);
	}
	
	
	function info_guest_reservations($guest_id)
	{
		$order = $_POST["order"];
		
		$guest = $this->GM->get_info('GUEST', 'ID_GUEST', $guest_id, null, null, null);
		$reservations = $this->GM->get_info('RESERVATION', 'FK_ID_GUEST', $guest_id, $order, null, null);
		
		$data['guest'] = $guest;
		$data['reservations'] = $reservations;
		
		$this->load->view('guests/guest_reservations_info_view', $data);
	}
	
	
	/*
	function add_guests()
	{
		$this->form_validation->set_rules('room_number','number','required|max_length[20]|callback_check_room_number');
		$this->form_validation->set_rules('room_name','lang:name','max_length[50]');
		$this->form_validation->set_rules('room_status','lang:status','required|max_length[20]');
		$this->form_validation->set_rules('room_room_type','lang:room_type','required|max_length[20]');
		
		if ($this->form_validation->run() == FALSE)
		{
			$max_room_number = $this->GM->get_max('ROOM', 'NUMBER');
			$room_types = $this->GM->get_info('ROOM_TYPE', $field = null, $value = null, null, null, null);
		
			$data['room_types'] = $room_types;
			$data['max_room_number'] = $max_room_number;
		
			$this->load->view('rooms/room_add_view', $data);
		}
		else
		{
			$hotel = $this->GM->get_info('HOTEL', $field = null, $value = null, null, null, null);
			foreach ($hotel as $row)
			{
				$hotel_id = $row['ID_HOTEL'];
			}
			
			$room_number = set_value('room_number');
			$room_name = set_value('room_name');
			$room_status = set_value('room_status');
			$room_room_type = set_value('room_room_type');
			
			$data = array(
				'NUMBER' => $room_number,
				'NAME' => ucwords(strtolower($room_name)),
				'STATUS' => $room_status,
				'FK_ID_HOTEL' => $hotel_id,
				'FK_ID_ROOM_TYPE' => $room_room_type
				);
			
			$this->GM->insert('ROOM', $data);  
				
			$this->view_rooms(); 
		}
		
	}
	*/
	
	
	function edit_guest($guest_id)
	{
		$this->form_validation->set_rules('guest_name','lang:name','required|max_length[30]');
		$this->form_validation->set_rules('guest_last_name','lang:last_name','required|max_length[30]');
		$this->form_validation->set_rules('guest_telephone','lang:telephone','required|numeric|max_length[20]');
		$this->form_validation->set_rules('guest_email','lang:email','required|valid_email|max_length[50]');
		$this->form_validation->set_rules('guest_address','lang:address','max_length[300]');
		
		if ($this->form_validation->run() == FALSE)
		{
			$guest = $this->GM->get_info('GUEST', 'ID_GUEST', $guest_id, null, null, null);
			
			$data['guest'] = $guest;

			$this->load->view('guests/guest_edit_view', $data);
		}
		else
		{
			$guest_name = set_value('guest_name');
			$guest_last_name = set_value('guest_last_name');
			$guest_telephone = set_value('guest_telephone');
			$guest_email = set_value('guest_email');
			$guest_address = set_value('guest_address');
			
			$data = array(
				'NAME' => ucwords(strtolower($guest_name)),
				'LAST_NAME' => ucwords(strtolower($guest_last_name)),
				'TELEPHONE' => $guest_telephone,
				'EMAIL' => $guest_email,
				'ADDRESS' => $guest_address
				);
			
			$this->GM->update('GUEST', 'ID_GUEST', $guest_id, $data);  
				
			$this->info_guest_reservations($guest_id); 
		}
		
	}
	
	
	function delete_guest($guest_id)
	{
		$guest_reservation = $this->GM->get_info('RESERVATION', 'FK_ID_GUEST', $guest_id, null, null, null);
		
		$datestring = "%Y-%m-%d  %h:%i %a";
		$time = time();
		$date = mdate($datestring, $time);
		
		$delete = 'Yes';
		
		foreach ($guest_reservation as $row)
		{
		 	$res_num = $row['CONFIRM_NUM'];
			$check_in = $row['CHECK_IN'];
			
			if ($check_in > $date)
			{
				$delete = 'No';
			}
		}
		
		if ($delete == 'No')
		{
			echo 'No se puede eliminar porque tiene la reservacion # '.$res_num.' pendiente';?><br /><br /><?php
			$this->info_guest_reservations($guest_id);
		}
		else
		{
			$this->GM->disable('GUEST', 'ID_GUEST', $guest_id);  
			$this->view_guests(); 
		}	
	}
	
	
	






}
?>