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
	
	
	function viewRooms()
	{
		//$order = $_POST["order"];
		
		$order = 'NUMBER';
	
		$rooms = $this->GM->getInfo('ROOM', null, null, $order, null, null, 1);
		$roomsCount        = $this->GM->getCount('ROOM', null,     null,             null, null);
		$roomsCountRunning = $this->GM->getCount('ROOM', 'STATUS', 'Running',        null, null);
		$roomsCountOos     = $this->GM->getCount('ROOM', 'STATUS', 'Out of service', null, null);
		
		$data['rooms'] = $rooms;
		$data['roomsCount'] = $roomsCount;
		$data['roomsCountOos'] = $roomsCountOos;
		$data['roomsCountRunning'] = $roomsCountRunning;
		
		$this->load->view('pms/rooms/rooms_view', $data);
	}
	
	
	function viewRoomTypes()
	{
		//$order = $_POST["order"];
		$order = NULL;
		
		$roomTypes = $this->GM->getInfo('ROOM_TYPE', null, null, $order, null, null, 1);
		$roomTypesCount = $this->GM->getCount('ROOM_TYPE', null, null, null, null);
		
		$data['roomTypes'] = $roomTypes;
		$data['roomTypesCount'] = $roomTypesCount;
		
		$this->load->view('pms/rooms/room_types_view', $data);
	}
	
	
	function infoRoom($roomId)
	{
		//$order = $_POST["order"];
		
		$order = 'RE.CHECK_IN DESC';
		
		$room  = $this->GM->getInfo('ROOM', 'ID_ROOM', $roomId, null, null, null, 1);
		$guest = $this->GM->getInfo('GUEST', null,     null,    null, null, null, null);
		$roomReservations = $this->RM->getReservationRoomGuest('RO.ID_ROOM', $roomId, $order);
		
		$data['room'] = $room;
		$data['guest'] = $guest;
		$data['roomReservations'] = $roomReservations;
		
		$this->load->view('pms/rooms/room_info_view', $data);
	}
	
	
	function infoRoomType($roomTypeId)
	{
		$roomType = $this->GM->getInfo('ROOM_TYPE', 'ID_ROOM_TYPE', $roomTypeId, null, null, null, 1);
		$guest    = $this->GM->getInfo('GUEST',     null,           null,        null, null, null, null);
		$roomTypeCount        = $this->GM->getCount('ROOM', 'FK_ID_ROOM_TYPE', $roomTypeId,  null,     null);
		$roomTypeCountRunning = $this->GM->getCount('ROOM', 'FK_ID_ROOM_TYPE', $roomTypeId, 'STATUS', 'Running');
		$roomTypeCountOos     = $this->GM->getCount('ROOM', 'FK_ID_ROOM_TYPE', $roomTypeId, 'STATUS', 'Out of service');
		$roomTypeReservations = $this->RM->getReservationRoomGuest('RT.ID_ROOM_TYPE', $roomTypeId, 'RE.CHECK_IN DESC');
	
		$data['roomType'] = $roomType;
		$data['guest'] = $guest;
		$data['roomTypeCount'] = $roomTypeCount;
		$data['roomTypeCountRunning'] = $roomTypeCountRunning;
		$data['roomTypeCountOos'] = $roomTypeCountOos;
		$data['roomTypeReservations'] = $roomTypeReservations;
		
		$this->load->view('pms/rooms/room_type_info_view', $data);
	}
	
	
	function addRoom()
	{
		$this->form_validation->set_rules('room_number', 'lang:number', 'required|max_length[20]|callback_check_room_number');
		$this->form_validation->set_rules('room_name', 'lang:name', 'max_length[50]');
		$this->form_validation->set_rules('room_status', 'lang:status', 'required|max_length[20]');
		$this->form_validation->set_rules('room_room_type','lang:room_type','required|max_length[20]');
		
		if ($this->form_validation->run() == FALSE) {
		
			$maxRoomNumber = $this->GM->getMax('ROOM', 'NUMBER');
			$roomTypes = $this->GM->getInfo('ROOM_TYPE', null, null, null, null, null, 1);
		
			$data['maxRoomNumber'] = $maxRoomNumber;
			$data['roomTypes'] = $roomTypes;
		
			$this->load->view('pms/rooms/room_add_view', $data);
			
		} else {
		
			$hotel = $this->GM->getInfo('HOTEL', null, null, null, null, null, 1);
			
			foreach ($hotel as $row) {
				$hotelId = $row['ID_HOTEL'];
			}
			
			$roomNumber   = set_value('room_number');
			$roomName     = set_value('room_name');
			$roomStatus   = set_value('room_status');
			$roomRoomType = set_value('room_room_type');
			
			$data = array(
				'NUMBER'          => $roomNumber,
				'NAME'            => ucwords(strtolower($roomName)),
				'STATUS'          => $roomStatus,
				'FK_ID_HOTEL'     => $hotelId,
				'FK_ID_ROOM_TYPE' => $roomRoomType
				);
			
			$this->GM->insert('ROOM', $data);  
				
			$this->viewRooms(); 
		}	
	}
	
	
	function addRoomType()
	{
		$this->form_validation->set_rules('room_type_name', 'lang:name','required|max_length[50]|callback_check_room_type_name');
		$this->form_validation->set_rules('room_type_abrv', 'lang:abrv', 'max_length[5]|callback_check_room_type_abrv');
		$this->form_validation->set_rules('room_type_beds', 'lang:beds', 'required|numeric|max_length[5]');
		$this->form_validation->set_rules('room_type_sleeps', 'lang:sleeps', 'required|numeric|max_length[5]');
		$this->form_validation->set_rules('room_type_details', 'lang:details', 'max_length[300]');
			
		if ($this->form_validation->run() == FALSE) {
		
			$this->load->view('pms/rooms/room_type_add_view');
			
		} else {
		
			$roomTypeName    = set_value('room_type_name');
			$roomTypeAbrv    = set_value('room_type_abrv');
			$roomTypeBeds    = set_value('room_type_beds');
			$roomTypeSleeps  = set_value('room_type_sleeps');
			$roomTypeDetails = set_value('room_type_details');
			
			$data = array(
				'NAME'    => ucwords(strtolower($roomTypeName)),
				'ABRV'    => strtoupper($roomTypeAbrv),
				'BEDS'    => $roomTypeBeds,
				'SLEEPS'  => $roomTypeSleeps,
				'DETAILS' => $roomTypeDetails,
				);
			
			$this->GM->insert('ROOM_TYPE', $data);  
				
			$this->viewRoomTypes(); 
		}
	}
	
	
	function editRoom($roomId)
	{
		$this->form_validation->set_rules('room_number','lang:number','required|max_length[20]|callback_check_room_number');
		$this->form_validation->set_rules('room_name','lang:name','max_length[50]');
		$this->form_validation->set_rules('room_status','lang:status','required|max_length[20]');
		$this->form_validation->set_rules('room_room_type','lang:room_type','required|max_length[20]');
		
		if ($this->form_validation->run() == FALSE) {
		
			$room      = $this->GM->getInfo('ROOM',     'ID_ROOM', $roomId, null, null, null, 1);
			$roomTypes = $this->GM->getInfo('ROOM_TYPE', null,     null,    null, null, null, 1);
		
			$data['room'] = $room;
			$data['roomTypes'] = $roomTypes;
		
			$this->load->view('pms/rooms/room_edit_view', $data);
			
		}else{
		
			$roomNumber   = set_value('room_number');
			$roomName     = set_value('room_name');
			$roomStatus   = set_value('room_status');
			$roomRoomType = set_value('room_room_type');
			
			$data = array(
				'NUMBER'          => $roomNumber,
				'NAME'            => ucwords(strtolower($roomName)),
				'STATUS'          => $roomStatus,
				'FK_ID_ROOM_TYPE' => $roomRoomType
				);
			
			$this->GM->update('ROOM', 'ID_ROOM', $roomId, $data);  
				
			$this->infoRoom($roomId); 
		}	
	}
	
	
	function editRoomType($roomTypeId)
	{
		$this->form_validation->set_rules('room_type_name','lang:name','required|max_length[50]|callback_check_room_type_name');
		$this->form_validation->set_rules('room_type_abrv','lang:abrv','max_length[5]|callback_check_room_type_abrv');
		$this->form_validation->set_rules('room_type_beds','lang:beds','required|numeric|max_length[5]');
		$this->form_validation->set_rules('room_type_sleeps','lang:sleeps','required|numeric|max_length[5]');
		$this->form_validation->set_rules('room_type_details','lang:details','max_length[300]');
		
		if ($this->form_validation->run() == FALSE) {
		
			$roomType = $this->GM->getInfo('ROOM_TYPE', 'ID_ROOM_TYPE', $roomTypeId, null, null, null, 1);
			
			$data['roomType'] = $roomType;
			
			$this->load->view('pms/rooms/room_type_edit_view', $data);
			
		} else {
		
			$roomTypeName    = set_value('room_type_name');
			$roomTypeAbrv    = set_value('room_type_abrv');
			$roomTypeBeds    = set_value('room_type_beds');
			$roomTypeSleeps  = set_value('room_type_sleeps');
			$roomTypeDetails = set_value('room_type_details');
			
			$data = array(
				'NAME'    => ucwords(strtolower($roomTypeName)),
				'ABRV'    => strtoupper($roomTypeAbrv),
				'BEDS'    => $roomTypeBeds,
				'SLEEPS'  => $roomTypeSleeps,
				'DETAILS' => $roomTypeDetails
				);
			
			$this->GM->update('ROOM_TYPE', 'ID_ROOM_TYPE', $roomTypeId, $data);  
				
			$this->infoRoomType($roomTypeId); 
		}
	}
	
	
	function deleteRoom($roomId)
	{
		$roomReservation = $this->RM->getReservationRoomGuest('RO.ID_ROOM', $roomId, null);
		
		$datestring = "%Y-%m-%d  %h:%i %a";
		$time = time();
		$date = mdate($datestring, $time);
		
		$delete = 'Yes';
		$iniResNum = array();
		
		foreach ($roomReservation as $row) {
		
		 	$resNum   = $row['ID_RESERVATION'];
			$checkIn  = $row['CHECK_IN'];
			$checkOut = $row['CHECK_OUT'];
			$status   = $row['STATUS'];
			
			if (($checkIn > $date || $checkOut > $date) && ($status != 'Canceled') && ($status != 'No Show')){
			
                $delete = 'No';
				
				$newResNum = array ($resNum);
				$resultado = array_merge($iniResNum, $newResNum);
				$iniResNum = $resultado;
			}
		}
		
		if ($delete == 'No') {
		
			echo 'No se puede eliminar porque tiene reservaciones pendientes: '."<br>";
			foreach ($resultado as $actual)
    		echo '# ', $actual . "<br>";
			$this->infoRoom($roomId);
			
		} else {
		
			$this->GM->disable('ROOM', 'ID_ROOM', $roomId);  
			$this->viewRooms(); 
		}	
	}
	
	
	function deleteRoomType($roomTypeId)
	{
		$roomTypeReservation = $this->RM->getReservationRoomGuest('RT.ID_ROOM_TYPE', $roomTypeId, null);
		
		$datestring = "%Y-%m-%d  %h:%i %a";
		$time = time();
		$date = mdate($datestring, $time);
		
		$delete = 'Yes';
		$iniResNum = array();
		
		foreach ($roomTypeReservation as $row) {
		
			$resNum   = $row['ID_RESERVATION'];
			$checkIn  = $row['CHECK_IN'];
			$checkOut = $row['CHECK_OUT'];
			$status   = $row['STATUS'];
			
			if (($checkIn > $date || $checkOut > $date) && ($status != 'Canceled') && ($status != 'No Show')) {
				
				$delete = 'No';
				
				$newResNum = array ($resNum);
				$resultado = array_merge($iniResNum, $newResNum);
				$iniResNum = $resultado;
			}
		}
		
		if ($delete == 'No') {
		
			echo 'No se puede eliminar porque tiene reservaciones pendientes: '."<br>";
			foreach ($resultado as $actual)
    		echo '# ', $actual . "<br>"; 
			$this->infoRoomType($roomTypeId);
			
		} else {
		
			$this->GM->disable('ROOM_TYPE', 'ID_ROOM_TYPE',    $roomTypeId); 
			$this->GM->disable('ROOM',      'FK_ID_ROOM_TYPE', $roomTypeId);   
			$this->viewRoomTypes(); 
		}	
	}
	
	
	function checkRoomNumber($str)
	{
		$roomId = $this->uri->segment(3);
		
		$rooms = $this->GM->validationCheck('ROOM', 'NUMBER', $str, 'ID_ROOM !=', $roomId);

		if ($rooms) {
		
			$this->form_validation->set_message('check_room_number', 'Número de habitación no disponible');
			return FALSE;
			
		} else {
		
			return TRUE;
		}
	}
	
	function checkRoomTypeName($str)
	{
		$roomTypeId = $this->uri->segment(3);
		
		$roomTypes = $this->GM->validationCheck('ROOM_TYPE', 'NAME', $str, 'ID_ROOM_TYPE !=', $roomTypeId);

		if ($roomTypes) {
		
			$this->form_validation->set_message('check_room_type_name', 'Nombre de tipo de habitación no disponible');
			return FALSE;
			
		} else {
		
			return TRUE;
		}
	}
	
	function checkRoomTypeAbrv($str)
	{
		if ($str == NULL){
		
			return TRUE;
			
		} else {
		
			$roomTypeId = $this->uri->segment(3);
		
			$roomTypes = $this->GM->validationCheck('ROOM_TYPE', 'ABRV', $str, 'ID_ROOM_TYPE !=', $roomTypeId);

			if ($roomTypes) {
				$this->form_validation->set_message('check_room_type_abrv', 'Abrev. no disponible');
				return FALSE;
				
			} else {
			
				return TRUE;
			}
		}
	}
	
	
	
	
	






}
?>