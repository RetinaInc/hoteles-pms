<?php

class Rooms extends Controller
{
	function Rooms()
	{
		parent::Controller();
		$this->load->model('general_model','GM');
		$this->load->model('rooms_model','RM');
		$this->lang->load ('form_validation','spanish');
		$this->load->library('pagination');
		$this->load->library('form_validation');
		$this->load->helper('language');
		$this->load->helper('form');
		$this->load->helper('date');
		$this->load->helper('url');
	}
	
	function index()
	{
		echo 'room controller';
	}
	
	
	function view_rooms()
	{
		//$order = $_POST["order"];
		
		$order = 'NUMBER';
	
		$rooms = $this->GM->get_info('ROOM', null, null, $order, null, null, 1);
		$rooms_count = $this->GM->get_count('ROOM', null, null, null, null);
		$rooms_count_running = $this->GM->get_count('ROOM', 'STATUS', 'Running', null, null);
		$rooms_count_oos = $this->GM->get_count('ROOM', 'STATUS', 'Out of service', null, null);
		
		$data['rooms'] = $rooms;
		$data['rooms_count'] = $rooms_count;
		$data['rooms_count_oos'] = $rooms_count_oos;
		$data['rooms_count_running'] = $rooms_count_running;
		
		$this->load->view('rooms/rooms_view', $data);
	}
	
	
	function view_room_types()
	{
		//$order = $_POST["order"];
		$order = NULL;
		
		$room_types = $this->GM->get_info('ROOM_TYPE', null, null, $order, null, null, 1);
		$room_types_count = $this->GM->get_count('ROOM_TYPE', null, null, null, null);
		
		$data['room_types'] = $room_types;
		$data['room_types_count'] = $room_types_count;
		
		$this->load->view('rooms/room_types_view', $data);
	}
	
	
	function info_room($room_id)
	{
		//$order = $_POST["order"];
		
		$order = 'RE.CHECK_IN DESC';
		
		$room = $this->GM->get_info('ROOM', 'ID_ROOM', $room_id, null, null, null, 1);
		$room_reservations = $this->RM->get_reservation_room_guest('RO.ID_ROOM', $room_id, $order);
		$guest = $this->GM->get_info('GUEST', null, null, null, null, null, null);
		
		$data['room'] = $room;
		$data['room_reservations'] = $room_reservations;
		$data['guest'] = $guest;
		
		$this->load->view('rooms/room_info_view', $data);
	}
	
	
	function info_room_type($room_type_id)
	{
		$room_type = $this->GM->get_info('ROOM_TYPE', 'ID_ROOM_TYPE', $room_type_id, null, null, null, 1);
		$room_type_count = $this->GM->get_count('ROOM', 'FK_ID_ROOM_TYPE', $room_type_id, null, null);
		$room_type_count_running = $this->GM->get_count('ROOM', 'FK_ID_ROOM_TYPE', $room_type_id, 'STATUS', 'Running');
		$room_type_count_oos = $this->GM->get_count('ROOM', 'FK_ID_ROOM_TYPE', $room_type_id, 'STATUS', 'Out of service');
		$room_type_reservations = $this->RM->get_reservation_room_guest('RT.ID_ROOM_TYPE', $room_type_id, 'RE.CHECK_IN DESC');
		$guest = $this->GM->get_info('GUEST', null, null, null, null, null, null);
	
		$data['room_type'] = $room_type;
		$data['room_type_count'] = $room_type_count;
		$data['room_type_count_running'] = $room_type_count_running;
		$data['room_type_count_oos'] = $room_type_count_oos;
		$data['room_type_reservations'] = $room_type_reservations;
		$data['guest'] = $guest;
		
		$this->load->view('rooms/room_type_info_view', $data);
	}
	
	
	function add_room()
	{
		$this->form_validation->set_rules('room_number','lang:number','required|max_length[20]|callback_check_room_number');
		$this->form_validation->set_rules('room_name','lang:name','max_length[50]');
		$this->form_validation->set_rules('room_status','lang:status','required|max_length[20]');
		$this->form_validation->set_rules('room_room_type','lang:room_type','required|max_length[20]');
		
		if ($this->form_validation->run() == FALSE)
		{
			$max_room_number = $this->GM->get_max('ROOM', 'NUMBER');
			$room_types = $this->GM->get_info('ROOM_TYPE', $field = null, $value = null, null, null, null, 1);
		
			$data['room_types'] = $room_types;
			$data['max_room_number'] = $max_room_number;
		
			$this->load->view('rooms/room_add_view', $data);
		}
		else
		{
			$hotel = $this->GM->get_info('HOTEL', $field = null, $value = null, null, null, null, 1);
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
	
	
	function add_room_type()
	{
		$this->form_validation->set_rules('room_type_name','lang:name','required|max_length[50]|callback_check_room_type_name');
		$this->form_validation->set_rules('room_type_abrv','lang:abrv','max_length[5]|callback_check_room_type_abrv');
		$this->form_validation->set_rules('room_type_beds','lang:beds','required|numeric|max_length[5]');
		$this->form_validation->set_rules('room_type_sleeps','lang:sleeps','required|numeric|max_length[5]');
		$this->form_validation->set_rules('room_type_details','lang:details','max_length[300]');
			
		if ($this->form_validation->run() == FALSE)
		{
			$this->load->view('rooms/room_type_add_view');
		}
		else
		{
			$room_type_name = set_value('room_type_name');
			$room_type_abrv = set_value('room_type_abrv');
			$room_type_beds = set_value('room_type_beds');
			$room_type_sleeps = set_value('room_type_sleeps');
			$room_type_details = set_value('room_type_details');
			
			$data = array(
				'NAME' => ucwords(strtolower($room_type_name)),
				'ABRV' => strtoupper($room_type_abrv),
				'BEDS' => $room_type_beds,
				'SLEEPS' => $room_type_sleeps,
				'DETAILS' => $room_type_details
				);
			
			$this->GM->insert('ROOM_TYPE', $data);  
				
			$this->view_room_types(); 
		}
		
	}
	
	
	function edit_room($room_id)
	{
		$this->form_validation->set_rules('room_number','lang:number','required|max_length[20]|callback_check_room_number');
		$this->form_validation->set_rules('room_name','lang:name','max_length[50]');
		$this->form_validation->set_rules('room_status','lang:status','required|max_length[20]');
		$this->form_validation->set_rules('room_room_type','lang:room_type','required|max_length[20]');
		
		if ($this->form_validation->run() == FALSE)
		{
			$room = $this->GM->get_info('ROOM', 'ID_ROOM', $room_id, null, null, null, 1);
			$room_types = $this->GM->get_info('ROOM_TYPE', $field = null, $value = null, null, null, null, 1);
		
			$data['room'] = $room;
			$data['room_types'] = $room_types;
		
			$this->load->view('rooms/room_edit_view', $data);
		}
		else
		{
			$room_number = set_value('room_number');
			$room_name = set_value('room_name');
			$room_status = set_value('room_status');
			$room_room_type = set_value('room_room_type');
			
			$data = array(
				'NUMBER' => $room_number,
				'NAME' => ucwords(strtolower($room_name)),
				'STATUS' => $room_status,
				'FK_ID_ROOM_TYPE' => $room_room_type
				);
			
			$this->GM->update('ROOM', 'ID_ROOM', $room_id, $data);  
				
			$this->info_room($room_id); 
		}
		
	}
	
	
	function edit_room_type($room_type_id)
	{
		$this->form_validation->set_rules('room_type_name','lang:name','required|max_length[50]|callback_check_room_type_name');
		$this->form_validation->set_rules('room_type_abrv','lang:abrv','max_length[5]|callback_check_room_type_abrv');
		$this->form_validation->set_rules('room_type_beds','lang:beds','required|numeric|max_length[5]');
		$this->form_validation->set_rules('room_type_sleeps','lang:sleeps','required|numeric|max_length[5]');
		$this->form_validation->set_rules('room_type_details','lang:details','max_length[300]');
		
		if ($this->form_validation->run() == FALSE)
		{
			$room_type = $this->GM->get_info('ROOM_TYPE', 'ID_ROOM_TYPE', $room_type_id, null, null, null, 1);
			
			$data['room_type'] = $room_type;
			
			$this->load->view('rooms/room_type_edit_view', $data);
		}
		else
		{
			$room_type_name = set_value('room_type_name');
			$room_type_abrv = set_value('room_type_abrv');
			$room_type_beds = set_value('room_type_beds');
			$room_type_sleeps = set_value('room_type_sleeps');
			$room_type_details = set_value('room_type_details');
			
			$data = array(
				'NAME' => ucwords(strtolower($room_type_name)),
				'ABRV' => strtoupper($room_type_abrv),
				'BEDS' => $room_type_beds,
				'SLEEPS' => $room_type_sleeps,
				'DETAILS' => $room_type_details
				);
			
			$this->GM->update('ROOM_TYPE', 'ID_ROOM_TYPE', $room_type_id, $data);  
				
			$this->info_room_type($room_type_id); 
		}
		
	}
	
	
	function delete_room($room_id)
	{
		$room_reservation = $this->RM->get_reservation_room_guest('RO.ID_ROOM', $room_id, null);
		
		$datestring = "%Y-%m-%d  %h:%i %a";
		$time = time();
		$date = mdate($datestring, $time);
		
		$delete = 'Yes';
		$ini_res_num = array();
		
		foreach ($room_reservation as $row)
		{
		 	$res_num = $row['ID_RESERVATION'];
			$check_in = $row['CHECK_IN'];
			$check_out = $row['CHECK_OUT'];
			$status = $row['STATUS'];
			
			if (($check_in > $date || $check_out > $date) && ($status != 'Canceled') && ($status != 'No Show'))
			{
				$delete = 'No';
				
				$new_res_num = array ($res_num);
				$resultado = array_merge($ini_res_num, $new_res_num);
				$ini_res_num = $resultado;
			}
		}
		
		if ($delete == 'No')
		{
			echo 'No se puede eliminar porque tiene reservaciones pendientes: '."<br>";
			foreach ($resultado as $actual)
    		echo '# ',$actual . "<br>";
			$this->info_room($room_id);
		}
		else
		{
			$this->GM->disable('ROOM', 'ID_ROOM', $room_id);  
			$this->view_rooms(); 
		}	
	}
	
	
	function delete_room_type($room_type_id)
	{
		$room_type_reservation = $this->RM->get_reservation_room_guest('RT.ID_ROOM_TYPE', $room_type_id, null);
		
		$datestring = "%Y-%m-%d  %h:%i %a";
		$time = time();
		$date = mdate($datestring, $time);
		
		$delete = 'Yes';
		$ini_res_num = array();
		
		foreach ($room_type_reservation as $row)
		{
			$res_num = $row['ID_RESERVATION'];
			$check_in = $row['CHECK_IN'];
			$check_out = $row['CHECK_OUT'];
			$status = $row['STATUS'];
			
			if (($check_in > $date || $check_out > $date) && ($status != 'Canceled') && ($status != 'No Show'))
			{
				$delete = 'No';
				
				$new_res_num = array ($res_num);
				$resultado = array_merge($ini_res_num, $new_res_num);
				$ini_res_num = $resultado;
				
			}
		}
		
		if ($delete == 'No')
		{
			echo 'No se puede eliminar porque tiene reservaciones pendientes: '."<br>";
			foreach ($resultado as $actual)
    		echo '# ',$actual . "<br>"; 
			$this->info_room_type($room_type_id);
		}
		else
		{
			$this->GM->disable('ROOM_TYPE', 'ID_ROOM_TYPE', $room_type_id); 
			$this->GM->disable('ROOM', 'FK_ID_ROOM_TYPE', $room_type_id);   
			$this->view_room_types(); 
		}	
	}
	
	
	function check_room_number($str)
	{
		$room_id = $this->uri->segment(3);
		
		$rooms = $this->GM->validation_check('ROOM', 'NUMBER', $str, 'ID_ROOM !=', $room_id);

		if ($rooms)
		{
			$this->form_validation->set_message('check_room_number', 'Número de habitación no disponible');
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}
	
	function check_room_type_name($str)
	{
		$room_type_id = $this->uri->segment(3);
		
		$room_types = $this->GM->validation_check('ROOM_TYPE', 'NAME', $str, 'ID_ROOM_TYPE !=', $room_type_id);

		if ($room_types)
		{
			$this->form_validation->set_message('check_room_type_name', 'Nombre de tipo de habitación no disponible');
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}
	
	function check_room_type_abrv($str)
	{
		if ($str == NULL)
		{
			return TRUE;
		}
		else
		{
			$room_type_id = $this->uri->segment(3);
		
			$room_types = $this->GM->validation_check('ROOM_TYPE', 'ABRV', $str, 'ID_ROOM_TYPE !=', $room_type_id);

			if ($room_types)
			{
				$this->form_validation->set_message('check_room_type_abrv', 'Abrev. no disponible');
				return FALSE;
			}
			else
			{
				return TRUE;
			}
		}
	}
	
	
	
	
	






}
?>