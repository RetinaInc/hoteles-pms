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
		$this->load->helper('hoteles');
		$this->load->helper('language');
		$this->load->helper('form');
		$this->load->helper('date');
		$this->load->helper('url');
	}
	
	function index()
	{
		echo 'reservations controller';
	}
	

	function view_all_reservations()
	{
		//$order = $_POST["order"];
		
		/*
		if ($order == NULL)
		{
			$order = 'CHECK_IN DESC';
		}
		*/
	
		$order = 'CHECK_IN DESC';
		
		$reservations = $this->GM->get_info('RESERVATION', null, null, $order, null, null, 1);
		$rooms = $this->REM->get_reservation_room(null, null, null);
		$guests = $this->GM->get_info('GUEST', null, null, null, null, null, null);
		
		$data['reservations'] = $reservations;
		$data['rooms'] = $rooms;
		$data['guests'] = $guests;
		
		$this->load->view('reservations/reservations_all_view', $data);
	}
	
	
	function view_pending_reservations()
	{
		//$order = $_POST["order"];
		
		$order = 'ID_RESERVATION';
		
		$datestring = "%Y-%m-%d";
		$time = time();
		$date = mdate($datestring, $time);
		
		$reservations = $this->GM->get_info('RESERVATION','CHECK_IN >=', $date, $order, null, null, 1);
		$rooms = $this->REM->get_reservation_room(null, null, null);
		$guests = $this->GM->get_info('GUEST', null, null, null, null, null, null);
		
		$data['reservations'] = $reservations;
		$data['rooms'] = $rooms;
		$data['guests'] = $guests;
		
		$this->load->view('reservations/reservations_pending_view', $data);
		
	}
	
	
	function info_reservation($reservation_id)
	{
		$reservation = $this->GM->get_info('RESERVATION', 'ID_RESERVATION', $reservation_id, null, null, null, 1);
		$room = $this->REM->get_reservation_room('ID_RESERVATION', $reservation_id, null);
		$reservation_rooms_count = $this->GM->get_count('ROOM_RESERVATION', 'FK_ID_RESERVATION', $reservation_id, null, null);
		$reservation_room_info = $this->GM->get_info('ROOM_RESERVATION', 'FK_ID_RESERVATION', $reservation_id, null, null, null, 1);
		
		foreach ($reservation as $row)
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
		
		$guest = $this->GM->get_info('GUEST', 'ID_GUEST', $guest_id, null, null, null, null);
		
		$data['reservation_rooms_count'] = $reservation_rooms_count;
		$data['reservation_room_info'] = $reservation_room_info;
		$data['reservation'] = $reservation;
		$data['room'] = $room;
		$data['nights'] = $nights;
		$data['guest'] = $guest;
		
		$this->load->view('reservations/reservation_info_view', $data);
	}
	
	
	function cancel_reservation($reservation_id, $guest_id)
	{
		$data = array(
				'STATUS' => 'Canceled'
				);
				
		$this->GM->update('RESERVATION', 'ID_RESERVATION', $reservation_id, $data);  
				
		$order = 'CHECK_IN DESC';
		
		$guest = $this->GM->get_info('GUEST', 'ID_GUEST', $guest_id, null, null, null, 1);
		$reservations = $this->GM->get_info('RESERVATION', 'FK_ID_GUEST', $guest_id, $order, null, null, 1);
		$reservation_rooms = $this->GM->get_info('ROOM_RESERVATION', null, null, null, null, null, 1);
		
		$data['guest'] = $guest;
		$data['reservations'] = $reservations;
		$data['reservation_rooms'] = $reservation_rooms;
		
		$this->load->view('guests/guest_reservations_info_view', $data);
	}
	
	
	function create_reservation_1()
	{
		$this->form_validation->set_rules('reservation_room_type','lang:room_type','required');
		$this->form_validation->set_rules('reservation_check_in','lang:check_in','required|alpha_dash');
		$this->form_validation->set_rules('reservation_check_out','lang:check_out','required|max_length[20]');
		
		if ($this->form_validation->run() == FALSE)
		{
			$room_types = $this->GM->get_info('ROOM_TYPE', null, null, null, null, null, 1);
			$rates = $this->GM->get_info('RATE', null, null, null, null, null, 1);
		
			$data['room_types'] = $room_types;
			$data['rates'] = $rates;
		
			$this->load->view('reservations/reservation_create_1_view', $data);
		}
		else
		{
			$reservation_room_type = set_value('reservation_room_type');
			$reservation_check_in = set_value('reservation_check_in');
			$reservation_check_out = set_value('reservation_check_out');
			
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
		
			$available = $this->REM->get_availability($reservation_room_type, $check_in, $check_out);
			$room_type_info = $this->GM->get_info('ROOM_TYPE', 'ID_ROOM_TYPE', $reservation_room_type, null, null, null, 1);
			
			$data['available'] = $available; 
			$data['room_type_info'] = $room_type_info; 
			$data['reservation_room_type'] = $reservation_room_type; 
			$data['reservation_check_in'] = $reservation_check_in; 
			$data['reservation_check_out'] = $reservation_check_out; 
			
			$this->load->view('reservations/reservation_create_2_view', $data);
		}
		
	}
	
	
	function create_reservation_2($room_id)
	{
		$room_type = $_POST["room_type"];
		$reservation_check_in = $_POST["check_in"];
		$reservation_check_out = $_POST["check_out"];
		
		$room_info = $this->GM->get_info('ROOM', 'ID_ROOM', $room_id, null, null, null, 1);
		$room_type_info = $this->GM->get_info('ROOM_TYPE', 'ID_ROOM_TYPE', $room_type, null, null, null, 1);
		
		$ci_array = explode ('-',$reservation_check_in);
		$day = $ci_array[0];
		$month = $ci_array[1];
		$year = $ci_array[2];
		$check_in = $year.'-'.$month.'-'.$day;
		
		$co_array = explode ('-',$reservation_check_out);
		$day = $co_array[0];
		$month = $co_array[1];
		$year = $co_array[2];
		$check_out = $year.'-'.$month.'-'.$day;
		
		$nights = (strtotime($check_out) - strtotime($check_in)) / (60 * 60 * 24);
		
		$data['room_info'] = $room_info; 
		$data['room_type_info'] = $room_type_info; 
		$data['check_in'] = $check_in.' 12:00:00'; 
		$data['check_out'] = $check_out.' 10:00:00'; 
		$data['nights'] = $nights; 
			
		$this->load->view('reservations/reservation_create_3_view', $data);
	}
	
	
	function create_reservation_3()
	{
		$room_id = $_POST["room_number"];
		$room_type = $_POST["room_type"];
		$check_in = $_POST["check_in"];
		$check_out = $_POST["check_out"];
		
		//$this->form_validation->set_rules('reservation_rate','lang:rate','required');
		$this->form_validation->set_rules('reservation_adults','lang:adults','required|integer|max_length[5]');
		$this->form_validation->set_rules('reservation_children','lang:children','required|integer|max_length[5]');
		$this->form_validation->set_rules('reservation_details','lang:details','max_length[300]');
		
		if ($this->form_validation->run() == FALSE)
		{
			$room_info = $this->GM->get_info('ROOM', 'ID_ROOM', $room_id, null, null, null, 1);
			$room_type_info = $this->GM->get_info('ROOM_TYPE', 'ID_ROOM_TYPE', $room_type, null, null, null, 1);
			
			$check_in = $check_in;
			$check_in_array = explode (' ',$check_in);
			$ci_date = $check_in_array[0];
	
			$check_out = $check_out;
			$check_out_array = explode (' ',$check_out);
			$co_date = $check_out_array[0];
			
			$nights = (strtotime($co_date) - strtotime($ci_date)) / (60 * 60 * 24);
		
			$data['room_info'] = $room_info; 
			$data['room_type_info'] = $room_type_info; 
			$data['check_in'] = $check_in; 
			$data['check_out'] = $check_out; 
			$data['nights'] = $nights; 
			
			$this->load->view('reservations/reservation_create_3_view', $data);
		}
		else
		{
			//$reservation_rate = set_value('reservation_rate');
			$reservation_adults = set_value('reservation_adults');
			$reservation_children = set_value('reservation_children');
			$reservation_details = set_value('reservation_details');
			
		/*
			$data = array(
				'STATUS' => 
				'RES_DATE' => 
				'CHECK_IN' =>
				'CHECK_OUT' => 
				'PAYMENT_STAT' => 
				'DETAILS' => 
				'FK_ID_GUEST' => 
				);
			
			$this->GM->update('GUEST', 'ID_GUEST', $guest_id, $data);  
				
			$this->info_guest_reservations($guest_id); 
			*/
			
		}
	}
	
	
	/*
	function modify_reservation_rooms($reservation_id, $room_id)
	{
		//$reservation = $this->GM->get_info('RESERVATION', 'ID_RESERVATION', $reservation_id, null, null, null, 1);
		$reservation_rooms = $this->REM->get_reservation_room('ID_ROOM', $room_id, null);
		
		//$data['reservation'] = $reservation; 
		$data['reservation_rooms'] = $reservation_rooms; 
		
		$this->load->view('reservations/reservation_modify_rooms_view', $data);
	}
	*/
	
	
	
	
	
	






}
?>