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
		$this->load->helper('hoteles');
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
		$userId = $this->session->userdata('userid');
		
		if ($userId) {
			
			if (isset($_POST["order"])) {
				$order = $_POST["order"];
			}else {
				$order = 'number';
			}
			
			$hotel = $this->session->userdata('hotelid');
		
			$rooms             = $this->ROM->getRoomInfo($hotel, null, null, $order, null, null, 1);
			$roomsCount        = $this->ROM->getRoomCount($hotel, null,     null,             null, null, 1);
			$roomsCountRunning = $this->ROM->getRoomCount($hotel, 'status', 'Running',        null, null, 1);
			$roomsCountOos     = $this->ROM->getRoomCount($hotel, 'status', 'Out of service', null, null, 1);
			$roomTypes         = $this->GNM->getInfo($hotel, 'ROOM_TYPE', null, null, null, null, null, 1);
			
			$data['rooms']             = $rooms;
			$data['roomsCount']        = $roomsCount;
			$data['roomsCountOos']     = $roomsCountOos;
			$data['roomsCountRunning'] = $roomsCountRunning;
			$data['roomTypes']         = $roomTypes;
			
			$this->load->view('pms/rooms/rooms_view', $data);
		
		} else {
		
			$data['error'] = NULL;
			$this->load->view('pms/users/user_sign_in', $data);
		}
	}
	
	
	function viewRoomTypes()
	{
		$userId = $this->session->userdata('userid');
		
		if ($userId) {
		
			if (isset($_POST["order"])) {
				$order = $_POST["order"];
			}else {
				$order = 'paxStd';
			}
			
			$hotel = $this->session->userdata('hotelid');
			
			$roomTypes      = $this->GNM->getInfo($hotel, 'ROOM_TYPE', null, null, $order, null, null, 1);
			$roomTypesCount = $this->GNM->getCount($hotel, 'ROOM_TYPE', null, null, null, null, 1);
			$roomTypesDis   = $this->GNM->getInfo($hotel,  'ROOM_TYPE', 'disable', '0', $order, null, null, null);
			
			$data['roomTypes']      = $roomTypes;
			$data['roomTypesCount'] = $roomTypesCount;
			$data['roomTypesDis']   = $roomTypesDis;
			
			$this->load->view('pms/rooms/room_types_view', $data);
		
		} else {
		
			$data['error'] = NULL;
			$this->load->view('pms/users/user_sign_in', $data);
		}
	}
	
	
	function viewDisabledRoomTypes()
	{
		$userId = $this->session->userdata('userid');
		
		if ($userId) {
		
			if (isset($_POST["order"])) {
				$order = $_POST["order"];
			}else {
				$order = 'paxStd';
			}
	
			$hotel = $this->session->userdata('hotelid');
			
			$roomTypes      = $this->GNM->getInfo($hotel,  'ROOM_TYPE', 'disable', '0', $order, null, null, null);
			$roomTypesCount = $this->GNM->getCount($hotel, 'ROOM_TYPE', 'disable', '0', null, null, null);
			
			$data['roomTypes']      = $roomTypes;
			$data['roomTypesCount'] = $roomTypesCount;
			
			$this->load->view('pms/rooms/room_types_disabled_view', $data);
		
		} else {
		
			$data['error'] = NULL;
			$this->load->view('pms/users/user_sign_in', $data);
		}
	}
	
	
	function infoRoom($roomId)
	{
		$userId = $this->session->userdata('userid');
		
		if ($userId) {
		
			if (isset($_POST["order"])) {
				$order = $_POST["order"];
			}else {
				$order = 'checkIn';
			}
			
			$hotel = $this->session->userdata('hotelid');
			
			$room             = $this->ROM->getRoomInfo($hotel, 'id_room', $roomId, null, null, null, 1);
			$roomReservations = $this->ROM->getRoomReservationsGuest($hotel, 'RO.id_room', $roomId, $order);
			
			$data['room']             = $room;
			$data['roomReservations'] = $roomReservations;
			
			$this->load->view('pms/rooms/room_info_view', $data);
			
		} else {
		
			$data['error'] = NULL;
			$this->load->view('pms/users/user_sign_in', $data);
		}
	}
	
	
	function infoRoomType($roomTypeId)
	{
		$userId = $this->session->userdata('userid');
		
		if ($userId) {
		
			$hotel = $this->session->userdata('hotelid');
				
			$roomType                 = $this->GNM->getInfo($hotel, 'ROOM_TYPE', 'id_room_type', $roomTypeId, null, null, null, null);
			$roomTypeImages           = $this->GNM->getInfo($hotel, 'IMAGE',     'fk_room_type', $roomTypeId, null, null, null, null);
			$roomTypeRoomCount        = $this->ROM->getRoomCount($hotel, 'fk_room_type', $roomTypeId,  null,  null, null);
			$roomTypeRoomCountRunning = $this->ROM->getRoomCount($hotel, 'fk_room_type', $roomTypeId, 'status', 'Running', null);
			$roomTypeRoomCountOos     = $this->ROM->getRoomCount($hotel, 'fk_room_type', $roomTypeId, 'status', 'Out of service', null);
			$roomTypeReservations     = $this->ROM->getRoomReservationsGuest($hotel, 'RT.id_room_type', $roomTypeId, 'RE.checkIn DESC');
		
			$data['roomType']       = $roomType;
			$data['roomTypeImages'] = $roomTypeImages;
			$data['roomTypeRoomCount']        = $roomTypeRoomCount;
			$data['roomTypeRoomCountRunning'] = $roomTypeRoomCountRunning;
			$data['roomTypeRoomCountOos']     = $roomTypeRoomCountOos;
			$data['roomTypeReservations']     = $roomTypeReservations;
			
			$this->load->view('pms/rooms/room_type_info_view', $data);
		
		} else {
			
			$data['error'] = NULL;
			$this->load->view('pms/users/user_sign_in', $data);
		}
	}
	
	
	function imagesRoomType($roomTypeId)
	{
		$userId = $this->session->userdata('userid');
		
		if ($userId) {
		
			$hotel = $this->session->userdata('hotelid');
				
			$roomType                 = $this->GNM->getInfo($hotel, 'ROOM_TYPE', 'id_room_type', $roomTypeId, null, null, null, null);
			$roomTypeImages           = $this->GNM->getInfo($hotel, 'IMAGE',     'fk_room_type', $roomTypeId, null, null, null, null);
			
			$data['roomType']       = $roomType;
			$data['roomTypeImages'] = $roomTypeImages;
			
			$this->load->view('pms/rooms/room_type_images_view', $data);
			
		} else {
			
			$data['error'] = NULL;
			$this->load->view('pms/users/user_sign_in', $data);
		}
	}
	
	
	function addRoom()
	{	
		$this->form_validation->set_rules('room_number', 'lang:number', 'trim|xss_clean|required|max_length[20]|callback_checkRoomNumber');
		$this->form_validation->set_rules('room_name', 'lang:name', 'trim|xss_clean|max_length[50]');
		$this->form_validation->set_rules('room_status', 'lang:status', 'trim|xss_clean|required|max_length[20]');
		$this->form_validation->set_rules('room_room_type','lang:room_type','trim|xss_clean|required|max_length[20]');
		
		if ($this->form_validation->run() == FALSE) {
		
			$userId = $this->session->userdata('userid');
		
			if ($userId) {
			
				$hotel = $this->session->userdata('hotelid');
				
				$maxRoomNumber = $this->ROM->getMaxRoomNumber($hotel);
				$roomTypes     = $this->GNM->getInfo($hotel, 'ROOM_TYPE', null, null, null, null, null, 1);
			
				$data['maxRoomNumber'] = $maxRoomNumber;
				$data['roomTypes']     = $roomTypes;
			
				$this->load->view('pms/rooms/room_add_view', $data);
				
			} else {
			
				$data['error'] = NULL;
				$this->load->view('pms/users/user_sign_in', $data);
			}
			
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
		
		$this->form_validation->set_rules('room_type_name', 'lang:name','trim|xss_clean|required|max_length[50]|callback_checkRoomTypeName');
		$this->form_validation->set_rules('room_type_abrv', 'lang:abrv', 'trim|xss_clean|max_length[5]|callback_checkRoomTypeAbrv');
		$this->form_validation->set_rules('room_type_paxStd', 'lang:paxStd', 'trim|xss_clean|required|numeric|max_length[5]');
		$this->form_validation->set_rules('room_type_paxMax', 'lang:paxMax', 'trim|xss_clean|required|numeric|max_length[5]');
		$this->form_validation->set_rules('room_type_beds', 'lang:beds', 'trim|xss_clean|required|numeric|max_length[5]');
		$this->form_validation->set_rules('room_type_description', 'lang:description', 'trim|xss_clean|max_length[300]');
			
		if ($this->form_validation->run() == FALSE) {
		
			$userId = $this->session->userdata('userid');
		
			if ($userId) {
			
				$data['error'] = NULL;
				$this->load->view('pms/rooms/room_type_add_view', $data);
			
			} else {
			
				$data['error'] = NULL;
				$this->load->view('pms/users/user_sign_in', $data);
			}
			
		} else {
		
			$roomTypeName        = set_value('room_type_name');
			$roomTypeAbrv        = set_value('room_type_abrv');
			$roomTypePaxStd      = set_value('room_type_paxStd');
			$roomTypePaxMax      = set_value('room_type_paxMax');
			$roomTypeBeds        = set_value('room_type_beds');
			$roomTypeDescription = set_value('room_type_description');
			
			if ($roomTypePaxStd > $roomTypePaxMax) {
			
			    $error = lang("errorPaxStd_PaxMax");
			    $data['error'] = $error;
				
			    $this->load->view('pms/rooms/room_type_add_view', $data);
			
			} else if ($roomTypePaxMax < $roomTypeBeds) {
			
			    $error = lang("errorPaxMax_Beds");
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
	
	
	function addRoomTypeImage($roomTypeId)
	{
		$userId = $this->session->userdata('userid');
		
		if ($userId) {
	
			$hotel = $this->session->userdata('hotelid');
			
			$roomType = $this->GNM->getInfo($hotel, 'ROOM_TYPE', 'id_room_type', $roomTypeId, null, null, null, 1);
			$error = 1;
				
			$data['roomType'] = $roomType;
			$data['error'] = $error;
			
			$this->load->view('pms/rooms/room_type_add_image_view', $data);
		
		} else {
			
			$data['error'] = NULL;
			$this->load->view('pms/users/user_sign_in', $data);
		}
	}
	
	
	function addRoomTypeImage2($roomTypeId)
	{	
		$userId = $this->session->userdata('userid');
		
		if ($userId) {
		
			$hotel = $this->session->userdata('hotelid');
			
			$config['upload_path'] = './assets/images/';
			$config['allowed_types'] = 'gif|jpg|png';
			$config['max_size']	= '0';
			$config['max_width']  = '0';
			$config['max_height']  = '0';
			
			$this->load->library('upload', $config);
			
			if ( ! $this->upload->do_upload())
			{
				$hotel = $this->session->userdata('hotelid');
			
				$roomType = $this->GNM->getInfo($hotel, 'ROOM_TYPE', 'id_room_type', $roomTypeId, null, null, null, 1);
				
				$data = array('error' => $this->upload->display_errors());
				$data['roomType'] = $roomType;
	
				$this->load->view('pms/rooms/room_type_add_image_view', $data);
			}	
			else
			{
				$data = array('upload_data' => $this->upload->data());
				
				foreach ($data as $row) {
				
					$fullPath = $row['full_path'];
					$fileName = $row['file_name'];
					$fileExt = $row['file_ext'];
				}
				
				$data = array(
					'image'        => $fileName,
					'fk_hotel'     => $hotel,
					'fk_room_type' => $roomTypeId
					);
				
				$this->GNM->insert('IMAGE', $data);  
					
				$this->infoRoomType($roomTypeId); 
			}
			
		} else {
		
			$data['error'] = NULL;
			$this->load->view('pms/users/user_sign_in', $data);
		}

	}
	
	/*
	function deleteRoomTypeImage($roomTypeId)
	{
		$category = $this->CM->get_categories('ID_CATEGORY', $category_id, 'CATEGORIES.NAME', null, null);
		
		$data = array(
			'IMG_NAME' => NULL,
			'IMG_EXT' => NULL, 
			'IMG_LOCATION' => NULL
		);
			
		$this->CM->update('CATEGORIES', 'ID_CATEGORY', $category_id, $data); 
		
		foreach ($category as $row)
		{
			unlink('./assets/images/site/uploads/categories/'.$row['IMG_NAME'].$row['IMG_EXT']); 
		}
		
		$this->modify_category();
	}
	*/
	
	
	
	
	function editRoom($roomId)
	{
		$hotel  = $this->session->userdata('hotelid');
		
		$this->form_validation->set_rules('room_number','lang:number','trim|xss_clean|required|max_length[20]|callback_checkRoomNumber');
		$this->form_validation->set_rules('room_name','lang:name','trim|xss_clean|max_length[50]');
		$this->form_validation->set_rules('room_status','lang:status','trim|xss_clean|required|max_length[20]');
		$this->form_validation->set_rules('room_room_type','lang:room_type','trim|xss_clean|required|max_length[20]');
		
		if ($this->form_validation->run() == FALSE) {
			
			$userId = $this->session->userdata('userid');
		
			if ($userId) {

				$room      = $this->ROM->getRoomInfo($hotel, 'id_room', $roomId, null, null, null, 1);
				$roomTypes = $this->GNM->getInfo($hotel, 'ROOM_TYPE', null, null, null, null, null, 1);
			
				$data['room']      = $room;
				$data['roomTypes'] = $roomTypes;
			
				$this->load->view('pms/rooms/room_edit_view', $data);
			
			} else {
				
				$data['error'] = NULL;
				$this->load->view('pms/users/user_sign_in', $data);
			}
			
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
		
		$this->form_validation->set_rules('room_type_name','lang:name','trim|xss_clean|required|max_length[50]|callback_checkRoomTypeName');
		$this->form_validation->set_rules('room_type_abrv','lang:abrv','trim|xss_clean|max_length[5]|callback_checkRoomTypeAbrv');
		$this->form_validation->set_rules('room_type_paxStd','lang:paxStd','trim|xss_clean|required|numeric|max_length[5]');
		$this->form_validation->set_rules('room_type_paxMax','lang:paxMax','trim|xss_clean|required|numeric|max_length[5]');
		$this->form_validation->set_rules('room_type_beds','lang:beds','trim|xss_clean|required|numeric|max_length[5]');
		$this->form_validation->set_rules('room_type_description','lang:description','trim|xss_clean|max_length[300]');
		
		if ($this->form_validation->run() == FALSE) {
		
			$userId = $this->session->userdata('userid');
		
			if ($userId) {
	
				$roomType = $this->GNM->getInfo($hotel, 'ROOM_TYPE', 'id_room_type', $roomTypeId, null, null, null, 1);
				$error = NULL;
				
				$data['error'] = $error;
				$data['roomType'] = $roomType;
				
				$this->load->view('pms/rooms/room_type_edit_view', $data);
				
			} else {
				
				$data['error'] = NULL;
				$this->load->view('pms/users/user_sign_in', $data);
			}
			
		} else {
		
			$roomTypeName        = set_value('room_type_name');
			$roomTypeAbrv        = set_value('room_type_abrv');
			$roomTypePaxStd      = set_value('room_type_paxStd');
			$roomTypePaxMax      = set_value('room_type_paxMax');
			$roomTypeBeds        = set_value('room_type_beds');
			$roomTypeDescription = set_value('room_type_description');
			
			if ($roomTypePaxStd > $roomTypePaxMax) {
			
			    $error = lang("errorPaxStd_PaxMax");
			    $roomType = $this->GNM->getInfo($hotel, 'ROOM_TYPE', 'id_room_type', $roomTypeId, null, null, null, 1);

			    $data['roomType'] = $roomType;
			    $data['error'] = $error;
			
			    $this->load->view('pms/rooms/room_type_edit_view', $data);
			
			} else if ($roomTypePaxMax < $roomTypeBeds) {
			
			    $error = lang("errorPaxStd_PaxMax");
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
		$userId = $this->session->userdata('userid');
		
		if ($userId) {

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
			
				echo lang("errorPendingReservation")."<br>";
				foreach ($resultado as $actual)
				echo '# ', $actual . "<br>";
				$this->infoRoom($roomId);
				
			} else {
			
				$this->GNM->disable('ROOM', 'id_room', $roomId);  
				$this->viewRooms(); 
			}	
		
		} else {
			
			$data['error'] = NULL;
			$this->load->view('pms/users/user_sign_in', $data);
		}
	}
	
	
	function disableRoomType($roomTypeId)
	{
		$userId = $this->session->userdata('userid');
		
		if ($userId) {
		
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
			
				echo lang("errorPendingReservation")."<br>";
				foreach ($resultado as $actual)
				echo '# ', $actual . "<br>"; 
				$this->infoRoomType($roomTypeId);
				
			} else {
			
				$this->GNM->disable('ROOM_TYPE', 'id_room_type', $roomTypeId); 
				$this->GNM->disable('ROOM',      'fk_room_type', $roomTypeId);   
				$this->viewRoomTypes(); 
			}	
		
		} else {
			
			$data['error'] = NULL;
			$this->load->view('pms/users/user_sign_in', $data);
		}
	}
	
	
	function enableRoomType($roomTypeId)
	{
		$userId = $this->session->userdata('userid');
		
		if ($userId) {
		
			$data = array(
					'disable' => 1
					);
				
			$this->GNM->update('ROOM_TYPE', 'id_room_type', $roomTypeId, $data); 
			$this->GNM->update('ROOM',      'fk_room_type', $roomTypeId, $data);   
			
			$this->viewRoomTypes(); 
		
		} else {
			
			$data['error'] = NULL;
			$this->load->view('pms/users/user_sign_in', $data);
		}	
	}
	
	
	function checkRoomNumber($str)
	{
		$roomId = $this->uri->segment(3);
		$hotel  = $this->session->userdata('hotelid');
		
		$rooms = $this->ROM->validationCheckRoom($hotel, 'number', $str, 'id_room !=', $roomId);

		if ($rooms) {
		
			$this->form_validation->set_message('checkRoomNumber', lang("errorRoomNumber"));
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
		
			$this->form_validation->set_message('checkRoomTypeName', lang("errorRoomTypeName"));
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
			
				$this->form_validation->set_message('checkRoomTypeAbrv', lang("errorAbrv"));
				return FALSE;
				
			} else {
			
				return TRUE;
			}
		}
	}
	
	
	
	
	






}
?>