<?php

class Rooms extends Controller
{
	function Rooms()
	{
		parent::Controller();
		$this->load->model('general_model','GM');
		$this->load->model('rooms_reservations_model','RM');
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
		
		$order = 'number';
	
		$rooms             = $this->GM->getInfo('ROOM', null, null, $order, null, null, 1);
		$roomsCount        = $this->GM->getCount('ROOM', null,     null,             null, null, 1);
		$roomsCountRunning = $this->GM->getCount('ROOM', 'status', 'Running',        null, null, 1);
		$roomsCountOos     = $this->GM->getCount('ROOM', 'status', 'Out of service', null, null, 1);
		
		$data['rooms']             = $rooms;
		$data['roomsCount']        = $roomsCount;
		$data['roomsCountOos']     = $roomsCountOos;
		$data['roomsCountRunning'] = $roomsCountRunning;
		
		$this->load->view('pms/rooms/rooms_view', $data);
	}
	
	
	function viewRoomTypes()
	{
		//$order = $_POST["order"];
		$order = NULL;
		
		$roomTypes      = $this->GM->getInfo('ROOM_TYPE', null, null, $order, null, null, 1);
		$roomTypesCount = $this->GM->getCount('ROOM_TYPE', null, null, null, null, 1);
		
		$data['roomTypes']      = $roomTypes;
		$data['roomTypesCount'] = $roomTypesCount;
		
		$this->load->view('pms/rooms/room_types_view', $data);
	}
	
	
	function infoRoom($roomId)
	{
		//$order = $_POST["order"];
		
		$order = 'RE.checkIn DESC';
		
		$guest            = $this->GM->getInfo('GUEST', null,     null,    null, null, null, null);
		$room             = $this->GM->getInfo('ROOM', 'id_room', $roomId, null, null, null, 1);
		$roomReservations = $this->RM->getReservationRoomGuest('RO.id_room', $roomId, $order);
		
		$data['guest']            = $guest;
		$data['room']             = $room;
		$data['roomReservations'] = $roomReservations;
		
		$this->load->view('pms/rooms/room_info_view', $data);
	}
	
	
	function infoRoomType($roomTypeId)
	{
		$roomType             = $this->GM->getInfo('ROOM_TYPE', 'id_room_type', $roomTypeId, null, null, null, 1);
		$guest                = $this->GM->getInfo('GUEST',     null,           null,        null, null, null, null);
		$roomTypeCount        = $this->GM->getCount('ROOM', 'fk_room_type', $roomTypeId,  null,     null,            1);
		$roomTypeCountRunning = $this->GM->getCount('ROOM', 'fk_room_type', $roomTypeId, 'status', 'Running',        1);
		$roomTypeCountOos     = $this->GM->getCount('ROOM', 'fk_room_type', $roomTypeId, 'status', 'Out of service', 1);
		$roomTypeReservations = $this->RM->getReservationRoomGuest('RT.id_room_type', $roomTypeId, 'RE.checkIn DESC');
	
		$data['roomType']             = $roomType;
		$data['guest']                = $guest;
		$data['roomTypeCount']        = $roomTypeCount;
		$data['roomTypeCountRunning'] = $roomTypeCountRunning;
		$data['roomTypeCountOos']     = $roomTypeCountOos;
		$data['roomTypeReservations'] = $roomTypeReservations;
		
		$this->load->view('pms/rooms/room_type_info_view', $data);
	}
	
	
	function addRoom()
	{
		$this->form_validation->set_rules('room_number', 'lang:number', 'required|max_length[20]|callback_checkRoomNumber');
		$this->form_validation->set_rules('room_name', 'lang:name', 'max_length[50]');
		$this->form_validation->set_rules('room_status', 'lang:status', 'required|max_length[20]');
		$this->form_validation->set_rules('room_room_type','lang:room_type','required|max_length[20]');
		
		if ($this->form_validation->run() == FALSE) {
		
			$maxRoomNumber = $this->GM->getMax('ROOM', 'number');
			$roomTypes     = $this->GM->getInfo('ROOM_TYPE', null, null, null, null, null, 1);
		
			$data['maxRoomNumber'] = $maxRoomNumber;
			$data['roomTypes']     = $roomTypes;
		
			$this->load->view('pms/rooms/room_add_view', $data);
			
		} else {
		
			//$hotel = $this->GM->getInfo('HOTEL', null, null, null, null, null, 1);
			
			//foreach ($hotel as $row) {
			
				//$hotelId = $row['id_hotel'];
			//}
			
			$hotelId = 1;
			
			$roomNumber   = set_value('room_number');
			$roomName     = set_value('room_name');
			$roomStatus   = set_value('room_status');
			$roomRoomType = set_value('room_room_type');
			
			$data = array(
				'number'       => $roomNumber,
				'name'         => ucwords(strtolower($roomName)),
				'status'       => $roomStatus,
				'fk_hotel'     => $hotelId,
				'fk_room_type' => $roomRoomType
				);
			
			$this->GM->insert('ROOM', $data);  
				
			$this->viewRooms(); 
		}	
	}
	
	
	function addRoomType()
	{
		$this->form_validation->set_rules('room_type_name', 'lang:name','required|max_length[50]|callback_checkRoomTypeName');
		$this->form_validation->set_rules('room_type_abrv', 'lang:abrv', 'max_length[5]|callback_checkRoomTypeAbrv');
		$this->form_validation->set_rules('room_type_paxStd', 'lang:paxStd', 'required|numeric|max_length[5]');
		$this->form_validation->set_rules('room_type_paxMax', 'lang:paxMax', 'required|numeric|max_length[5]');
		$this->form_validation->set_rules('room_type_beds', 'lang:beds', 'required|numeric|max_length[5]');
		$this->form_validation->set_rules('room_type_description', 'lang:description', 'max_length[300]');
			
		if ($this->form_validation->run() == FALSE) {
		
			$this->load->view('pms/rooms/room_type_add_view');
			
		} else {
		
			$roomTypeName        = set_value('room_type_name');
			$roomTypeAbrv        = set_value('room_type_abrv');
			$roomTypePaxStd      = set_value('room_type_paxStd');
			$roomTypePaxMax      = set_value('room_type_paxMax');
			$roomTypeBeds        = set_value('room_type_beds');
			$roomTypeDescription = set_value('room_type_description');
			
			if ($roomTypePaxStd > $roomTypePaxMax) {
			
			    $error = lang(errorPaxStd_PaxMax);
			    $data['error'] = $error;
			    $this->load->view('pms/rooms/room_type_add_view', $data);
			
			} else if ($roomTypePaxMax < $roomTypeBeds) {
			
			    $error = lang(errorPaxMax_Beds);
			    $data['error'] = $error;
			    $this->load->view('pms/rooms/room_type_add_view', $data);
			
			} else {
			
			    $data = array(
				    'name'        => ucwords(strtolower($roomTypeName)),
				    'abrv'        => strtoupper($roomTypeAbrv),
				    'paxStd'      => $roomTypePaxStd,
				    'paxMax'      => $roomTypePaxMax,
				    'beds'        => $roomTypeBeds,
				    'description' => $roomTypeDescription,
				    );
			
			    $this->GM->insert('ROOM_TYPE', $data);  
				
			    $this->viewRoomTypes(); 
			}
		}
	}
	
	
	function editRoom($roomId)
	{
		$this->form_validation->set_rules('room_number','lang:number','required|max_length[20]|callback_checkRoomNumber');
		$this->form_validation->set_rules('room_name','lang:name','max_length[50]');
		$this->form_validation->set_rules('room_status','lang:status','required|max_length[20]');
		$this->form_validation->set_rules('room_room_type','lang:room_type','required|max_length[20]');
		
		if ($this->form_validation->run() == FALSE) {
		
			$room      = $this->GM->getInfo('ROOM',     'id_room', $roomId, null, null, null, 1);
			$roomTypes = $this->GM->getInfo('ROOM_TYPE', null,     null,    null, null, null, 1);
		
			$data['room']      = $room;
			$data['roomTypes'] = $roomTypes;
		
			$this->load->view('pms/rooms/room_edit_view', $data);
			
		} else {
		
			$roomNumber   = set_value('room_number');
			$roomName     = set_value('room_name');
			$roomStatus   = set_value('room_status');
			$roomRoomType = set_value('room_room_type');
			
			$data = array(
				'number'       => $roomNumber,
				'name'         => ucwords(strtolower($roomName)),
				'status'       => $roomStatus,
				'fk_room_type' => $roomRoomType
				);
			
			$this->GM->update('ROOM', 'id_room', $roomId, $data);  
				
			$this->infoRoom($roomId); 
		}	
	}
	
	
	function editRoomType($roomTypeId)
	{
		$this->form_validation->set_rules('room_type_name','lang:name','required|max_length[50]|callback_checkRoomTypeName');
		$this->form_validation->set_rules('room_type_abrv','lang:abrv','max_length[5]|callback_checkRoomTypeAbrv');
		$this->form_validation->set_rules('room_type_paxStd','lang:paxStd','required|numeric|max_length[5]');
		$this->form_validation->set_rules('room_type_paxMax','lang:paxMax','required|numeric|max_length[5]');
		$this->form_validation->set_rules('room_type_beds','lang:beds','required|numeric|max_length[5]');
		$this->form_validation->set_rules('room_type_description','lang:description','max_length[300]');
		
		if ($this->form_validation->run() == FALSE) {
		
			$roomType = $this->GM->getInfo('ROOM_TYPE', 'id_room_type', $roomTypeId, null, null, null, 1);
			
			$data['roomType'] = $roomType;
			
			$this->load->view('pms/rooms/room_type_edit_view', $data);
			
		} else {
		
			$roomTypeName        = set_value('room_type_name');
			$roomTypeAbrv        = set_value('room_type_abrv');
			$roomTypePaxStd      = set_value('room_type_paxStd');
			$roomTypePaxMax      = set_value('room_type_paxMax');
			$roomTypeBeds        = set_value('room_type_beds');
			$roomTypeDescription = set_value('room_type_description');
			
			if ($roomTypePaxStd > $roomTypePaxMax) {
			
			    $error = lang(errorPaxStd_PaxMax);
			    $roomType = $this->GM->getInfo('ROOM_TYPE', 'id_room_type', $roomTypeId, null, null, null, 1);

			    $data['roomType'] = $roomType;
			    $data['error'] = $error;
			
			    $this->load->view('pms/rooms/room_type_edit_view', $data);
			
			} else if ($roomTypePaxMax < $roomTypeBeds) {
			
			    $error = lang(errorPaxStd_PaxMax);
			    $roomType = $this->GM->getInfo('ROOM_TYPE', 'id_room_type', $roomTypeId, null, null, null, 1);

			    $data['roomType'] = $roomType;
			    $data['error'] = $error;
			
			    $this->load->view('pms/rooms/room_type_edit_view', $data);
			
			} else {
			
			    $data = array(
				    'name'        => ucwords(strtolower($roomTypeName)),
				    'abrv'        => strtoupper($roomTypeAbrv),
					'paxStd'      => $roomTypePaxStd,
					'paxMax'      => $roomTypePaxMax,
				    'beds'        => $roomTypeBeds,
				    'description' => $roomTypeDescription
				    );
			
			    $this->GM->update('ROOM_TYPE', 'id_room_type', $roomTypeId, $data);  
				
			    $this->infoRoomType($roomTypeId); 
			}
		}
	}
	
	
	function deleteRoom($roomId)
	{
		$roomReservation = $this->RM->getReservationRoomGuest('RO.id_room', $roomId, null);
		
		$datestring = "%Y-%m-%d  %h:%i %a";
		$time       = time();
		$date       = mdate($datestring, $time);
		
		$delete    = 'Yes';
		$iniResNum = array();
		
		foreach ($roomReservation as $row) {
		
		 	$resNum   = $row['id_reservation'];
			$checkIn  = $row['checkIn'];
			$checkOut = $row['checkOut'];
			$status   = $row['status'];
			
			if (($checkIn > $date || $checkOut > $date) && ($status != 'Canceled') && ($status != 'No Show')){
			
                $delete = 'No';
				
				$newResNum = array ($resNum);
				$resultado = array_merge($iniResNum, $newResNum);
				$iniResNum = $resultado;
			}
		}
		
		if ($delete == 'No') {
		
			echo lang(errorPendingReservation)."<br>";
			foreach ($resultado as $actual)
    		echo '# ', $actual . "<br>";
			$this->infoRoom($roomId);
			
		} else {
		
			$this->GM->disable('ROOM', 'id_room', $roomId);  
			$this->viewRooms(); 
		}	
	}
	
	
	function deleteRoomType($roomTypeId)
	{
		$roomTypeReservation = $this->RM->getReservationRoomGuest('RT.id_room_type', $roomTypeId, null);
		
		$datestring = "%Y-%m-%d  %h:%i %a";
		$time       = time();
		$date       = mdate($datestring, $time);
		
		$delete    = 'Yes';
		$iniResNum = array();
		
		foreach ($roomTypeReservation as $row) {
		
			$resNum   = $row['id_reservation'];
			$checkIn  = $row['checkIn'];
			$checkOut = $row['checkOut'];
			$status   = $row['status'];
			
			if (($checkIn > $date || $checkOut > $date) && ($status != 'Canceled') && ($status != 'No Show')) {
				
				$delete = 'No';
				
				$newResNum = array ($resNum);
				$resultado = array_merge($iniResNum, $newResNum);
				$iniResNum = $resultado;
			}
		}
		
		if ($delete == 'No') {
		
			echo lang(errorPendingReservation)."<br>";
			foreach ($resultado as $actual)
    		echo '# ', $actual . "<br>"; 
			$this->infoRoomType($roomTypeId);
			
		} else {
		
			$this->GM->disable('ROOM_TYPE', 'id_room_type', $roomTypeId); 
			$this->GM->disable('ROOM',      'fk_room_type', $roomTypeId);   
			$this->viewRoomTypes(); 
		}	
	}
	
	
	function checkRoomNumber($str)
	{
		$roomId = $this->uri->segment(3);
		
		$rooms = $this->GM->validationCheck('ROOM', 'number', $str, 'id_room !=', $roomId, 1);

		if ($rooms) {
		
			$this->form_validation->set_message('checkRoomNumber', lang(errorRoomNumber));
			return FALSE;
			
		} else {
		
			return TRUE;
		}
	}
	
	function checkRoomTypeName($str)
	{
		$roomTypeId = $this->uri->segment(3);
		
		$roomTypes = $this->GM->validationCheck('ROOM_TYPE', 'name', $str, 'id_room_type !=', $roomTypeId, 1);

		if ($roomTypes) {
		
			$this->form_validation->set_message('checkRoomTypeName', lang(errorRoomTypeName));
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
		
			$roomTypes = $this->GM->validationCheck('ROOM_TYPE', 'abrv', $str, 'id_room_type !=', $roomTypeId, 1);

			if ($roomTypes) {
			
				$this->form_validation->set_message('checkRoomTypeAbrv', lang(errorAbrv));
				return FALSE;
				
			} else {
			
				return TRUE;
			}
		}
	}
	
	
	
	
	






}
?>