<?php

class Rooms extends Controller
{
	function Rooms()
	{
		parent::Controller();
		$this->load->model('rooms_model','ROM');
		$this->load->model('general_model','GNM');
		$this->lang->load ('form_validation','spanish');
		$this->load->library('pagination');
		$this->load->library('form_validation');
		$this->load->library('session');
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
		$hotel = $this->session->userdata('hotelid');
	
		$rooms             = $this->ROM->getRoomInfo($hotel, null, null, $order, null, null, 1);
		$roomsCount        = $this->ROM->getRoomCount($hotel, null,     null,             null, null, 1);
		$roomsCountRunning = $this->ROM->getRoomCount($hotel, 'status', 'Running',        null, null, 1);
		$roomsCountOos     = $this->ROM->getRoomCount($hotel, 'status', 'Out of service', null, null, 1);
		
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
		$hotel = $this->session->userdata('hotelid');
		
		$roomTypes      = $this->GNM->getInfo($hotel, 'ROOM_TYPE', null, null, $order, null, null, 1);
		$roomTypesCount = $this->GNM->getCount($hotel, 'ROOM_TYPE', null, null, null, null, 1);
		
		$data['roomTypes']      = $roomTypes;
		$data['roomTypesCount'] = $roomTypesCount;
		
		$this->load->view('pms/rooms/room_types_view', $data);
	}
	
	
	function infoRoom($roomId)
	{
		//$order = $_POST["order"];
		
		$order = 'RE.checkIn DESC';
		$hotel = $this->session->userdata('hotelid');
		
		$room             = $this->ROM->getRoomInfo($hotel, 'id_room', $roomId, null, null, null, 1);
		$roomReservations = $this->ROM->getRoomReservationsGuest($hotel, 'RO.id_room', $roomId, $order);
		
		$data['room']             = $room;
		$data['roomReservations'] = $roomReservations;
		
		$this->load->view('pms/rooms/room_info_view', $data);
	}
	
	
	function infoRoomType($roomTypeId)
	{
		$hotel = $this->session->userdata('hotelid');
			
		$roomType = $this->GNM->getInfo($hotel, 'ROOM_TYPE', 'id_room_type', $roomTypeId, null, null, null, 1);
		$roomTypeRoomCount        = $this->ROM->getRoomCount($hotel, 'fk_room_type', $roomTypeId,  null,     null,            1);
		$roomTypeRoomCountRunning = $this->ROM->getRoomCount($hotel, 'fk_room_type', $roomTypeId, 'status', 'Running',        1);
		$roomTypeRoomCountOos     = $this->ROM->getRoomCount($hotel, 'fk_room_type', $roomTypeId, 'status', 'Out of service', 1);
		$roomTypeReservations     = $this->ROM->getRoomReservationsGuest($hotel, 'RT.id_room_type', $roomTypeId, 'RE.checkIn DESC');
	
		$data['roomType'] = $roomType;
		$data['roomTypeRoomCount']        = $roomTypeRoomCount;
		$data['roomTypeRoomCountRunning'] = $roomTypeRoomCountRunning;
		$data['roomTypeRoomCountOos']     = $roomTypeRoomCountOos;
		$data['roomTypeReservations']     = $roomTypeReservations;
		
		$this->load->view('pms/rooms/room_type_info_view', $data);
	}
	
	
	function addRoom()
	{	
		$this->form_validation->set_rules('room_number', 'lang:number', 'required|max_length[20]|callback_checkRoomNumber');
		$this->form_validation->set_rules('room_name', 'lang:name', 'max_length[50]');
		$this->form_validation->set_rules('room_status', 'lang:status', 'required|max_length[20]');
		$this->form_validation->set_rules('room_room_type','lang:room_type','required|max_length[20]');
		
		if ($this->form_validation->run() == FALSE) {
		
			$hotel = $this->session->userdata('hotelid');
			
			$maxRoomNumber = $this->ROM->getMaxRoomNumber($hotel);
			$roomTypes     = $this->GNM->getInfo($hotel, 'ROOM_TYPE', null, null, null, null, null, 1);
		
			$data['maxRoomNumber'] = $maxRoomNumber;
			$data['roomTypes']     = $roomTypes;
		
			$this->load->view('pms/rooms/room_add_view', $data);
			
		} else {
		
			$roomNumber   = set_value('room_number');
			$roomName     = set_value('room_name');
			$roomStatus   = set_value('room_status');
			$roomRoomType = set_value('room_room_type');
			
			$data = array(
			    'name'         => ucwords(strtolower($roomName)),
				'number'       => $roomNumber,
				'status'       => $roomStatus,
				'fk_room_type' => $roomRoomType
				);
			
			$this->GNM->insert('ROOM', $data);  
				
			$this->viewRooms(); 
		}	
	}
	
	
	function addRoomType()
	{
		$hotel = $this->session->userdata('hotelid');
		
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
					'fk_hotel'    => $hotel
				    );
			
			    $this->GNM->insert('ROOM_TYPE', $data);  
				
