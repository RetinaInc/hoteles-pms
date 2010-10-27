<?php

class Guests extends Controller
{
	function Guests()
	{
		parent::Controller();
		$this->load->model('guests_model','GSM');
		$this->load->model('rooms_model','ROM');
		$this->load->model('reservations_model','REM');
		$this->load->model('general_model','GNM');
		$this->lang->load('form_validation','spanish');
		$this->load->library('form_validation');
		$this->load->library('pagination');
		$this->load->library('session');
		$this->load->helper('language');
		$this->load->helper('hoteles');
		$this->load->helper('form');
		$this->load->helper('date');
		$this->load->helper('url');
	}
	
	function index()
	{
		echo 'guests controller';
	}
	
	
	function guestNames($disable)
	{
		$hotel = $this->session->userdata('hotelid');
		
		$names = $this->GSM->autocompleteGetGuestNames($hotel, $disable);
		
		$i=0;
		foreach ($names as $row)
		{
			$aux[$i]=$row['lastName'].' '.$row['lastName2'].', '.$row['name'].' '.$row['name2'];
			$i++;
		}
		
		if ($names) {
			
			return $aux;
		}
	}
	
	
	function viewGuests()
	{
		$userId = $this->session->userdata('userid');
		
		if ($userId) {

			$hotel = $this->session->userdata('hotelid');
			
			$lim2      = $this->uri->segment(3);
			$totalRows = $this->GSM->getTotalRowsGuests($hotel, null, null, 1);
			
			$config['base_url']    = base_url().'guests/viewGuests';
			$config['total_rows']  = $totalRows;
			$config['per_page']    = '10';
			$config['num_links']   = '50';
			$config['uri_segment'] = 3;
			
			$this->pagination->initialize($config); 
			
			$guests    = $this->GSM->getGuestInfo($hotel, null, null, 'lastName', $config['per_page'], $lim2, 1);
			$guestsDis = $this->GSM->getGuestInfo($hotel, 'G.disable', '0', 'lastName', null, null, null);
			$name_aux  = $this->guestNames('1');
			
			$data['guests']    = $guests;
			$data['guestsDis'] = $guestsDis;
			$data['names']     = $name_aux;
			
			$this->load->view('pms/guests/guests_view', $data);
			
		} else {
			
			$data['error'] = NULL;
			$this->load->view('pms/users/user_sign_in', $data);
		}
	}
	
	
	function viewDisableGuests()
	{
		$userId = $this->session->userdata('userid');
		
		if ($userId) {
		
			$hotel = $this->session->userdata('hotelid');
			
			$lim2      = $this->uri->segment(3);
			$totalRows = $this->GSM->getTotalRowsGuests($hotel, 'G.disable', '0', null);
			
			$config['base_url']    = base_url().'guests/viewDisableGuests';
			$config['total_rows']  = $totalRows;
			$config['per_page']    = '10';
			$config['num_links']   = '50';
			$config['uri_segment'] = 3;
			
			$this->pagination->initialize($config); 
			
			$guestsDis = $this->GSM->getGuestInfo($hotel, 'G.disable', '0', 'lastName', $config['per_page'], $lim2, null);
			$name_aux  = $this->guestNames('0');
			
			$data['guestsDis'] = $guestsDis;
			$data['names']     = $name_aux;
			
			$this->load->view('pms/guests/guests_disable_view', $data);
		
		} else {
		
			$data['error'] = NULL;
			$this->load->view('pms/users/user_sign_in', $data);
		}
	}
	
	
	function infoGuestReservations($guestId)
	{
		$userId = $this->session->userdata('userid');
		
		if ($userId) {
		
			$hotel = $this->session->userdata('hotelid');
		
			$guestId = $this->uri->segment(3);
			$order   = $this->uri->segment(4);
			$lim2    = $this->uri->segment(5);
			
			if (($this->uri->segment(5) == FALSE) && ($this->uri->segment(4) == FALSE)) {
				
				$order = 'checkIn';
				$lim2  = NULL;
			}
			
			if (($this->uri->segment(5) == FALSE) && ($this->uri->segment(4) > 0)) {
				
				$order = 'checkIn';
				$lim2  = $this->uri->segment(4);
			}
			
			$rr        = $this->REM->getReservationInfo($hotel, 'RE.fk_guest', $guestId, null, null, null, null);
			$totalRows = count($rr);
			
			$config['base_url']    = base_url().'guests/infoGuestReservations/'.$guestId.'/'.$order;
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
			
			$guest        = $this->GSM->getGuestInfo($hotel, 'id_guest', $guestId, null, null, null, null);
			$reservations = $this->REM->getReservationInfo($hotel, 'RE.fk_guest', $guestId, $order, $config['per_page'], $lim2, null);
			
			$data['guest']        = $guest;
			$data['reservations'] = $reservations;
			
			$this->load->view('pms/guests/guest_reservations_info_view', $data);
		
		} else {
			
			$data['error'] = NULL;
			$this->load->view('pms/users/user_sign_in', $data);
		}
	}
	
	
	function editGuest($guestId)
	{
		$hotel = $this->session->userdata('hotelid');
		
		$this->form_validation->set_rules('guest_id_type','lang:id_type','trim|xss_clean|required');
		$this->form_validation->set_rules('guest_id_num','lang:id_num','trim|xss_clean|required|max_length[10]|callback_checkGuestId');
		$this->form_validation->set_rules('guest_name','lang:name','trim|xss_clean|required|max_length[30]');
		$this->form_validation->set_rules('guest_name2','lang:name2','trim|xss_clean|max_length[30]');
		$this->form_validation->set_rules('guest_last_name','lang:last_name','trim|xss_clean|required|max_length[30]');
		$this->form_validation->set_rules('guest_last_name2','lang:last_name2','trim|xss_clean|max_length[30]');
		$this->form_validation->set_rules('guest_telephone','lang:telephone','trim|xss_clean|required|numeric|max_length[20]');
		$this->form_validation->set_rules('guest_email','lang:email','trim|xss_clean|required|valid_email|max_length[50]');
		$this->form_validation->set_rules('guest_address','lang:address','trim|xss_clean|max_length[300]');
			
		if ($this->form_validation->run() == FALSE) {
			
			$userId = $this->session->userdata('userid');
		
			if ($userId) {
		
				$guest = $this->GSM->getGuestInfo($hotel, 'id_guest', $guestId, null, null, null, 1);
					
				$data['guest'] = $guest;
		
				$this->load->view('pms/guests/guest_edit_view', $data);
				
			} else {
				
				$data['error'] = NULL;
				$this->load->view('pms/users/user_sign_in', $data);
			}
				
		} else {
			
			$guestIdType    = set_value('guest_id_type');
			$guestIdNum     = set_value('guest_id_num');
			$guestName      = set_value('guest_name');
			$guestName2     = set_value('guest_name2');
			$guestLastName  = set_value('guest_last_name');
			$guestLastName2 = set_value('guest_last_name2');
			$guestTelephone = set_value('guest_telephone');
			$guestEmail     = set_value('guest_email');
			$guestAddress   = set_value('guest_address');
				
			$data = array(
				'idType'    => $guestIdType,
				'idNum'     => $guestIdNum,
				'name'      => ucwords(strtolower($guestName)),
				'name2'     => ucwords(strtolower($guestName2)),
				'lastName'  => ucwords(strtolower($guestLastName)),
				'lastName2' => ucwords(strtolower($guestLastName2)),
				'telephone' => $guestTelephone,
				'email'     => $guestEmail,
				'address'   => $guestAddress
				);
				
			$this->GNM->update('GUEST', 'id_guest', $guestId, $data);  
					
			$this->infoGuestReservations($guestId); 
		}
	}
	
	
	function searchGuest($reservationId)
	{
		$userId = $this->session->userdata('userid');
		
		if ($userId) {
			
			$hotel = $this->session->userdata('hotelid');
			
			$this->form_validation->set_rules('search_guest_id','lang:guest_id','trim|xss_clean|max_length[10]');
			
			if ($this->form_validation->run() == FALSE) {
				
				$reservationRoomInfo  = $this->ROM->getRRInfo($hotel, 'fk_reservation', $reservationId);
				$reservationRoomCount = $this->ROM->getRRCount($hotel, 'fk_reservation', $reservationId, null, null);
			
				$data['error'] = 1;
				$data['reservationId']        = $reservationId;
				$data['reservationRoomInfo']  = $reservationRoomInfo;
				$data['reservationRoomCount'] = $reservationRoomCount;
						
				$this->load->view('pms/reservations/reservation_create_3_view', $data);
			
			} else {
			
				$guestIdNum = set_value('search_guest_id');
				
				if ($guestIdNum != NULL) {
					
					$guest = $this->GSM->getGuestInfo($hotel, 'idNum', $guestIdNum, null, null, null, 1);
					
					if (!$guest) {
						
						$error = lang("errorNoExGuest");
					} 
				} 
				
				$reservationRoomInfo  = $this->ROM->getRRInfo($hotel, 'fk_reservation', $reservationId);
				$reservationRoomCount = $this->ROM->getRRCount($hotel, 'fk_reservation', $reservationId, null, null);
			
				$data['error']                = $error;
				$data['guest']                = $guest;
				$data['reservationId']        = $reservationId;
				$data['reservationRoomInfo']  = $reservationRoomInfo;
				$data['reservationRoomCount'] = $reservationRoomCount;
						
				$this->load->view('pms/reservations/reservation_create_3_view', $data);
			}
		
		} else {
			
			$data['error'] = NULL;
			$this->load->view('pms/users/user_sign_in', $data);
		}
	}
	
	
	function disableGuest($guestId)
	{
		$userId = $this->session->userdata('userid');
		
		if ($userId) {
		
			$hotel = $this->session->userdata('hotelid');
			
			$guestReservation = $this->REM->getReservationInfo($hotel, 'RE.fk_guest', $guestId, null, null, null, 1);
			
			$datestring = "%Y-%m-%d  %h:%i %a";
			$time       = time();
			$date       = mdate($datestring, $time);
			
			$delete    = 'Yes';
			$iniResNum = array();
			
			foreach ($guestReservation as $row) {
			
				$resNum   = $row['id_reservation'];
				$checkIn  = $row['checkIn'];
				$checkOut = $row['checkOut'];
				$status   = $row['status'];
	
				if (  (($checkIn > $date) && ($status != 'Canceled') && ($status != 'No Show')) 
				   || (($checkIn < $date) && ($date < $checkOut) && ($status != 'Canceled') && ($status != 'No Show'))
				   ) {
					
					$delete = 'No';
					
					$newResNum = array ($resNum);
					$result    = array_merge($iniResNum, $newResNum);
					$iniResNum = $result;
					
					//echo 'new: ', print_r($new_res_num). "<br>";
					//echo 'res: ', print_r($result). "<br>";
					//echo 'ini: ', print_r($ini_res_num). "<br>";
				}
			}
			
			if ($delete == 'No') {
			
				$data['error']  = lang("errorPendingReservation");
				$data['result'] = $result;
				$data['type']   = 'error_guest';
				
				$this->load->view('pms/error', $data);
				
			} else {
			
				$this->GNM->disable('GUEST', 'id_guest', $guestId);
				
				$data['message'] = lang("disableGuestMessage");
				$data['type'] = 'guests';
				
				$this->load->view('pms/success', $data);
			}	
			
		} else {
		
			$data['error'] = NULL;
			$this->load->view('pms/users/user_sign_in', $data);
		}
	}
	
	
	function enableGuest($guestId)
	{
		$userId = $this->session->userdata('userid');
		
		if ($userId) {
		
			$data = array(
					'disable' => 1
					);
				
			$this->GNM->update('GUEST', 'id_guest', $guestId, $data);  
				
			$data['message'] = lang("enableGuestMessage");
			$data['type'] = 'guests';
				
			$this->load->view('pms/success', $data);	
		
		} else {
		
			$data['error'] = NULL;
			$this->load->view('pms/users/user_sign_in', $data);
		}	
	}
	
	
	function searchGuests()
	{	
		$this->form_validation->set_rules('search','lang:search','trim|xss_clean|required|max_length[150]');
		
		if ($this->form_validation->run() == FALSE) {
		
			$this->viewGuests();
			
		} else {
		
				$hotel = $this->session->userdata('hotelid');
				
				$searchString = set_value('search');
			
				$searchName = ucwords(strtolower($searchString));
			
				$result = $this->GSM->getSearchGuest($hotel, $searchName, $page=-1);
			
				$guests = $this->GSM->getGuestInfo($hotel, null, null, 'lastName', null, null, 1);
				$nameAux = $this->guestNames();
			
				$data['names']      = $nameAux;
				$data['guests']     = $guests;
				$data['searchName'] = $searchName;
				$data['result']     = $result;
		
				$this->load->view('pms/guests/guest_search_view',$data);
		}
	}
	
	
	function checkGuestId($str)
	{
		$guestId = $this->uri->segment(3);
		$hotel   = $this->session->userdata('hotelid');
		
		$guests = $this->GSM->validationCheckGuest($hotel, 'idNum', $str, 'id_guest !=', $guestId, null);

		if ($guests) {
		
			$this->form_validation->set_message('checkGuestId', lang("errorId"));
			return FALSE;
			
		} else {
		
			return TRUE;
		}
	}




}
?>