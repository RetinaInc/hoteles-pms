<?php

class Reservations extends Controller
{
	function Reservations()
	{
		parent::Controller();
		$this->load->model('general_model','GM');
		$this->load->model('reservations_model','REM');
		$this->lang->load ('form_validation','spanish');
		$this->load->library('form_validation');
		$this->load->helper('language');
		$this->load->helper('form');
		$this->load->helper('date');
		$this->load->helper('url');
	}
	
	function index()
	{
		echo 'reservations controller';
		$order = NULL;
	}
	

	function view_reservations()
	{
		$order = $_POST["order"];
		
		if ($order == NULL)
		{
			$order = 'RE.CHECK_IN DESC';
		}
	
		$reservations = $this->REM->get_reservation_room_guest(null, null, $order);
		
		$data['reservations'] = $reservations;
		
		$this->load->view('reservations/reservations_view', $data);
	}
	
	
	function info_reservation($reservation_id)
	{
		$reservation_info = $this->GM->get_info('RESERVATION', 'ID_RESERVATION', $reservation_id, null, null, null);
		$reservation = $this->REM->get_reservation_room_guest('RE.ID_RESERVATION', $reservation_id, $order);
		
		foreach ($reservation_info as $row)
		{
			$guest_id = $row['FK_ID_GUEST'];
			
			$check_in = $row['CHECK_IN'];
			$check_in_array = explode (' ',$check_in);
			$ci_date = $check_in_array[0];
	
			$check_out = $row['CHECK_OUT'];
			$check_out_array = explode (' ',$check_out);
			$co_date = $check_out_array[0];
			
			$nights = (strtotime($co_date) - strtotime($ci_date)) / (60 * 60 * 24);
		}
		
		$guest = $this->GM->get_info('GUEST', 'ID_GUEST', $guest_id, null, null, null);
		
		$data['reservation_info'] = $reservation;
		$data['reservation'] = $reservation;
		$data['nights'] = $nights;
		$data['guest'] = $guest;
		
		$this->load->view('reservations/reservation_info_view', $data);
	}
	
	
	function add_reservation()
	{
		$this->form_validation->set_rules('reservation_room_type','lang:room_type','required');
		$this->form_validation->set_rules('reservation_rate','lang:rate','required');
		$this->form_validation->set_rules('reservation_check_in','lang:check_in','required|alpha_dash');
		$this->form_validation->set_rules('reservation_check_out','lang:check_out','required|max_length[20]');
		$this->form_validation->set_rules('reservation_adults','lang:adults','required|integer|max_length[5]');
		$this->form_validation->set_rules('reservation_children','lang:children','required|integer|max_length[5]');
		$this->form_validation->set_rules('reservation_details','lang:details','max_length[300]');
		
		if ($this->form_validation->run() == FALSE)
		{
			$room_types = $this->GM->get_info('ROOM_TYPE', null, null, null, null, null);
			$rates = $this->GM->get_info('RATE', null, null, null, null, null);
		
			$data['room_types'] = $room_types;
			$data['rates'] = $rates;
		
			$this->load->view('reservations/reservation_add_view', $data);
		}
		else
		{
			$reservation_room_type = set_value('reservation_room_type');
			$reservation_rate = set_value('reservation_rate');
			$reservation_check_in = set_value('reservation_check_in');
			$reservation_check_out = set_value('reservation_check_out');
			$reservation_adults = set_value('reservation_adults');
			$reservation_children = set_value('reservation_children');
			$reservation_details = set_value('reservation_details');
			
			$ci_array = explode ('-',$reservation_check_in);
			$day = $ci_array[0];
			$month = $ci_array[1];
			$year = $ci_array[2];
			$check_in = $year.'-'.$month.'-'.$day.' 12:00:00';
		
			$co_array = explode ('-',$reservation_check_out);
			$day = $co_array[0];
			$month = $co_array[1];
			$year = $co_array[2];
			$check_out = $year.'-'.$month.'-'.$day.' 10:00:00';
			
			echo 'room type: ',$reservation_room_type;?><br /><?php
			echo 'check in: ',$check_in;?><br /><?php
			echo 'check out: ',$check_out;?><br /><br /><?php
			
			$occupied = $this->REM->get_availability($reservation_room_type, $check_in, $check_out);
			
			if ($occupied)	
			{
				foreach ($occupied as $row)
				{
					echo 'Habitacion ocupada: ', $row['NUMBER'];?><br /><br /><?php
				}
			}
			else
			{
				echo 'NO HAY OCUPADAS';
			}
			
			$available = $this->REM->get_available($reservation_room_type, $occupied);
			
			if ($available)	
			{
				foreach ($available as $row)
				{
					echo 'Habitacion disponible: ', $row['NUMBER'];?><br /><br /><?php
				}
			}
			else
			{
				echo 'NO HAY DISPONIBLES';
			}
		}
		
	}
	
	/*
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
	*/
	
	






}
?>