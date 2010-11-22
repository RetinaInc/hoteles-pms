<?php

class Rooms extends Controller
{
	function Rooms()
	{
		parent::Controller();
		$this->load->model('rooms_model','ROM');
		$this->load->model('general_model','GNM');
		$this->lang->load ('form_validation','spanish');
		$this->load->library('form_validation');
		$this->load->library('pagination');
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
			
			$hotel = $this->session->userdata('hotelid');
	
			$order = $this->uri->segment(3);
			$lim2  = $this->uri->segment(4);
			
			if (($this->uri->segment(4) == FALSE) && ($this->uri->segment(3) == FALSE)) {
				
				$order = 'number';
				$lim2  = NULL;
			}
			
			if (($this->uri->segment(4) == FALSE) && ($this->uri->segment(3) > 0)) {
				
				$order = 'number';
				$lim2  = $this->uri->segment(3);
			}
			
			$totalRows = $this->ROM->getTotalRowsRooms($hotel, null, null, 1);
			
			$config['base_url']    = base_url().'rooms/viewRooms/'.$order;
			$config['total_rows']  = $totalRows;
			$config['per_page']    = '9';
			$config['num_links']   = '50';
			$config['uri_segment'] = 4;
			
			$this->pagination->initialize($config); 
			
			if ($order == NULL) {
			
				$order = 'number';
			}
			
			$rooms             = $this->ROM->getRoomInfo($hotel, null, null, $order, $config['per_page'], $lim2, 1);
			$roomsDis          = $this->ROM->getRoomInfo($hotel, 'RO.disable', '0',  null, null,  null, null);
			$roomsCount        = $this->ROM->getRoomCount($hotel, null,     null,             null, null, 1);
			//$roomsCountRunning = $this->ROM->getRoomCount($hotel, 'status', 'Running',        null, null, 1);
			//$roomsCountOos     = $this->ROM->getRoomCount($hotel, 'status', 'Out of service', null, null, 1);
			$roomTypes         = $this->GNM->getInfo($hotel, 'ROOM_TYPE', null, null, null, null, null, 1);
			
			$data['order']             = $order;
			$data['rooms']             = $rooms;
			$data['roomsDis']          = $roomsDis;
			$data['roomsCount']        = $roomsCount;
			//$data['roomsCountOos']     = $roomsCountOos;
			//$data['roomsCountRunning'] = $roomsCountRunning;
			$data['roomTypes']         = $roomTypes;
			
			$this->load->view('pms/rooms/rooms_view', $data);
		
		} else {
		
			$data['error'] = NULL;
			$this->load->view('pms/users/user_sign_in', $data);
		}
	}
	
	
	function viewDisabledRooms()
	{
		$userId = $this->session->userdata('userid');
		
		if ($userId) {
			
			$hotel = $this->session->userdata('hotelid');
		
			$order = $this->uri->segment(3);
			$lim2  = $this->uri->segment(4);
			
			$totalRows = $this->ROM->getTotalRowsRooms($hotel, 'RO.disable', '0', null);
			
			$config['base_url']    = base_url().'rooms/viewDisabledRooms/'.$order;
			$config['total_rows']  = $totalRows;
			$config['per_page']    = '9';
			$config['num_links']   = '50';
			$config['uri_segment'] = 4;
			
			$this->pagination->initialize($config); 
			
			if ($order == NULL) {
			
				$order = 'number';
			}
			
			$roomsDis      = $this->ROM->getRoomInfo($hotel, 'RO.disable', '0', $order, $config['per_page'], $lim2, null);
			$roomsCountDis = $this->ROM->getRoomCount($hotel, 'RO.disable', '0', null, null, null);
			
			$data['roomsDis']      = $roomsDis;
			$data['roomsCountDis'] = $roomsCountDis;
	
			$this->load->view('pms/rooms/rooms_disabled_view', $data);
		
		} else {
		
			$data['error'] = NULL;
			$this->load->view('pms/users/user_sign_in', $data);
		}
	}
	
	
	function viewRoomTypes()
	{
		$userId = $this->session->userdata('userid');
		
		if ($userId) {
		
			$hotel = $this->session->userdata('hotelid');
			
			$order = $this->uri->segment(3);
			$lim2  = $this->uri->segment(4);
			
			if (($this->uri->segment(4) == FALSE) && ($this->uri->segment(3) == FALSE)) {
				
				$order = 'scale';
				$lim2  = NULL;
			}
			
			if (($this->uri->segment(4) == FALSE) && ($this->uri->segment(3) > 0)) {
				
				$order = 'scale';
				$lim2  = $this->uri->segment(3);
			}
			
			$totalRows = $this->GNM->getTotalRows($hotel, 'ROOM_TYPE', null, null, 1);
	
			$config['base_url']    = base_url().'rooms/viewRoomTypes/'.$order;
			$config['total_rows']  = $totalRows;
			$config['per_page']    = '9';
			$config['num_links']   = '50';
			$config['uri_segment'] = 4;
			
			$this->pagination->initialize($config); 
			
			if ($order == NULL) {
			
				$order = 'name';
			}
			
			$roomTypes      = $this->GNM->getInfo($hotel, 'ROOM_TYPE', null, null, $order, $config['per_page'], $lim2, 1);
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
		
			$hotel = $this->session->userdata('hotelid');
	
			$order = $this->uri->segment(3);
			$lim2  = $this->uri->segment(4);
			
			$totalRows = $this->GNM->getTotalRows($hotel, 'ROOM_TYPE', 'disable', '0', null);
			
			$config['base_url']    = base_url().'rooms/viewDisabledRoomTypes/'.$order;
			$config['total_rows']  = $totalRows;
			$config['per_page']    = '9';
			$config['num_links']   = '50';
			$config['uri_segment'] = 4;
			
			$this->pagination->initialize($config);
			
			if ($order == NULL) {
			
				$order = 'name';
			}
			
			$roomTypes      = $this->GNM->getInfo($hotel,  'ROOM_TYPE', 'disable', '0', $order, $config['per_page'], $lim2, null);
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
			
			$hotel = $this->session->userdata('hotelid');
			
			$roomId = $this->uri->segment(3);
			$order  = $this->uri->segment(4);
			$lim2   = $this->uri->segment(5);
			
			$rr        = $this->ROM->getRoomReservationsGuest($hotel, 'RO.id_room', $roomId, null, null, null);
			$totalRows = count($rr);
			
			$config['base_url']    = base_url().'rooms/infoRoom/'.$roomId.'/'.$order;
			$config['total_rows']  = $totalRows;
			$config['per_page']    = '5';
			$config['num_links']   = '50';
			$config['uri_segment'] = 5;
			
			$this->pagination->initialize($config); 
			
			if (($order == NULL) || ($order == 'checkIn')){
			
				$order = 'checkIn DESC';
			}
			if ($order == 'checkOut'){
			
				$order = 'checkOut DESC';
			}
			
			$room             = $this->ROM->getRoomInfo($hotel, 'id_room', $roomId, null, null, null, null);
			$roomReservations = $this->ROM->getRoomReservationsGuest($hotel, 'RO.id_room', $roomId, null, $config['per_page'], $lim2);
			
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
			$roomTypeRooms            = $this->ROM->getRoomInfo($hotel, 'fk_room_type', $roomTypeId, 'number', null, null, 1);
			$roomTypeRoomCount        = $this->ROM->getRoomCount($hotel, 'fk_room_type', $roomTypeId,  null,  null, null);
			$roomTypeRoomCountRunning = $this->ROM->getRoomCount($hotel, 'fk_room_type', $roomTypeId, 'status', 'Running', null);
			$roomTypeRoomCountOos     = $this->ROM->getRoomCount($hotel, 'fk_room_type', $roomTypeId, 'status', 'Out of service', null);
			$roomTypeReservations     = $this->ROM->getRoomReservationsGuest($hotel, 'RT.id_room_type', $roomTypeId, null, null, null);
		
			$data['roomType']                 = $roomType;
			$data['roomTypeImages']           = $roomTypeImages;
			$data['roomTypeRooms']            = $roomTypeRooms;
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
	
	
	function roomTypeReservations($roomTypeId)
	{
		$userId = $this->session->userdata('userid');
		
		if ($userId) {
		
			$hotel = $this->session->userdata('hotelid');
			
			$roomTypeId = $this->uri->segment(3);
			$order      = $this->uri->segment(4);
			$lim2       = $this->uri->segment(5);
			
			$rr         = $this->ROM->getRoomReservationsGuest($hotel, 'RT.id_room_type', $roomTypeId, $order, null, null);
			$totalRows  = count($rr);
			
			$config['base_url']    = base_url().'rooms/roomTypeReservations/'.$roomTypeId.'/'.$order;
			$config['total_rows']  = $totalRows;
			$config['per_page']    = '12';
			$config['num_links']   = '50';
			$config['uri_segment'] = 5;
			
			$this->pagination->initialize($config); 
			
			if (($order == NULL) || ($order == 'checkIn')){
			
				$order = 'checkIn DESC';
			}
			if ($order == 'checkOut'){
			
				$order = 'checkOut DESC';
			}
			
			$roomType                 = $this->GNM->getInfo($hotel, 'ROOM_TYPE', 'id_room_type', $roomTypeId, null, null, null, null);
			$roomTypeReservations     = $this->ROM->getRoomReservationsGuest($hotel, 'RT.id_room_type', $roomTypeId, $order, $config['per_page'], $lim2);
		
			$data['roomType']                 = $roomType;
			$data['roomTypeReservations']     = $roomTypeReservations;
			
			$this->load->view('pms/rooms/room_type_reservations_view', $data);
		
		} else {
			
			$data['error'] = NULL;
			$this->load->view('pms/users/user_sign_in', $data);
		}
	}
	
	
	function addRoom()
	{	
		$this->form_validation->set_rules('room_number', 'lang:number', 'trim|xss_clean|required|max_length[20]|callback_checkRoomNumber');
		$this->form_validation->set_rules('room_name', 'lang:name', 'trim|xss_clean|max_length[50]');
		//$this->form_validation->set_rules('room_status', 'lang:status', 'trim|xss_clean|required|max_length[20]');
		$this->form_validation->set_rules('room_room_type','lang:room_type','trim|xss_clean|required|max_length[20]');
		
		if ($this->form_validation->run() == FALSE) {
		
			$userId = $this->session->userdata('userid');
		
			if ($userId) {
			
				$userRole = $this->session->userdata('userrole');
				
				if ($userRole != 'Employee') {
			
					$hotel = $this->session->userdata('hotelid');
					
					$maxRoomNumber = $this->ROM->getMaxRoomNumber($hotel, null);
					$roomTypes     = $this->GNM->getInfo($hotel, 'ROOM_TYPE', null, null, null, null, null, 1);
				
					$data['maxRoomNumber'] = $maxRoomNumber;
					$data['roomTypes']     = $roomTypes;
				
					$this->load->view('pms/rooms/room_add_view', $data);
					
				} else {
					
					$data['error'] = lang("errorNoPrivileges");
					$data['type']  = 'error_priv';
				
					$this->load->view('pms/error', $data);
				}
				
			} else {
			
				$data['error'] = NULL;
				$this->load->view('pms/users/user_sign_in', $data);
			}
			
		} else {
		
			$roomNumber   = set_value('room_number');
			$roomName     = set_value('room_name');
			//$roomStatus   = set_value('room_status');
			$roomRoomType = set_value('room_room_type');
			
			$data = array(
			    'name'         => ucwords(strtolower($roomName)),
				'number'       => $roomNumber,
				'status'       => 'Running',
				'fk_room_type' => $roomRoomType
				);
			
			$this->GNM->insert('ROOM', $data);  
				
			$data['message'] = lang("addRoomMessage");
			$data['type'] = 'rooms';
				
			$this->load->view('pms/success', $data);  
		}	
	}
	
	
	function addRoomType()
	{
		$hotel = $this->session->userdata('hotelid');
		
		$this->form_validation->set_rules('room_type_name', 'lang:name','trim|xss_clean|required|max_length[50]|callback_checkRoomTypeName');
		$this->form_validation->set_rules('room_type_abrv', 'lang:abrv', 'trim|xss_clean|required|max_length[5]|callback_checkRoomTypeAbrv');
		$this->form_validation->set_rules('room_type_paxStd', 'lang:paxStd', 'trim|xss_clean|required|numeric|max_length[5]');
		$this->form_validation->set_rules('room_type_paxMax', 'lang:paxMax', 'trim|xss_clean|required|numeric|max_length[5]');
		$this->form_validation->set_rules('room_type_beds', 'lang:beds', 'trim|xss_clean|required|numeric|max_length[5]');
		$this->form_validation->set_rules('room_type_scale', 'lang:scale', 'trim|xss_clean|required');
		$this->form_validation->set_rules('room_type_description', 'lang:description', 'trim|xss_clean|max_length[300]');
			
		if ($this->form_validation->run() == FALSE) {
		
			$userId = $this->session->userdata('userid');
		
			if ($userId) {
			
				$userRole = $this->session->userdata('userrole');
				
				if ($userRole != 'Employee') {
				
					$data['error'] = NULL;
					$this->load->view('pms/rooms/room_type_add_view', $data);
				
				} else {
					
					$data['error'] = lang("errorNoPrivileges");
					$data['type']  = 'error_priv';
				
					$this->load->view('pms/error', $data);
				}
			
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
			$roomTypeScale       = set_value('room_type_scale');
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
					'scale'       => $roomTypeScale,
				    'description' => $roomTypeDescription,
					'fk_hotel'    => $hotel
				    );
			
			    $this->GNM->insert('ROOM_TYPE', $data);  
				
				$data['message'] = lang("addRoomTypeMessage");
				$data['type'] = 'room types';
				
				$this->load->view('pms/success', $data);  
			}
		}
	}
	
	
	function editRoom($roomId)
	{
		$hotel  = $this->session->userdata('hotelid');
		
		$this->form_validation->set_rules('room_number','lang:number','trim|xss_clean|required|max_length[20]|callback_checkRoomNumber');
		$this->form_validation->set_rules('room_name','lang:name','trim|xss_clean|max_length[50]');
		//$this->form_validation->set_rules('room_status','lang:status','trim|xss_clean|required|max_length[20]');
		$this->form_validation->set_rules('room_room_type','lang:room_type','trim|xss_clean|required|max_length[20]');
		
		if ($this->form_validation->run() == FALSE) {
			
			$userId = $this->session->userdata('userid');
		
			if ($userId) {
				
				$userRole = $this->session->userdata('userrole');
				
				if ($userRole != 'Employee') {
				
					$room      = $this->ROM->getRoomInfo($hotel, 'id_room', $roomId, null, null, null, 1);
					$roomTypes = $this->GNM->getInfo($hotel, 'ROOM_TYPE', null, null, null, null, null, 1);
				
					$data['room']      = $room;
					$data['roomTypes'] = $roomTypes;
				
					$this->load->view('pms/rooms/room_edit_view', $data);
				
				} else {
					
					$data['error'] = lang("errorNoPrivileges");
					$data['type']  = 'error_priv';
				
					$this->load->view('pms/error', $data);
				}
			
			} else {
				
				$data['error'] = NULL;
				$this->load->view('pms/users/user_sign_in', $data);
			}
			
		} else {
		
			$roomNumber   = set_value('room_number');
			$roomName     = set_value('room_name');
			//$roomStatus   = set_value('room_status');
			$roomRoomType = set_value('room_room_type');
			
			$data = array(
				'name'         => ucwords(strtolower($roomName)),
				'number'       => $roomNumber,
				'status'       => 'Running',
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
		$this->form_validation->set_rules('room_type_abrv','lang:abrv','trim|xss_clean|required|max_length[5]|callback_checkRoomTypeAbrv');
		$this->form_validation->set_rules('room_type_paxStd','lang:paxStd','trim|xss_clean|required|numeric|max_length[5]');
		$this->form_validation->set_rules('room_type_paxMax','lang:paxMax','trim|xss_clean|required|numeric|max_length[5]');
		$this->form_validation->set_rules('room_type_beds','lang:beds','trim|xss_clean|required|numeric|max_length[5]');
		$this->form_validation->set_rules('room_type_scale', 'lang:scale', 'trim|xss_clean|required');
		$this->form_validation->set_rules('room_type_description','lang:description','trim|xss_clean|max_length[300]');
		
		if ($this->form_validation->run() == FALSE) {
		
			$userId = $this->session->userdata('userid');
		
			if ($userId) {
	
				$userRole = $this->session->userdata('userrole');
				
				if ($userRole != 'Employee') {
				
					$roomType = $this->GNM->getInfo($hotel, 'ROOM_TYPE', 'id_room_type', $roomTypeId, null, null, null, 1);
					$error = NULL;
					
					$data['error'] = $error;
					$data['roomType'] = $roomType;
					
					$this->load->view('pms/rooms/room_type_edit_view', $data);
					
				} else {
					
					$data['error'] = lang("errorNoPrivileges");
					$data['type']  = 'error_priv';
				
					$this->load->view('pms/error', $data);
				}
				
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
			$roomTypeScale       = set_value('room_type_scale');
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
					'scale'       => $roomTypeScale,
				    'description' => $roomTypeDescription
				    );
			
			    $this->GNM->update('ROOM_TYPE', 'id_room_type', $roomTypeId, $data);  
				
			    $this->infoRoomType($roomTypeId); 
			}
		}
	}
	
	
	function disableRoom($roomId)
	{
		$userId = $this->session->userdata('userid');
		
		if ($userId) {

			$userRole = $this->session->userdata('userrole');
				
			if ($userRole != 'Employee') {
				
				$hotel  = $this->session->userdata('hotelid');
				
				$roomReservation = $this->ROM->getRoomReservationsGuest($hotel, 'RO.id_room', $roomId, null, null, null);
				
				$datestring = "%Y-%m-%d  %h:%i %a";
				$time       = time();
				$date       = mdate($datestring, $time);
				
				$disable    = 'Yes';
				$iniResNum = array();
				
				foreach ($roomReservation as $row) {
				
					$resNum   = $row['id_reservation'];
					$checkIn  = $row['checkIn'];
					$checkOut = $row['checkOut'];
					$status   = $row['status'];
					
					if (($checkIn > $date || $checkOut > $date) && ($status != 'Canceled') && ($status != 'No Show')){
					
						$disable = 'No';
						
						$newResNum = array ($resNum);
						$result    = array_merge($iniResNum, $newResNum);
						$iniResNum = $result;
					}
				}
				
				if ($disable == 'No') {
					
					$result = array_unique ($result); 
					
					$data['error']  = lang("errorPendingReservation");
					$data['result'] = $result;
					$data['type']   = 'error_room';
					
					$this->load->view('pms/error', $data);
					
				} else {
				
					$this->GNM->disable('ROOM', 'id_room', $roomId);  
					
					$data['message'] = lang("disableRoomMessage");
					$data['type'] = 'rooms';
					
					$this->load->view('pms/success', $data);
				}
			
			} else {
				
				$data['error'] = lang("errorNoPrivileges");
				$data['type']  = 'error_priv';
				
				$this->load->view('pms/error', $data);
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
		
			$userRole = $this->session->userdata('userrole');
				
			if ($userRole != 'Employee') {
			
				$hotel  = $this->session->userdata('hotelid');
				
				$roomTypeReservation = $this->ROM->getRoomReservationsGuest($hotel, 'RT.id_room_type', $roomTypeId, null, null, null);
				
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
						$result    = array_merge($iniResNum, $newResNum);
						$iniResNum = $result;
					}
				}
				
				if ($delete == 'No') {
				
					$result = array_unique ($result); 
	
					$data['error']  = lang("errorPendingReservation");
					$data['result'] = $result;
					$data['type']   = 'error_room_type';
					
					$this->load->view('pms/error', $data);
					
				} else {
				
					$this->GNM->disable('ROOM_TYPE', 'id_room_type', $roomTypeId); 
					$this->GNM->disable('ROOM',      'fk_room_type', $roomTypeId);   
				
					$data['message'] = lang("disableRoomTypeMessage");
					$data['type'] = 'room types';
					
					$this->load->view('pms/success', $data);
				}	
			
			} else {
				
				$data['error'] = lang("errorNoPrivileges");
				$data['type']  = 'error_priv';
				
				$this->load->view('pms/error', $data);
			}
		
		} else {
			
			$data['error'] = NULL;
			$this->load->view('pms/users/user_sign_in', $data);
		}
	}
	
	
	function enableRoom($roomId)
	{
		$userId = $this->session->userdata('userid');
		
		if ($userId) {
		
			$userRole = $this->session->userdata('userrole');
				
			if ($userRole != 'Employee') {
			
				$hotel = $this->session->userdata('hotelid');
				
				$data = array(
						'disable' => 1
						);
	 
				$this->GNM->update('ROOM', 'id_room', $roomId, $data);   
				
				$data['message'] = lang("enableRoomMessage");
				$data['type'] = 'rooms';
					
				$this->load->view('pms/success', $data);
			
			} else {
				
				$data['error'] = lang("errorNoPrivileges");
				$data['type']  = 'error_priv';
				
				$this->load->view('pms/error', $data);
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
		
			$userRole = $this->session->userdata('userrole');
				
			if ($userRole != 'Employee') {
			
				$data = array(
						'disable' => 1
						);
					
				$this->GNM->update('ROOM_TYPE', 'id_room_type', $roomTypeId, $data); 
				$this->GNM->update('ROOM',      'fk_room_type', $roomTypeId, $data);   
				
				$data['message'] = lang("enableRoomTypeMessage");
				$data['type'] = 'room types';
					
				$this->load->view('pms/success', $data); 
			
			} else {
				
				$data['error'] = lang("errorNoPrivileges");
				$data['type']  = 'error_priv';
				
				$this->load->view('pms/error', $data);
			} 
		
		} else {
			
			$data['error'] = NULL;
			$this->load->view('pms/users/user_sign_in', $data);
		}	
	}
	
	
	function viewImagesRoomType($roomTypeId)
	{
		$userId = $this->session->userdata('userid');
		
		if ($userId) {
		
			$hotel = $this->session->userdata('hotelid');
				
			$roomType       = $this->GNM->getInfo($hotel, 'ROOM_TYPE', 'id_room_type', $roomTypeId, null, null, null, null);
			$roomTypeImages = $this->GNM->getInfo($hotel, 'IMAGE',     'fk_room_type', $roomTypeId, null, null, null, null);
			
			$data['roomType']       = $roomType;
			$data['roomTypeImages'] = $roomTypeImages;
			
			$this->load->view('pms/rooms/room_type_images_view', $data);
			
		} else {
			
			$data['error'] = NULL;
			$this->load->view('pms/users/user_sign_in', $data);
		}
	}
	
	
	function addRoomTypeImage($roomTypeId)
	{
		$userId = $this->session->userdata('userid');
		
		if ($userId) {
	
			$userRole = $this->session->userdata('userrole');
				
			if ($userRole != 'Employee') {
			
				$hotel = $this->session->userdata('hotelid');
				
				$roomType = $this->GNM->getInfo($hotel, 'ROOM_TYPE', 'id_room_type', $roomTypeId, null, null, null, 1);
					
				$data['roomType'] = $roomType;
				$data['error']    = NULL;
				
				$this->load->view('pms/rooms/room_type_add_image_view', $data);
			
			} else {
				
				$data['error'] = lang("errorNoPrivileges");
				$data['type']  = 'error_priv';
				
				$this->load->view('pms/error', $data);
			}
		
		} else {
			
			$data['error'] = NULL;
			$this->load->view('pms/users/user_sign_in', $data);
		}
	}
	
	
	function addRoomTypeImage2($roomTypeId)
	{	
		$userId = $this->session->userdata('userid');
		
		if ($userId) {
		
			$userRole = $this->session->userdata('userrole');
				
			if ($userRole != 'Employee') {
			
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
					
					foreach ($data as $row)
					{
						$fullPath = $row['full_path'];
						$filePath = $row['file_path'];
						$fileName = $row['raw_name'];
						$fileExt  = $row['file_ext'];
					}
					
					$newFileName = getNick($fileName);
				
					$config['image_library']  = 'gd2';
					$config['source_image']	  = $fullPath;
					$config['new_image']      = $filePath.'/'.$hotel.'_'.$roomTypeId.'_'.$newFileName.$fileExt;
					$config['maintain_ratio'] = TRUE;
					$config['width']	      = 400;
					$config['height']	      = 400;
					
					$this->load->library('image_lib', $config);
					$this->image_lib->resize();
					
					unlink('./assets/images/'.$fileName.$fileExt);
					
					$data = array(
						'image'        => $hotel.'_'.$roomTypeId.'_'.$newFileName.$fileExt,
						'fk_hotel'     => $hotel,
						'fk_room_type' => $roomTypeId
						);
					
					$this->GNM->insert('IMAGE', $data);  
						
					$data['message']    = lang("addImageMessage");
					$data['type']       = 'room_type_image';
					$data['roomTypeId'] = $roomTypeId;
					
					$this->load->view('pms/success', $data); 
				}
			
			} else {
				
				$data['error'] = lang("errorNoPrivileges");
				$data['type']  = 'error_priv';
				
				$this->load->view('pms/error', $data);
			}
			
		} else {
		
			$data['error'] = NULL;
			$this->load->view('pms/users/user_sign_in', $data);
		}

	}
	
	
	function deleteRoomTypeImage($imageId)
	{
		$userId = $this->session->userdata('userid');
		
		if ($userId) {
			
			$userRole = $this->session->userdata('userrole');
				
			if ($userRole != 'Employee') {
			
				$hotel = $this->session->userdata('hotelid');
				
				$image = $this->GNM->getInfo($hotel, 'IMAGE', 'id_image', $imageId, null, null, null, null);
				
				$this->GNM->delete('IMAGE', 'id_image', $imageId); 
			
				foreach ($image as $row)
				{
					$roomTypeId = $row['fk_room_type'];
					
					unlink('./assets/images/'.$row['image']); 
				}
			
				$data['message']    = lang("deleteImageMessage");
				$data['type']       = 'room_type_image';
				$data['roomTypeId'] = $roomTypeId;
				
				$this->load->view('pms/success', $data); 
				
			} else {
				
				$data['error'] = lang("errorNoPrivileges");
				$data['type']  = 'error_priv';
				
				$this->load->view('pms/error', $data);
			}
		
		} else {
			
			$data['error'] = NULL;
			$this->load->view('pms/users/user_sign_in', $data);
		}
	}
	
	
	function checkRoomNumber($str)
	{
		$roomId = $this->uri->segment(3);
		$hotel  = $this->session->userdata('hotelid');
		
		$rooms = $this->ROM->validationCheckRoom($hotel, 'number', $str, 'id_room !=', $roomId, null);

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