			    $this->viewRoomTypes(); 
			}
		}
	}
	
	
	function editRoom($roomId)
	{
		$hotel  = $this->session->userdata('hotelid');
		
		$this->form_validation->set_rules('room_number','lang:number','required|max_length[20]|callback_checkRoomNumber');
		$this->form_validation->set_rules('room_name','lang:name','max_length[50]');
		$this->form_validation->set_rules('room_status','lang:status','required|max_length[20]');
		$this->form_validation->set_rules('room_room_type','lang:room_type','required|max_length[20]');
		
		if ($this->form_validation->run() == FALSE) {
		
			$room      = $this->ROM->getRoomInfo($hotel, 'id_room', $roomId, null, null, null, 1);
			$roomTypes = $this->GNM->getInfo($hotel, 'ROOM_TYPE', null, null, null, null, null, 1);
		
			$data['room']      = $room;
			$data['roomTypes'] = $roomTypes;
		
			$this->load->view('pms/rooms/room_edit_view', $data);
			
		} else {
		
			$roomNumber   = set_value('room_number');
			$roomName     = set_value('room_name');
			$roomStatus   = set_value('room_status');
			$roomRoomType = set_value('room_room_type');
			
			$data = array(
				'name'         => ucwords(strtolower($roomName)),
				'number'       => $roomNumber,
				'status'       => $roomStatus,
				'fk_room_type' => $roomRoomType
				);
			
			$this->GNM->update('ROOM', 'id_room', $roomId, $data);  
				
			$this->infoRoom($roomId); 
		}	
	}
	
	
	function editRoomType($roomTypeId)
	{
		$hotel  = $this->session->userdata('hotelid');
		
		$this->form_validation->set_rules('room_type_name','lang:name','required|max_length[50]|callback_checkRoomTypeName');
		$this->form_validation->set_rules('room_type_abrv','lang:abrv','max_length[5]|callback_checkRoomTypeAbrv');
		$this->form_validation->set_rules('room_type_paxStd','lang:paxStd','required|numeric|max_length[5]');
		$this->form_validation->set_rules('room_type_paxMax','lang:paxMax','required|numeric|max_length[5]');
		$this->form_validation->set_rules('room_type_beds','lang:beds','required|numeric|max_length[5]');
		$this->form_validation->set_rules('room_type_description','lang:description','max_length[300]');
		
		if ($this->form_validation->run() == FALSE) {
		
			$roomType = $this->GNM->getInfo($hotel, 'ROOM_TYPE', 'id_room_type', $roomTypeId, null, null, null, 1);
			
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
			    $roomType = $this->GNM->getInfo($hotel, 'ROOM_TYPE', 'id_room_type', $roomTypeId, null, null, null, 1);

			    $data['roomType'] = $roomType;
			    $data['error'] = $error;
			
			    $this->load->view('pms/rooms/room_type_edit_view', $data);
			
			} else if ($roomTypePaxMax < $roomTypeBeds) {
			
			    $error = lang(errorPaxStd_PaxMax);
			    $roomType = $this->GNM->getInfo($hotel, 'ROOM_TYPE', 'id_room_type', $roomTypeId, null, null, null, 1);

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
			
			    $this->GNM->update('ROOM_TYPE', 'id_room_type', $roomTypeId, $data);  
				
			    $this->infoRoomType($roomTypeId); 
			}
		}
	}
	
	
	function deleteRoom($roomId)
	{
		$hotel  = $this->session->userdata('hotelid');
		
		$roomReservation = $this->ROM->getRoomReservationsGuest($hotel, 'RO.id_room', $roomId, null);
		
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
		
			$this->GNM->disable('ROOM', 'id_room', $roomId);  
			$this->viewRooms(); 
		}	
	}
	
	
	function deleteRoomType($roomTypeId)
	{
		$hotel  = $this->session->userdata('hotelid');
		
		$roomTypeReservation = $this->ROM->getRoomReservationsGuest($hotel, 'RT.id_room_type', $roomTypeId, null);
		
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
		
			$this->GNM->disable('ROOM_TYPE', 'id_room_type', $roomTypeId); 
			$this->GNM->disable('ROOM',      'fk_room_type', $roomTypeId);   
			$this->viewRoomTypes(); 
		}	
	}
	
	
	function checkRoomNumber($str)
	{
		$roomId = $this->uri->segment(3);
		$hotel  = $this->session->userdata('hotelid');
		
		$rooms = $this->ROM->validationCheckRoom($hotel, 'number', $str, 'id_room !=', $roomId);

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
		$hotel      = $this->session->userdata('hotelid');
		
		$roomTypes = $this->GNM->validationCheck($hotel, 'ROOM_TYPE', 'name', $str, 'id_room_type !=', $roomTypeId, 1);

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
		    $hotel      = $this->session->userdata('hotelid');
		
			$roomTypes = $this->GNM->validationCheck($hotel, 'ROOM_TYPE', 'abrv', $str, 'id_room_type !=', $roomTypeId, 1);

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