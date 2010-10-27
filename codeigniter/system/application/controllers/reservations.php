<?php

class Reservations extends Controller
{
    function Reservations()
	{
        parent::Controller();
		$this->load->model('general_model','GNM');
		$this->load->model('reservations_model','REM');
		$this->load->model('rooms_model','ROM');
	    $this->load->model('guests_model','GSM');
		$this->load->model('prices_model','PRM');
		$this->load->model('seasons_model','SEM');
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
		echo 'reservations controller';
	}
	
	
	function checkReservations()
	{
		$userId = $this->session->userdata('userid');
		
		if ($userId) {
			
			$hotel = $this->session->userdata('hotelid');
			
			$datestring = "%Y-%m-%d";
			$time       = time();
			$date       = mdate($datestring, $time);
			
			$reservations = $this->REM->getNoShows($hotel, $date);
			
			if ($reservations) {
				
				foreach ($reservations as $row) {
				
					$reservationId = $row['id_reservation'];
					
					$data = array(
						'status'  => 'No Show'
						);
					
					$this->GNM->update('RESERVATION', 'id_reservation', $reservationId, $data); 
				}
			} 
			
		} else {
			
			$data['error'] = NULL;
			$this->load->view('pms/users/user_sign_in', $data);
		}
	}
	
	
	function viewPendingReservations()
	{
		$userId = $this->session->userdata('userid');
		
		if ($userId) {
		
			$this->checkReservations();
			
			$hotel = $this->session->userdata('hotelid');
			
			$datestring = "%Y-%m-%d";
			$time       = time();
			$date       = mdate($datestring, $time);
			
			$order     = $this->uri->segment(3);
			$lim2      = $this->uri->segment(4);
			
			if (($this->uri->segment(4) == FALSE) && ($this->uri->segment(3) == FALSE)) {
				
				$order = 'checkIn';
				$lim2  = NULL;
			}
			
			if (($this->uri->segment(4) == FALSE) && ($this->uri->segment(3) > 0)) {
				
				$order = 'checkIn';
				$lim2  = $this->uri->segment(3);
			}
			
			$totalRows = $this->REM->getTotalRowsReservations($hotel, 'RE.status', 'Reserved', null, null, 1);
			
			$config['base_url'] = base_url().'reservations/viewPendingReservations/'.$order;
			$config['total_rows'] = $totalRows;
			$config['per_page'] = '10';
			$config['num_links'] = '50';
			$config['uri_segment'] = 4;
			
			$this->pagination->initialize($config); 
			
			if ($order == NULL){
			
				$order = 'checkIn';
			}
			
			$exRooms          = $this->ROM->getRoomInfo($hotel, null, null, null, null, null, 1);
			$exSeasons        = $this->GNM->getInfo($hotel, 'SEASON', null, null, null, null, null, 1);
			$exRates          = $this->GNM->getInfo($hotel, 'RATE',   null, null, null, null, null, 1);
			$exPlans          = $this->GNM->getInfo($hotel, 'PLAN',   null, null, null, null, null, 1);
			$rooms            = $this->ROM->getRoomReservationsGuest($hotel, null, null, null, null, null);
			$guests           = $this->GSM->getGuestInfo($hotel, null, null, null, null, null, null);
			$penReservations  = $this->REM->getReservationInfo($hotel, 'RE.status', 'Reserved', $order, $config['per_page'], $lim2, 1);
			$prevReservations = $this->REM->getReservationInfo($hotel, 'RE.status',  'Checked Out', $order, null, null, 1);
			$canReservations  = $this->REM->getReservationInfo($hotel, 'RE.status',  'Canceled',    null,   null, null, 1);
			$noShows          = $this->REM->getReservationInfo($hotel, 'RE.status',  'No Show',     null,   null, null, 1);
			
			$data['exRooms']          = $exRooms;
			$data['exSeasons']        = $exSeasons;
			$data['exRates']          = $exRates;
			$data['exPlans']          = $exPlans;
			$data['rooms']            = $rooms;
			$data['guests']           = $guests;
			$data['penReservations']  = $penReservations;
			$data['prevReservations'] = $prevReservations;
			$data['canReservations']  = $canReservations;
			$data['noShows']          = $noShows;
			
			$this->load->view('pms/reservations/reservations_pending_view', $data);
		
		} else {
			
			$data['error'] = NULL;
			$this->load->view('pms/users/user_sign_in', $data);
		}
	}
	

    function viewPreviousReservations()
	{
		$userId = $this->session->userdata('userid');
		
		if ($userId) {
	
			$hotel = $this->session->userdata('hotelid');
			
			$datestring = "%Y-%m-%d";
			$time       = time();
			$date       = mdate($datestring, $time);
			
			$order     = $this->uri->segment(3);
			$lim2      = $this->uri->segment(4);
			
			if (($this->uri->segment(4) == FALSE) && ($this->uri->segment(3) == FALSE)) {
				
				$order = 'checkIn';
				$lim2  = NULL;
			}
			
			if (($this->uri->segment(4) == FALSE) && ($this->uri->segment(3) > 0)) {
				
				$order = 'checkIn';
				$lim2  = $this->uri->segment(3);
			}
			
			$totalRows = $this->REM->getTotalRowsReservations($hotel, 'checkIn <', $date, null, null, 1);
			
			$config['base_url'] = base_url().'reservations/viewPreviousReservations/'.$order;
			$config['total_rows'] = $totalRows;
			$config['per_page'] = '15';
			$config['num_links'] = '50';
			$config['uri_segment'] = 4;
			
			$this->pagination->initialize($config); 
			
			if (($order == NULL) || ($order == 'checkIn')){
			
				$order = 'checkIn DESC';
			}
			if ($order == 'checkOut'){
			
				$order = 'checkOut DESC';
			}
			
			$rooms        = $this->ROM->getRoomReservationsGuest($hotel, null, null, null, null, null);
			$guests       = $this->GSM->getGuestInfo($hotel, null, null, null, null, null, null);
			$reservations = $this->REM->getReservationInfo($hotel, 'RE.status',  'Checked Out', $order, null, null, 1);
			
			$data['rooms']        = $rooms;
			$data['guests']       = $guests;
			$data['reservations'] = $reservations;
			
			$this->load->view('pms/reservations/reservations_previous_view', $data);
			
		} else {
		
			$data['error'] = NULL;
			$this->load->view('pms/users/user_sign_in', $data);
		}
	}
	
	
	function viewCanceledReservations()
	{
		$userId = $this->session->userdata('userid');
		
		if ($userId) {
	
			$hotel = $this->session->userdata('hotelid');
			
			$order     = $this->uri->segment(3);
			$lim2      = $this->uri->segment(4);
			
			if (($this->uri->segment(4) == FALSE) && ($this->uri->segment(3) == FALSE)) {
				
				$order = 'checkIn';
				$lim2  = NULL;
			}
			
			if (($this->uri->segment(4) == FALSE) && ($this->uri->segment(3) > 0)) {
				
				$order = 'checkIn';
				$lim2  = $this->uri->segment(3);
			}
			
			$totalRows = $this->REM->getTotalRowsReservations($hotel, 'RE.status', 'Canceled', null, null, 1);
			
			$config['base_url'] = base_url().'reservations/viewCanceledReservations/'.$order;
			$config['total_rows'] = $totalRows;
			$config['per_page'] = '15';
			$config['num_links'] = '50';
			$config['uri_segment'] = 4;
			
			$this->pagination->initialize($config); 
			
			if (($order == NULL) || ($order == 'checkIn')){
			
				$order = 'checkIn DESC';
			}
			if ($order == 'checkOut'){
			
				$order = 'checkOut DESC';
			}
			
			$rooms        = $this->ROM->getRoomReservationsGuest($hotel, null, null, null, null, null);
			$guests       = $this->GSM->getGuestInfo($hotel, null, null, null, null, null, null);
			$reservations = $this->REM->getReservationInfo($hotel, 'RE.status', 'Canceled', $order, $config['per_page'], $lim2, 1);
			
			$data['rooms']        = $rooms;
			$data['guests']       = $guests;
			$data['reservations'] = $reservations;
			
			$this->load->view('pms/reservations/reservations_canceled_view', $data);
			
		} else {
		
			$data['error'] = NULL;
			$this->load->view('pms/users/user_sign_in', $data);
		}
	}
	
	
	function viewNoShows()
	{
		$userId = $this->session->userdata('userid');
		
		if ($userId) {
	
			$hotel = $this->session->userdata('hotelid');
			
			$datestring = "%Y-%m-%d";
			$time       = time();
			$date       = mdate($datestring, $time);
			
			$order     = $this->uri->segment(3);
			$lim2      = $this->uri->segment(4);
			
			if (($this->uri->segment(4) == FALSE) && ($this->uri->segment(3) == FALSE)) {
				
				$order = 'checkIn';
				$lim2  = NULL;
			}
			
			if (($this->uri->segment(4) == FALSE) && ($this->uri->segment(3) > 0)) {
				
				$order = 'checkIn';
				$lim2  = $this->uri->segment(3);
			}
			
			$totalRows = $this->REM->getTotalRowsReservations($hotel, 'RE.status', 'No Show', null, null, 1);
			
			$config['base_url'] = base_url().'reservations/viewNoShows/'.$order;
			$config['total_rows'] = $totalRows;
			$config['per_page'] = '15';
			$config['num_links'] = '50';
			$config['uri_segment'] = 4;
			
			$this->pagination->initialize($config); 
			
			if (($order == NULL) || ($order == 'checkIn')){
			
				$order = 'checkIn DESC';
			}
			if ($order == 'checkOut'){
			
				$order = 'checkOut DESC';
			}
			
			$rooms        = $this->ROM->getRoomReservationsGuest($hotel, null, null, null, null, null);
			$guests       = $this->GSM->getGuestInfo($hotel, null, null, null, null, null, null);
			$reservations = $this->REM->getReservationInfo($hotel, 'RE.status', 'No Show', $order, $config['per_page'], $lim2, 1);
			
			$data['rooms']        = $rooms;
			$data['guests']       = $guests;
			$data['reservations'] = $reservations;
			
			$this->load->view('pms/reservations/reservations_no_shows_view', $data);
			
		} else {
		
			$data['error'] = NULL;
			$this->load->view('pms/users/user_sign_in', $data);
		}
	}
	
	
	function viewAllReservations()
	{
		$userId = $this->session->userdata('userid');
		
		if ($userId) {
	
			$hotel = $this->session->userdata('hotelid');
			
			$datestring = "%Y-%m-%d";
			$time       = time();
			$date       = mdate($datestring, $time);
			
			$order     = $this->uri->segment(3);
			$lim2      = $this->uri->segment(4);
			
			if (($this->uri->segment(4) == FALSE) && ($this->uri->segment(3) == FALSE)) {
				
				$order = 'checkIn';
				$lim2  = NULL;
			}
			
			if (($this->uri->segment(4) == FALSE) && ($this->uri->segment(3) > 0)) {
				
				$order = 'checkIn';
				$lim2  = $this->uri->segment(3);
			}
			
			$totalRows = $this->REM->getTotalRowsReservations($hotel, null, null, null, null, 1);
			
			$config['base_url'] = base_url().'reservations/viewAllReservations/'.$order;
			$config['total_rows'] = $totalRows;
			$config['per_page'] = '15';
			$config['num_links'] = '50';
			$config['uri_segment'] = 4;
			
			$this->pagination->initialize($config); 
			
			if (($order == NULL) || ($order == 'checkIn')){
			
				$order = 'checkIn DESC';
			}
			if ($order == 'checkOut'){
			
				$order = 'checkOut DESC';
			}
			
			$rooms        = $this->ROM->getRoomReservationsGuest($hotel, null, null, null, null, null);
			$guests       = $this->GSM->getGuestInfo($hotel, null, null, null, null, null, null);
			$reservations = $this->REM->getReservationInfo($hotel, null, null, $order, $config['per_page'], $lim2, 1);
			
			$data['rooms']        = $rooms;
			$data['guests']       = $guests;
			$data['reservations'] = $reservations;
			
			$this->load->view('pms/reservations/reservations_all_view', $data);
			
		} else {
		
			$data['error'] = NULL;
			$this->load->view('pms/users/user_sign_in', $data);
		}
	}
	
	
	function viewCheckedIn()
	{
		$userId = $this->session->userdata('userid');
		
		if ($userId) {
		
			$hotel = $this->session->userdata('hotelid');
			
			$order     = $this->uri->segment(3);
			$lim2      = $this->uri->segment(4);
			
			if (($this->uri->segment(4) == FALSE) && ($this->uri->segment(3) == FALSE)) {
				
				$order = 'checkIn';
				$lim2  = NULL;
			}
			
			if (($this->uri->segment(4) == FALSE) && ($this->uri->segment(3) > 0)) {
				
				$order = 'checkIn';
				$lim2  = $this->uri->segment(3);
			}
			
			$totalRows = $this->REM->getTotalRowsReservations($hotel, 'RE.status', 'Checked In', null, null, 1);
			
			$config['base_url'] = base_url().'reservations/viewCheckedIn/'.$order;
			$config['total_rows'] = $totalRows;
			$config['per_page'] = '10';
			$config['num_links'] = '50';
			$config['uri_segment'] = 4;
			
			$this->pagination->initialize($config); 
			
			if (($order == NULL) || ($order == 'checkIn')){
			
				$order = 'checkIn DESC';
			}
			if ($order == 'checkOut'){
			
				$order = 'checkOut DESC';
			}
			
			$guests    = $this->GSM->getGuestInfo($hotel, null, null, null, null, null, null);
			$checkedIn = $this->REM->getReservationInfo($hotel, 'RE.status', 'Checked In', $order, $config['per_page'], $lim2, 1);
			
			$data['guests']    = $guests;
			$data['checkedIn'] = $checkedIn;
			
			$this->load->view('pms/reservations/reservations_checked_in_view', $data);
		
		} else {
			
			$data['error'] = NULL;
			$this->load->view('pms/users/user_sign_in', $data);
		}
	}
	
	
	function viewCheckIns()
	{
		$userId = $this->session->userdata('userid');
		
		if ($userId) {
			
			$hotel = $this->session->userdata('hotelid');
			
			$datestring = "%Y-%m-%d";
			$time       = time();
			$today      = mdate($datestring, $time);
			
			$checkInDate = $this->uri->segment(3);
			$order       = $this->uri->segment(4);
			$lim2        = $this->uri->segment(5);
			
			$error = NULL;
			
			if ($checkInDate == 'date') {
				
				if (isset($_POST["check_in_date"])) {
			
					$ciDate = $_POST["check_in_date"];
					
					if ($ciDate == NULL) {
					
						$checkInDate = $today;
						
					} else {
					
						$validate = $this->validDate($ciDate);
						
						if ($validate == TRUE) {
						
							$ci_array = explode('-', $ciDate);
							$day   = $ci_array[0];
							$month = $ci_array[1];
							$year  = $ci_array[2];
							$checkInDate = $year.'-'.$month.'-'.$day;
						}
						
						else {
						
							$error       = lang("errorValidDate");
							$checkInDate = $today;
						}
					}
					
				} else {
				
					$checkInDate = $today;
				}
			} 
			
			if (($this->uri->segment(5) == FALSE) && ($this->uri->segment(4) == FALSE)) {
				
				$order = 'checkOut';
				$lim2  = NULL;
			}
			
			if (($this->uri->segment(5) == FALSE) && ($this->uri->segment(4) > 0)) {
				
				$order = 'checkOut';
				$lim2  = $this->uri->segment(4);
			}
			
			$validate = $this->validDateY($checkInDate);
			
			if ($validate == FALSE) {
				
				$error       = lang("errorValidDate");
				$checkInDate = $today;	
			} 
			
			$totalRows   = $this->REM->getTotalRowsReservations($hotel, 'checkIn', $checkInDate, null, null, 1);
			
			$config['base_url']    = base_url().'reservations/viewCheckIns/'.$checkInDate.'/'.$order;
			$config['total_rows']  = $totalRows;
			$config['per_page']    = '10';
			$config['num_links']   = '50';
			$config['uri_segment'] = 5;
			
			$this->pagination->initialize($config); 
			
			if ($order == NULL){
			
				$order = 'checkOut';
			}
			
			$guests       = $this->GSM->getGuestInfo($hotel, null, null, null, null, null, null);
			$reservations = $this->REM->getReservationInfo($hotel, null, null, null, null, null, 1);
			
			$iniResId = array();
			$resIds   = array();
			
			foreach ($reservations as $row) {
				
				$resId       = $row['id_reservation'];
				$resStatus   = $row['status'];
				$resCIInfo   = $row['checkIn'];
				$resCI_array = explode(' ', $resCIInfo);
				$resCIDate   = $resCI_array[0];
				
				if (($resCIDate == $checkInDate) && ($resStatus != 'Canceled') && ($resStatus != 'No Show')) {
						
					$newResId  = array ($resId);
					$resIds    = array_merge($iniResId, $newResId);
					$iniResNum = $resIds;
				}
			}
			
			$data['guests']      = $guests;
			$data['checkInDate'] = $checkInDate;
			$data['resIds']      = $resIds;
			$data['error']       = $error;
			
			$this->load->view('pms/reservations/reservations_check_ins_view', $data);
			
		} else {
			
			$data['error'] = NULL;
			$this->load->view('pms/users/user_sign_in', $data);
		}
	}
	
	
	function viewCheckOuts()
	{
		$userId = $this->session->userdata('userid');
		
		if ($userId) {
		
			$hotel = $this->session->userdata('hotelid');
			
			$datestring = "%Y-%m-%d";
			$time       = time();
			$today      = mdate($datestring, $time);
			
			$checkOutDate = $this->uri->segment(3);
			$order        = $this->uri->segment(4);
			$lim2         = $this->uri->segment(5);
			
			$error = NULL;
			
			if ($checkOutDate == 'date') {
				
				if (isset($_POST["check_out_date"])) {
			
					$coDate = $_POST["check_out_date"];
					
					if ($coDate == NULL) {
					
						$checkOutDate = $today;
						
					} else {
					
						$validate = $this->validDate($coDate);
						
						if ($validate == TRUE) {
						
							$co_array = explode('-', $coDate);
							$day   = $co_array[0];
							$month = $co_array[1];
							$year  = $co_array[2];
							$checkOutDate = $year.'-'.$month.'-'.$day;
						
						} else {
						
							$error        = lang("errorValidDate");
							$checkOutDate = $today;
						}
					}
					
				} else {
				
					$checkOutDate = $today;
				}
			}
		
			if (($this->uri->segment(5) == FALSE) && ($this->uri->segment(4) == FALSE)) {
				
				$order = 'checkIn';
				$lim2  = NULL;
			}
			
			if (($this->uri->segment(5) == FALSE) && ($this->uri->segment(4) > 0)) {
				
				$order = 'checkIn';
				$lim2  = $this->uri->segment(4);
			}
			
			$validate = $this->validDateY($checkOutDate);
			
			if ($validate == FALSE) {
				
				$error        = lang("errorValidDate");
				$checkOutDate = $today;	
			}
			
			$totalRows = $this->REM->getTotalRowsReservations($hotel, 'checkOut', $checkOutDate, null, null, 1);
			
			$config['base_url']    = base_url().'reservations/viewCheckOuts/'.$checkOutDate.'/'.$order;
			$config['total_rows']  = $totalRows;
			$config['per_page']    = '10';
			$config['num_links']   = '50';
			$config['uri_segment'] = 5;
			
			$this->pagination->initialize($config); 
			
			if ($order == NULL){
			
				$order = 'checkIn';
			}
			
			$guests       = $this->GSM->getGuestInfo($hotel, null, null, null, null, null, null);
			$reservations = $this->REM->getReservationInfo($hotel, null, null, null, null, null, 1);
			
			$iniResId = array();
			$resIds   = array();
			
			foreach ($reservations as $row) {
				
				$resId       = $row['id_reservation'];
				$resStatus   = $row['status'];
				$resCOInfo   = $row['checkOut'];
				$resCO_array = explode(' ', $resCOInfo);
				$resCODate   = $resCO_array[0];
				
				if (($resCODate == $checkOutDate) && ($resStatus != 'Canceled') && ($resStatus != 'No Show')) {
						
					$newResId  = array ($resId);
					$resIds    = array_merge($iniResId, $newResId);
					$iniResNum = $resIds;
				}
			}
			
			$data['guests']       = $guests;
			$data['checkOutDate'] = $checkOutDate;
			$data['resIds']       = $resIds;
			$data['error']        = $error;
			
			$this->load->view('pms/reservations/reservations_check_outs_view', $data);
			
		} else {
		
			$data['error'] = NULL;
			$this->load->view('pms/users/user_sign_in', $data);
		}
	}
	
	
	function checkInReservation($reservationId)
	{
		$userId = $this->session->userdata('userid');
		
		if ($userId) {
		
			$datestring = "%Y-%m-%d %h:%i";
			$time       = time();
			$nowTime    = mdate($datestring, $time);
		
			$data = array(
				'checkIn' => $nowTime,
				'status'  => 'Checked In'
					);
			
			$this->GNM->update('RESERVATION', 'id_reservation', $reservationId, $data);  
			
			$message = lang("checkInReservationMessage");
			
			$this->infoReservation($reservationId, $message);
			
		} else {
		
			$data['error'] = NULL;
			$this->load->view('pms/users/user_sign_in', $data);
		}
	}
	
	
	function checkOutReservation($reservationId)
	{
		$userId = $this->session->userdata('userid');
		
		if ($userId) {
		
			$datestring = "%Y-%m-%d %h:%i";
			$time       = time();
			$nowTime    = mdate($datestring, $time);
		
			$data = array(
				'checkOut' => $nowTime,
				'status'   => 'Checked Out'
					);
			
			$this->GNM->update('RESERVATION', 'id_reservation', $reservationId, $data);  
			
			$message = lang("checkOutReservationMessage");
			
			$this->infoReservation($reservationId, $message);
			
		} else {
		
			$data['error'] = NULL;
			$this->load->view('pms/users/user_sign_in', $data);
		}
	}
	
	
	function infoReservation($reservationId, $message)
	{
		$userId = $this->session->userdata('userid');
		
		if ($userId) {

			if (isset($message)) {
			
				if ($message == 'n') {
					
					$message = NULL;
				}
				
			} else {
			
				$message = NULL;
			}
			
			$hotel = $this->session->userdata('hotelid');
			
			$room                 = $this->ROM->getRoomReservationsGuest($hotel, 'id_reservation', $reservationId, null, null, null);
			$reservationRoomCount = $this->ROM->getRRCount($hotel, 'fk_reservation', $reservationId, null, null);
			$reservationRoomInfo  = $this->ROM->getRRInfo($hotel, 'fk_reservation', $reservationId);
			$reservation = $this->REM->getReservationInfo($hotel, 'id_reservation', $reservationId, null, null, null, 1);
			$payments    = $this->REM->getPaymentInfo($hotel, null, null, $reservationId);
			
			foreach ($reservation as $row) {
			
				$guestId  = $row['fk_guest'];
				$checkIn  = $row['checkIn'];
				$checkOut = $row['checkOut'];
				
				$checkIn_array = explode (' ',$checkIn);
				$ciDate = $checkIn_array[0];
		
				$checkOut_array = explode (' ',$checkOut);
				$coDate = $checkOut_array[0];
				
				$nights = (strtotime($coDate) - strtotime($ciDate)) / (60 * 60 * 24);
			}
			
			$guest      = $this->GSM->getGuestInfo($hotel, 'id_guest', $guestId, null, null, null, null);
			$otherGuest = $this->GSM->getOtherGuestInfo($hotel, 'OG.fk_reservation', $reservationId, null, null, null);
			
			$data['room']        = $room;
			$data['guest']       = $guest;
			$data['nights']      = $nights;
			$data['message']     = $message;
			$data['payments']    = $payments;
			$data['otherGuest']  = $otherGuest;
			$data['reservation'] = $reservation;
			$data['reservationRoomInfo']  = $reservationRoomInfo;
			$data['reservationRoomCount'] = $reservationRoomCount;
			
			$this->load->view('pms/reservations/reservation_info_view', $data);
			
		} else {
		
			$data['error'] = NULL;
			$this->load->view('pms/users/user_sign_in', $data);
		}
	}
	
	
	function cancelReservation($reservationId, $guestId)
	{
		$userId = $this->session->userdata('userid');
		
		if ($userId) {
		
			$hotel = $this->session->userdata('hotelid');
			
			$data = array(
					'status' => 'Canceled'
					);
					
			$this->GNM->update('RESERVATION', 'id_reservation', $reservationId, $data);  
					
			$message = lang("cancelReservationMessage");
			
			$this->infoReservation($reservationId, $message);
		
		} else {
			
			$data['error'] = NULL;
			$this->load->view('pms/users/user_sign_in', $data);
		}
	}
	
	
	function getPrice($checkIn, $checkOut, $rate, $plan, $roomTypeId, $type)
	{	
		$hotel = $this->session->userdata('hotelid');
		
		$priceAdult = NULL;
		$priceChild = NULL;
		$priceAdu   = NULL;
		$priceChi   = NULL;
		$priceAPD   = NULL;
		$priceCPN   = NULL;
		
		$seasonDef = 'Yes';
		$priceDef  = 'Yes';
		
		$date       = $checkIn;
		$nights     = (strtotime($checkOut) - strtotime($checkIn)) / (60 * 60 * 24);

		$ci_array  = explode ('-',$checkIn);
		$yearI     = $ci_array[0];
		$monthI    = $ci_array[1];
		$dayI      = $ci_array[2];
		
		for ($i=1; $i<=$nights; $i++) {	
			
			$seasonId  = NULL;
			
			$season = $this->SEM->getInSeason($hotel, $date, NULL, NULL, NULL);
			$rows   = count($season);
		
			if ($rows == 1) {
				foreach ($season as $row) {
					$seasonId = $row['id_season'];
				}
			}
			if ($rows == 2) {
				foreach ($season as $row) {
					if ($row['fk_season'] != NULL) {
						$seasonId = $row['id_season'];
					}
				}
			}
			if ($rows == 3) {
				foreach ($season as $row) {
					foreach ($season as $row1) {
						if (($row1['fk_season'] == $row['id_season']) && ($row['fk_season'] != NULL)) {
							$seasonId = $row1['id_season'];
						}
					}
				}
			}

			if ($seasonId == NULL) {
			
				$seasonDef = 'No';
				break;
			} 

			if ($seasonDef == 'Yes') {
			
				$priceAdu = $this->PRM->getPriceInfo($seasonId, $rate, $plan, $roomTypeId, 'Adults');
				$priceChi = $this->PRM->getPriceInfo($seasonId, $rate, $plan, null,        'Children');
			
				if ($priceAdu) {
					
					foreach ($priceAdu as $row) {
				
						if ($row['hasWeekdays'] == 'No') {
						
							$priceAPN = $row['pricePerNight'];
							
						} else {
						
							 $dateDay = date('l', strtotime($date));
							 
							 if ($dateDay == 'Monday') {
								$priceAPN = $row['monPrice'];
							 }
							 if ($dateDay == 'Tuesday') {
								$priceAPN = $row['tuePrice'];
							 }
							 if ($dateDay == 'Wednesday') {
								$priceAPN = $row['wedPrice'];
							 }
							 if ($dateDay == 'Thursday') {
								$priceAPN = $row['thuPrice'];
							 }
							 if ($dateDay == 'Friday') {
								$priceAPN = $row['friPrice'];
							 }
							 if ($dateDay == 'Saturday') {
								$priceAPN = $row['satPrice'];
							 }
							 if ($dateDay == 'Sunday') {
								$priceAPN = $row['sunPrice'];
							 }
						}
					}
					
				} else {
				
					$priceAPN = NULL;
				}
				
				if ($priceChi) {
					
					foreach ($priceChi as $row){
				
						if ($row['hasWeekdays'] == 'No') {
						
							$priceCPN = $row['pricePerNight'];
							
						} else {
						
							$dateDay = date('l', strtotime($date));
							
							 if ($dateDay == 'Monday') {
								$priceCPN = $row['monPrice'];
							 }
							 if ($dateDay == 'Tuesday') {
								$priceCPN = $row['tuePrice'];
							 }
							 if ($dateDay == 'Wednesday') {
								$priceCPN = $row['wedPrice'];
							 }
							 if ($dateDay == 'Thursday') {
								$priceCPN = $row['thuPrice'];
							 }
							 if ($dateDay == 'Friday') {
								$priceCPN = $row['friPrice'];
							 }
							 if ($dateDay == 'Saturday') {
								$priceCPN = $row['satPrice'];
							 }
							 if ($dateDay == 'Sunday') {
								$priceCPN = $row['sunPrice'];
							 }
						}
					}
				
				} else {
				
					$priceCPN = NULL;
				}
				
				
				if (($priceAPN == NULL) || ($priceCPN == NULL)) {
					
					$priceDef = 'No';
					break;
				
				} else { 
					
					$priceAdult = $priceAdult + $priceAPN;
					$priceChild = $priceChild + $priceCPN;
					
					$dateUnix = mktime(0,0,0,date($monthI),date($dayI)+$i,date($yearI));
					$date = date("Y-m-d", $dateUnix);
				} 
			}	
			
		} 
		
		if (($seasonDef == 'No') || ($priceDef == 'No')) {
		
			return 'error';

		} else {
			
			if ($type == 'Adults') {
			
				return $priceAdult;
			}
			
			if ($type == 'Children') {
				
				return $priceChild;
			}
		}
	}

	
	function createReservation1()
	{
		$userId = $this->session->userdata('userid');
		
		if ($userId) {
		
			$this->deleteQuotations();
			
			$hotel = $this->session->userdata('hotelid');
			
			$this->form_validation->set_rules('reservation_rate','lang:rate','trim|xss_clean|required');
			$this->form_validation->set_rules('reservation_plan','lang:plan','trim|xss_clean|required');
			$this->form_validation->set_rules('reservation_check_in','lang:check_in','trim|xss_clean|required|max_length[15]|callback_validDate');
			$this->form_validation->set_rules('reservation_check_out','lang:check_out','trim|xss_clean|required|max_length[15]|callback_validDate');
			$this->form_validation->set_rules('reservation_room_count','lang:room_count','trim|xss_clean|required');
				
			if ($this->form_validation->run() == FALSE) {
				
				$rates = $this->GNM->getInfo($hotel, 'RATE', null, null, null, null, null, 1);
				$plans = $this->GNM->getInfo($hotel, 'PLAN', null, null, null, null, null, 1);
			
				$data['rates'] = $rates;
				$data['plans'] = $plans;
				$data['error'] = 1;
			
				$this->load->view('pms/reservations/reservation_create_1_view', $data);
			
			} else {
			
				$reservationRate      = set_value('reservation_rate');
				$reservationPlan      = set_value('reservation_plan');
				$reservationCheckIn   = set_value('reservation_check_in');
				$reservationCheckOut  = set_value('reservation_check_out');
				$reservationRoomCount = set_value('reservation_room_count');
				
				$ci_array = explode ('-',$reservationCheckIn);
				$day      = $ci_array[0];
				$month    = $ci_array[1];
				$year     = $ci_array[2];
				$checkIn  = $year.'-'.$month.'-'.$day;
				
				$co_array = explode ('-',$reservationCheckOut);
				$day      = $co_array[0];
				$month    = $co_array[1];
				$year     = $co_array[2];
				$checkOut = $year.'-'.$month.'-'.$day;
				
				$datestring = "%Y-%m-%d";
				$time       = time();
				$now        = mdate($datestring, $time);
				
				if (($checkOut <= $checkIn) || ($checkIn < $now)) {
				
					$rates = $this->GNM->getInfo($hotel, 'RATE', null, null, null, null, null, 1);
					$plans = $this->GNM->getInfo($hotel, 'PLAN', null, null, null, null, null, 1);
					
					if ($checkOut <= $checkIn) {
						$error = lang("errorCheckInOutDates");
					}
					
					if ($checkIn < $now) {
						$error = lang("errorCheckInToday");
					}
				
					$data['error'] = $error;
					$data['rates'] = $rates;
					$data['plans'] = $plans;
				
					$this->load->view('pms/reservations/reservation_create_1_view', $data);
					
				} else {
					
					$error = NULL;
					
					$datestring = "%Y-%m-%d %h:%i";
					$time       = time();
					$nowTime    = mdate($datestring, $time);
		
					$data = array(
						'resDate'     => $nowTime,
						'status'      => 'Quotation',
						'checkIn'     => $checkIn,
						'checkOut'    => $checkOut,
						'details'     => NULL,
						'paymentStat' => 'Not paid',
						'billingStat' => 'Not billed',
						'fk_rate'     => $reservationRate,
						'fk_plan'     => $reservationPlan,
						'fk_guest'    => NULL
						);
					
					$this->GNM->insert('RESERVATION', $data);  
				
					$reservationId = $this->db->insert_id('RESERVATION');
					
					for ($i=1; $i<=$reservationRoomCount; $i++) {
						
						$valA = 'reservation_adults'.$i;
						$adults = $_POST[$valA];
						
						$valC = 'reservation_children'.$i;
						$children = $_POST[$valC];
						
						$totalPers = $adults + $children;
						$pers = $totalPers;
						$asRoom = NULL;
						
						while (!$asRoom) {
					
							$asRoomType = $this->ROM->getAsRoomType($hotel, $pers, $totalPers);
								
							if ($asRoomType) {
								
								$asRoom = $this->ROM->getAsRoom($hotel, $asRoomType['id_room_type'], $checkIn, $checkOut);
							}
							
							if ($pers > 6) {
								break;
							}
							
							$pers++;
						}
						
						if ($asRoom) {
							
							$roomId = $asRoom['id_room'];
							$roomNum = $asRoom['number'];
							
							$data = array(
								'adults'   => $adults,
								'children' => $children,
								'total'    => 0,
								'fk_room'  => $roomId,
								'fk_reservation' => $reservationId
							);
							
							$this->GNM->insert('ROOM_RESERVATION', $data);
						}  
					}
					
					$reservationRoomInfo = $this->ROM->getRRInfo($hotel, 'fk_reservation', $reservationId);
					
					if ($reservationRoomInfo) {
					
						$nights = (strtotime($checkOut) - strtotime($checkIn)) / (60 * 60 * 24);
						
						$priceAdult = NULL;
						$priceChild = NULL;
						$price      = 'Yes';
						
						foreach ($reservationRoomInfo as $row) {
							
							$roomType = $row['fk_room_type'];
							$room     = $row['fk_room'];
							$adults   = $row['adults'];
							$children = $row['children'];
							
							$priceAdult = $this->getPrice($checkIn, $checkOut, $reservationRate, $reservationPlan, $roomType, 'Adults');
							$priceChild = $this->getPrice($checkIn, $checkOut, $reservationRate, $reservationPlan, $roomType, 'Children');
							
							if ($priceAdult == 'error') {
								
								$error = lang("errorNoSeasonOrPrice");
							}
							
							$totalPriceAdults   = $priceAdult * $adults;
							$totalPriceChildren = $priceChild * $children;
							
							$totalPrice = $totalPriceAdults + $totalPriceChildren;
							
							$data = array(
								'total' => $totalPrice
							);
						
							$this->GNM->doubleUpdate('ROOM_RESERVATION', 'fk_reservation', $reservationId, 'fk_room', $room, $data);
							
							$priceAdult = NULL;
							$priceChild = NULL;	
							$totalPrice = 0;	
							//$date       = $checkIn;			
						}
						
						$reservationRoomInfo  = $this->ROM->getRRInfo($hotel, 'fk_reservation', $reservationId);
						$reservationRoomCount = $this->ROM->getRRCount($hotel, 'fk_reservation', $reservationId, null, null);
						$rates = $this->GNM->getInfo($hotel, 'RATE', null, null, null, null, null, 1);
						$plans = $this->GNM->getInfo($hotel, 'PLAN', null, null, null, null, null, 1);
						
						$data['nights'] = $nights;
						$data['rates']  = $rates;
						$data['plans']  = $plans;
						$data['error']  = $error;
						$data['reservationId']        = $reservationId;
						//$data['reservationTotal']     = $reservationTotal;
						$data['reservationRoomInfo']  = $reservationRoomInfo;
						$data['reservationRoomCount'] = $reservationRoomCount;
							
						$this->load->view('pms/reservations/reservation_create_2_view', $data);
					
					} else {
					
						$this->GNM->delete('RESERVATION', 'id_reservation', $reservationId);
						
						$totalPrice = 0;
						$totalP = 0;
						
						for ($i=1; $i<=$reservationRoomCount; $i++) {
						
							$valA = 'reservation_adults'.$i;
							$adults = $_POST[$valA];
							
							$valC = 'reservation_children'.$i;
							$children = $_POST[$valC];
							
							$totalPers = $adults + $children;
							$pers = $totalPers;
								
							$quotationRoomType = $this->ROM->getAsRoomType($hotel, $pers, $totalPers);
							$roomTypeId = $quotationRoomType['id_room_type'];
							
							$nights = $reservationCheckOut - $reservationCheckIn;
							
							$priceAdult = $this->getPrice($checkIn, $checkOut, $reservationRate, $reservationPlan, $roomTypeId, 'Adults');
							$priceChild = $this->getPrice($checkIn, $checkOut, $reservationRate, $reservationPlan, $roomTypeId, 'Children');
							
							$totalPriceAdults   = $priceAdult * $adults;
							$totalPriceChildren = $priceChild * $children;
							
							$totalRoomPrice = $totalPriceAdults + $totalPriceChildren;
							$totalP = $totalP + $totalPers;
							
							$totalPrice = $totalPrice + $totalRoomPrice;
							$totalPers = $totalPers + $adults + children;
						}
						
						$rate = $this->GNM->getInfo($hotel, 'RATE', 'id_rate', $reservationRate, null, null, null, 1);
						$plan = $this->GNM->getInfo($hotel, 'PLAN', 'id_plan', $reservationPlan, null, null, null, 1);
						
						$error = lang("NoAvailability");
						
						$data['error']      = $error;
						$data['rate']       = $rate;
						$data['plan']       = $plan;
						$data['nights']     = $nights;
						$data['checkIn']    = $reservationCheckIn;
						$data['checkOut']   = $reservationCheckOut;
						$data['roomCount']  = $reservationRoomCount;
						$data['totalPrice'] = $totalPrice;
						$data['totalP']     = $totalP;
				
						$this->load->view('pms/reservations/reservation_no_availability_view', $data);
					}
				}
			}
			
		} else {
		
			$data['error'] = NULL;
			$this->load->view('pms/users/user_sign_in', $data);
		}
	}
	
	
	function createReservation2($reservationId)
	{
		$userId = $this->session->userdata('userid');
		
		if ($userId) {

			$hotel = $this->session->userdata('hotelid');
			
			$reservationRoomInfo = $this->ROM->getRRInfo($hotel, 'fk_reservation', $reservationId);
			$reservationRoomCount = $this->ROM->getRRCount($hotel, 'fk_reservation', $reservationId, null, null);
			
			$data['error'] = 1;
			$data['reservationId']        = $reservationId;
			$data['reservationRoomInfo']  = $reservationRoomInfo;
			$data['reservationRoomCount'] = $reservationRoomCount;
						
			$this->load->view('pms/reservations/reservation_create_3_view', $data);	
		
		} else {
			
			$data['error'] = NULL;
			$this->load->view('pms/users/user_sign_in', $data);
		}
	}
	
	
	function createReservation3($reservationId)
	{	
		$userId = $this->session->userdata('userid');
		
		if ($userId) {
		
			$hotel = $this->session->userdata('hotelid');
	
			$this->form_validation->set_rules('guest_id_type','lang:id_type','trim|xss_clean|required|max_length[2]');
			$this->form_validation->set_rules('guest_id_num','lang:id_num','trim|xss_clean|required|max_length[10]|callback_checkGuestId');
			$this->form_validation->set_rules('guest_name','lang:name','trim|xss_clean|required|max_length[30]');
			$this->form_validation->set_rules('guest_2name','lang:2name','trim|xss_clean|max_length[30]');
			$this->form_validation->set_rules('guest_last_name','lang:last_name','trim|xss_clean|required|max_length[30]');
			$this->form_validation->set_rules('guest_2last_name','lang:2last_name','trim|xss_clean|max_length[30]');
			$this->form_validation->set_rules('guest_telephone','lang:telephone','trim|xss_clean|required|max_length[20]');
			$this->form_validation->set_rules('guest_email','lang:email','trim|xss_clean|required|valid_email|max_length[50]');
			$this->form_validation->set_rules('guest_address','lang:address','trim|xss_clean|max_length[300]');
			$this->form_validation->set_rules('reservation_details','lang:details','trim|xss_clean|max_length[300]');
			
			if ($this->form_validation->run() == FALSE) {
			
				$reservationRoomInfo  = $this->ROM->getRRInfo($hotel, 'fk_reservation', $reservationId);
				$reservationRoomCount = $this->ROM->getRRCount($hotel, 'fk_reservation', $reservationId, null, null);
			
				$data['reservationRoomInfo'] = $reservationRoomInfo;
				$data['reservationRoomCount'] = $reservationRoomCount;
				$data['reservationId'] = $reservationId;
				
				$this->load->view('pms/reservations/reservation_create_3_view', $data);
			
			} else {
				
				$reservationRoomInfo  = $this->ROM->getRRInfo($hotel, 'fk_reservation', $reservationId);
				$reservationRoomCount = $this->ROM->getRRCount($hotel, 'fk_reservation', $reservationId, null, null);
				
				$complete = 'Yes';
				
				if ($reservationRoomCount > 1) {
				
						foreach ($reservationRoomInfo as $row) {
					
						$varIdType   = 'guest_id_type'.$row['number'];
						$varIdNum    = 'guest_id_num'.$row['number'];
						$varName     = 'guest_name'.$row['number'];
						$varLastName = 'guest_last_name'.$row['number'];
						
						$otherGuestIdType   = $_POST[$varIdType];
						$otherGuestIdNum    = $_POST[$varIdNum];
						$otherGuestName     = $_POST[$varName];
						$otherGuestLastName = $_POST[$varLastName];
						
						if ( ($otherGuestIdNum == NULL) || ($otherGuestName == NULL) || ($otherGuestLastName == NULL) ) {
						
							$complete = 'No';
						}
					}
				}
				
				if ($complete == 'No') {
					
					$error = lang("errorOtherGuests");
					
					$reservationRoomInfo  = $this->ROM->getRRInfo($hotel, 'fk_reservation', $reservationId);
					$reservationRoomCount = $this->ROM->getRRCount($hotel, 'fk_reservation', $reservationId, null, null);
			
					$data['error']                = $error;
					$data['reservationRoomInfo']  = $reservationRoomInfo;
					$data['reservationRoomCount'] = $reservationRoomCount;
					$data['reservationId']        = $reservationId;
					
					$this->load->view('pms/reservations/reservation_create_3_view', $data);
				
				} else {
				
					foreach ($reservationRoomInfo as $row) {
									
						$varIdType   = 'guest_id_type'.$row['number'];
						$varIdNum    = 'guest_id_num'.$row['number'];
						$varName     = 'guest_name'.$row['number'];
						$varLastName = 'guest_last_name'.$row['number'];
						
						$otherGuestIdType   = $_POST[$varIdType];
						$otherGuestIdNum    = $_POST[$varIdNum];
						$otherGuestName     = $_POST[$varName];
						$otherGuestLastName = $_POST[$varLastName];
						
						$data = array(
							'idType'    => $otherGuestIdType,
							'idNum'     => $otherGuestIdNum,
							'name'      => ucwords(strtolower($otherGuestName)),
							'lastName'  => ucwords(strtolower($otherGuestLastName)),
							'age'       => NULL,
							'fk_reservation' => $reservationId,
							'fk_room'   => $row['id_room']
						);
					
						$this->GNM->insert('OTHER_GUEST', $data);  
						
						if (($row['children'] != 0) && ($row['children'] != NULL)) {
							
							for ($i=1; $i<=$row['children']; $i++) {
								
								$varAge  = 'children_age'.$row['number'].'_'.$i;
								$otherGuestAge  = $_POST[$varAge];
								
								$data = array(
									'idType'    => NULL,
									'idNum'     => NULL,
									'name'      => NULL,
									'lastName'  => NULL,
									'age'       => $otherGuestAge,
									'fk_reservation' => $reservationId,
									'fk_room'   => $row['id_room']
								);
					
								$this->GNM->insert('OTHER_GUEST', $data);
							}
						}
					}
				
					$reservationDetails  = set_value('reservation_details');
					
					$guestIdType    = set_value('guest_id_type');
					$guestIdNum     = set_value('guest_id_num');	
					$guestName      = set_value('guest_name');
					$guest2Name     = set_value('guest_2name');
					$guestLastName  = set_value('guest_last_name');
					$guest2LastName = set_value('guest_2last_name');
					$guestTelephone = set_value('guest_telephone');
					$guestEmail     = set_value('guest_email');
					$guestAddress   = set_value('guest_address');
					
					if ($guestIdNum == NULL) {
						$guestIdType = NULL;
						$guestIdNum  = NULL;
					}
					if ($guestName2 == NULL) {
						$guestName2 = NULL;
					}
					if ($guestLastName2 == NULL) {
						$guestLastName2 = NULL;
					}
					if ($guestAddress == NULL) {
						$guestAddress = NULL;
					}
					
					$data = array(
						'idType'    => $guestIdType,
						'idNum'     => $guestIdNum,
						'name'      => ucwords(strtolower($guestName)),
						'name2'     => ucwords(strtolower($guest2Name)),
						'lastName'  => ucwords(strtolower($guestLastName)),
						'lastName2' => ucwords(strtolower($guest2LastName)),
						'telephone' => $guestTelephone,
						'email'     => strtolower($guestEmail),
						'address'   => $guestAddress
						);
					
					$this->GNM->insert('GUEST', $data);  
					
					$guestId = $this->db->insert_id('GUEST');
					
					$datestring = "%Y-%m-%d %h:%i";
					$time       = time();
					$date       = mdate($datestring, $time);
		
					$data = array(
						'resDate'  => $date,
						'status'   => 'Reserved',
						'details'  => $reservationDetails,
						'fk_guest' => $guestId
						);
					
					$this->GNM->update('RESERVATION', 'id_reservation', $reservationId, $data);   
					
					$data['message'] = lang("createReservationMessage");
					$data['type']    = 'reservations';
				
					$this->load->view('pms/success', $data); 
				}
			}
			
		} else {
		
			$data['error'] = NULL;
			$this->load->view('pms/users/user_sign_in', $data);
		}
	}
	
	
	function createGuestReservation3($reservationId, $guestId)
	{	
		$userId = $this->session->userdata('userid');
		
		if ($userId) {
		
			$hotel = $this->session->userdata('hotelid');
	
			$reservationRoomInfo  = $this->ROM->getRRInfo($hotel, 'fk_reservation', $reservationId);
			$reservationRoomCount = $this->ROM->getRRCount($hotel, 'fk_reservation', $reservationId, null, null);
			
			$complete = 'Yes';
			
			if ($reservationRoomCount > 1) {
			
				foreach ($reservationRoomInfo as $row) {
				
					$varIdType   = 'guest_id_type'.$row['number'];
					$varIdNum    = 'guest_id_num'.$row['number'];
					$varName     = 'guest_name'.$row['number'];
					$varLastName = 'guest_last_name'.$row['number'];
					
					$otherGuestIdType   = $_POST[$varIdType];
					$otherGuestIdNum    = $_POST[$varIdNum];
					$otherGuestName     = $_POST[$varName];
					$otherGuestLastName = $_POST[$varLastName];
					
					if ( ($otherGuestIdNum == NULL) || ($otherGuestName == NULL) || ($otherGuestLastName == NULL) ) {
					
						$complete = 'No';
					}
				}
			}
			
			if ($complete == 'No') {
				
				$error = lang("errorOtherGuests");
				
				$guest                = $this->GSM->getGuestInfo($hotel, 'id_guest', $guestId, null, null, null, 1);
				$reservationRoomInfo  = $this->ROM->getRRInfo($hotel, 'fk_reservation', $reservationId);
				$reservationRoomCount = $this->ROM->getRRCount($hotel, 'fk_reservation', $reservationId, null, null);
				
				$data['error']                = $error;
				$data['guest']                = $guest;
				$data['reservationId']        = $reservationId;
				$data['reservationRoomInfo']  = $reservationRoomInfo;
				$data['reservationRoomCount'] = $reservationRoomCount;
				
				$this->load->view('pms/reservations/reservation_create_3_view', $data);
			
			} else {
			
				foreach ($reservationRoomInfo as $row) {
								
					$varIdType   = 'guest_id_type'.$row['number'];
					$varIdNum    = 'guest_id_num'.$row['number'];
					$varName     = 'guest_name'.$row['number'];
					$varLastName = 'guest_last_name'.$row['number'];
					
					$otherGuestIdType   = $_POST[$varIdType];
					$otherGuestIdNum    = $_POST[$varIdNum];
					$otherGuestName     = $_POST[$varName];
					$otherGuestLastName = $_POST[$varLastName];
					
					$data = array(
						'idType'    => $otherGuestIdType,
						'idNum'     => $otherGuestIdNum,
						'name'      => ucwords(strtolower($otherGuestName)),
						'lastName'  => ucwords(strtolower($otherGuestLastName)),
						'age'       => NULL,
						'fk_reservation' => $reservationId,
						'fk_room'   => $row['id_room']
					);
				
					$this->GNM->insert('OTHER_GUEST', $data);  
					
					if (($row['children'] != 0) && ($row['children'] != NULL)) {
						
						for ($i=1; $i<=$row['children']; $i++) {
							
							$varAge  = 'children_age'.$row['number'].'_'.$i;
							$otherGuestAge  = $_POST[$varAge];
							
							$data = array(
								'idType'    => NULL,
								'idNum'     => NULL,
								'name'      => NULL,
								'lastName'  => NULL,
								'age'       => $otherGuestAge,
								'fk_reservation' => $reservationId,
								'fk_room'   => $row['id_room']
							);
				
							$this->GNM->insert('OTHER_GUEST', $data);
						}
					}
				}
			
				$reservationDetails = set_value('reservation_details');
				
				$datestring = "%Y-%m-%d %h:%i";
				$time       = time();
				$date       = mdate($datestring, $time);
	
				$data = array(
					'resDate'  => $date,
					'status'   => 'Reserved',
					'details'  => $reservationDetails,
					'fk_guest' => $guestId
					);
				
				$this->GNM->update('RESERVATION', 'id_reservation', $reservationId, $data);   
				
				$data['message'] = lang("createReservationMessage");
				$data['type']    = 'reservations';
			
				$this->load->view('pms/success', $data); 
			}
			
		} else {
		
			$data['error'] = NULL;
			$this->load->view('pms/users/user_sign_in', $data);
		}
	}
	
	
	function createReservationSearchAvail($reservationId)
	{
		$userId = $this->session->userdata('userid');
		
		if ($userId) {
		
			$hotel = $this->session->userdata('hotelid');
			
			$reservationRoomInfo = $this->ROM->getRRInfo($hotel, 'fk_reservation', $reservationId);
			
			$errorRoom  = NULL;
			$errorPrice = NULL;
			
			foreach ($reservationRoomInfo as $row) {
			
				$checkIn      = $row['checkIn'];
				$checkOut     = $row['checkOut'];
				$rateId       = $row['fk_rate'];
				$planId       = $row['fk_plan'];
				$tempRoom     = $row['fk_room'];
				$tempRoomType = $row['fk_room_type'];
				$adults       = $row['adults'];
				$children     = $row['children'];
				
				$checkIn_array = explode (' ',$checkIn);
				$ciDate = $checkIn_array[0];
					
				$checkOut_array = explode (' ',$checkOut);
				$coDate = $checkOut_array[0];
				
				$nights = (strtotime($checkOut) - strtotime($checkIn)) / (60 * 60 * 24);
				
				$val        = 'room_type'.$tempRoom;
				$roomTypeId = $_POST[$val];
				
	//			echo $val, ' es igual a ', $roomTypeId;
						
				if ($roomTypeId != $tempRoomType) {
					
					$asRoom = $this->ROM->getAsRoom($hotel, $roomTypeId, $checkIn, $checkOut);
					
					if ($asRoom) {
						
						$roomId  = $asRoom['id_room'];
						$roomNum = $asRoom['number'];
						
						$data = array(
							'fk_room'  => $roomId
						);
						
						$this->GNM->doubleUpdate('ROOM_RESERVATION', 'fk_reservation', $reservationId, 'fk_room', $tempRoom, $data);
						
						$priceAdult = $this->getPrice($ciDate, $coDate, $rateId, $planId, $roomTypeId, 'Adults');
						$priceChild = $this->getPrice($ciDate, $coDate, $rateId, $planId, $roomTypeId, 'Children');
						
						if ($priceAdult == 'error') {
							
							$errorPrice = lang("errorNoSeasonOrPrice");
						}
	
						$totalPriceAdults   = $priceAdult * $adults;
						$totalPriceChildren = $priceChild * $children;
				
						$totalPrice = $totalPriceAdults + $totalPriceChildren;
										
						$data = array(
							'total' => $totalPrice
						);
										
						$this->GNM->doubleUpdate('ROOM_RESERVATION', 'fk_reservation', $reservationId, 'fk_room', $roomId, $data);
					
					} else {
						
						$errorRoom = lang("errorNoRoom");
		//				echo 'No hay hab disponible tipo ', $roomTypeId, 'para hab: ', $roomNum;
					}
				}
			}
			
			$reservationRoomInfo  = $this->ROM->getRRInfo($hotel, 'fk_reservation', $reservationId);
			$reservationRoomCount = $this->ROM->getRRCount($hotel, 'fk_reservation', $reservationId, null, null);
			$rates = $this->GNM->getInfo($hotel, 'RATE', null, null, null, null, null, 1);
			$plans = $this->GNM->getInfo($hotel, 'PLAN', null, null, null, null, null, 1);
			
			$selected                     = 'Yes';
			$data['nights']               = $nights;
			$data['rates']                = $rates;
			$data['plans']                = $plans;
			$data['errorPrice']           = $errorPrice;
			$data['errorRoom']            = $errorRoom;
			$data['reservationId']        = $reservationId;
			$data['reservationRoomInfo']  = $reservationRoomInfo;
			$data['reservationRoomCount'] = $reservationRoomCount;
				
			$this->load->view('pms/reservations/reservation_create_2_view', $data);
			
		} else {
			
			$data['error'] = NULL;
			$this->load->view('pms/users/user_sign_in', $data);
		}
	}
	
	
	function deleteReservation($reservationId)
	{
		$userId = $this->session->userdata('userid');
		
		if ($userId) {
			
			$this->GNM->delete('RESERVATION', 'id_reservation', $reservationId);
			
			$this->createReservation1();
		}
	}
	
	
	function deleteQuotations()
	{
		$userId = $this->session->userdata('userid');
		
		if ($userId) {
			
			$this->GNM->delete('RESERVATION', 'status', 'Quotation');
		}
	}
	
	
	function modifyRoomReservationOtherGuest($reservationId, $otherGuestId)
	{	
		$this->form_validation->set_rules('other_guest_id_type','lang:id_type','trim|xss_clean|required');
		$this->form_validation->set_rules('other_guest_id_num','lang:id_num','trim|xss_clean|required|max_length[10]');
		$this->form_validation->set_rules('other_guest_names','lang:names','trim|xss_clean|required|max_length[50]');
		$this->form_validation->set_rules('other_guest_last_names','lang:lastNames','trim|xss_clean|required|max_length[50]');
			
		if ($this->form_validation->run() == FALSE) {
			
			$hotel = $this->session->userdata('hotelid');				
	
			$roomReservationInfo = $this->ROM->getRRInfo($hotel, 'fk_reservation', $reservationId);
			$otherGuest          = $this->GSM->getOtherGuestInfo($hotel, 'OG.fk_reservation', $reservationId, 'id_other_guest', $otherGuestId, null);

			$data['reservationId']       = $reservationId;
			$data['roomReservationInfo'] = $roomReservationInfo;
			$data['otherGuest']          = $otherGuest;
			
			$this->load->view('pms/reservations/reservation_modify_other_guest_view', $data);
			
		} else {
			
			$otherGuestIdType    = set_value('other_guest_id_type');
			$otherGuestIdNum     = set_value('other_guest_id_num');
			$otherGuestNames     = set_value('other_guest_names');
			$otherGuestLastNames = set_value('other_guest_last_names');
			
			$data = array(
					'idType'  => $otherGuestIdType,
					'idNum'   => $otherGuestIdNum,
					'name'     => $otherGuestNames,
					'lastName' => $otherGuestLastNames
					);
					
			$this->GNM->doubleUpdate('OTHER_GUEST', 'fk_reservation', $reservationId, 'id_other_guest', $otherGuestId, $data);
			
			$message = lang("modOtherGuestMessage");
			
			$this->infoReservation($reservationId, $message);
		}
	}
	
	
	function modifyRoomReservationTotal()
	{			
		$this->form_validation->set_rules('new_total','lang:new_total','trim|xss_clean|required|max_length[10]');
			
		if ($this->form_validation->run() == FALSE) {
			
			$userId = $this->session->userdata('userid');
		
			if ($userId) {
				
				$hotel = $this->session->userdata('hotelid');
		
				$reservationId = $this->uri->segment(3);
				$roomId        = $this->uri->segment(4);
		
				$roomReservationInfo = $this->ROM->getRRInfo($hotel, 'fk_reservation', $reservationId);
				
				$data['roomId'] = $roomId;
				$data['roomReservationInfo'] = $roomReservationInfo;
				
				$this->load->view('pms/reservations/reservation_modify_room_total_view', $data);
				
			} else {
			
				$data['error'] = NULL;
				$this->load->view('pms/users/user_sign_in', $data);
			}
			
		} else {
		
			$reservationId = $this->uri->segment(3);
			$roomId = $this->uri->segment(4);
				
			$newTotal = set_value('new_total');
			
			$data = array(
					'total' => $newTotal
					);
					
			$this->GNM->doubleUpdate('ROOM_RESERVATION', 'fk_reservation', $reservationId, 'fk_room', $roomId, $data);
			
			$message = lang("modTotalReservationMessage");
			
			$this->infoReservation($reservationId, $message);
		}
	}
	
	
	function modifyReservationRooms()
	{
		$userId = $this->session->userdata('userid');
		
		if ($userId) {
		
			$reservationId = $this->uri->segment(3);
			$roomId = $this->uri->segment(4);
		
			$hotel = $this->session->userdata('hotelid');
			
			$roomReservationInfo = $this->ROM->getRoomReservationsGuest($hotel, 'id_reservation', $reservationId, null, null, null);
			$roomTypes        = $this->GNM->getInfo($hotel, 'ROOM_TYPE', null, null, null, null, null, 1);
			
			foreach ($roomReservationInfo as $row) {
			
				if ($row['id_room'] == $roomId) {
				
					$roomType = $row['id_room_type'];
					$checkIn  = $row['checkIn'];
					$checkOut = $row['checkOut'];
					$totalPer = $row['adults'] + $row['children'];
				}
			}
			
			$availableType  = $this->ROM->getRoomTypeAvailability($hotel, $reservationId, $roomType, $checkIn, $checkOut);
			$availableOther = $this->ROM->getAvailabilityOther($hotel, $checkIn, $checkOut, $totalPer);
			
			$data['roomId']         = $roomId; 
			$data['roomTypes']      = $roomTypes; 
			$data['availableType']  = $availableType;  	
			$data['availableOther'] = $availableOther;  
			$data['roomReservationInfo'] = $roomReservationInfo; 
			
			$this->load->view('pms/reservations/reservation_modify_rooms_view', $data);
			
		} else {
		
			$data['error'] = NULL;
			$this->load->view('pms/users/user_sign_in', $data);
		}
	}
	
	
	
	function modifyReservationRooms2($reservationId, $oldRoomId, $newRoomId)
	{
		$userId = $this->session->userdata('userid');
		
		if ($userId) {
			
			$data = array(
					'fk_room' => $newRoomId
					);
					
			$this->GNM->doubleUpdate('ROOM_RESERVATION', 'fk_reservation', $reservationId, 'fk_room', $oldRoomId, $data);
			$this->GNM->doubleUpdate('OTHER_GUEST', 'fk_reservation', $reservationId, 'fk_room', $oldRoomId, $data); 
			
			$hotel = $this->session->userdata('hotelid');
			
			$reservation         = $this->REM->getReservationInfo($hotel, 'id_reservation', $reservationId, null, null, null, 1);
			$newRoomInfo         = $this->ROM->getRoomInfo($hotel, 'id_room', $newRoomId, null, null, null, 1);
			$reservationRoomInfo = $this->ROM->getRRInfo($hotel, 'fk_reservation', $reservationId);
			
			foreach ($reservation as $row) {
				
				$checkIn  = $row['checkIn'];
				$checkOut = $row['checkOut'];
				$rate     = $row['fk_rate'];
				$plan     = $row['fk_plan'];
			}
			
			foreach ($newRoomInfo as $row) {
				
				$newRoomTypeId = $row['fk_room_type'];
			}
			
			foreach ($reservationRoomInfo as $row) {
				
				if ($row['fk_room'] == $newRoomId) {
							
					$adults   = $row['adults'];
					$children = $row['children'];
				}
			}
			
			$checkIn_array = explode (' ',$checkIn);
			$ciDate = $checkIn_array[0];
				
			$checkOut_array = explode (' ',$checkOut);
			$coDate = $checkOut_array[0];
				
			$priceAdult = $this->getPrice($ciDate, $coDate, $rate, $plan, $newRoomTypeId, 'Adults');
			$priceChild = $this->getPrice($ciDate, $coDate, $rate, $plan, $newRoomTypeId, 'Children');
			
			$totalPriceAdults   = $priceAdult * $adults;
			$totalPriceChildren = $priceChild * $children;
	
			$totalPrice = $totalPriceAdults + $totalPriceChildren;
							
			$data = array(
				'total' => $totalPrice
			);
							
			$this->GNM->doubleUpdate('ROOM_RESERVATION', 'fk_reservation', $reservationId, 'fk_room', $newRoomId, $data);
			
			$message = lang("modRoomReservationMessage");
			
			$this->infoReservation($reservationId, $message);
		
		} else {
			
			$data['error'] = NULL;
			$this->load->view('pms/users/user_sign_in', $data);
		}
	}
	
	
	function modifyReservationDates($reservationId)
	{
		$userId = $this->session->userdata('userid');
		
		if ($userId) {
		
			$hotel = $this->session->userdata('hotelid');
			
			$this->form_validation->set_rules('new_check_in','lang:check_in','trim|xss_clean|required|max_length[15]');
			$this->form_validation->set_rules('new_check_out','lang:check_out','trim|xss_clean|required|max_length[15]');
			
			if ($this->form_validation->run() == FALSE) {
			
				$reservationRooms = $this->ROM->getRoomReservationsGuest($hotel, 'id_reservation', $reservationId, null, null, null);
				
				$data['error'] = 1;
				$data['reservationRooms'] = $reservationRooms; 
				
				$this->load->view('pms/reservations/reservation_modify_dates_view', $data);
			
			} else {
			
				$newCheckIn  = set_value('new_check_in');
				$newCheckOut = set_value('new_check_out');
				
				$ci_array = explode ('-',$newCheckIn);
				$day      = $ci_array[0];
				$month    = $ci_array[1];
				$year     = $ci_array[2];
				$checkIn  = $year.'-'.$month.'-'.$day;
			
				$co_array = explode ('-',$newCheckOut);
				$day      = $co_array[0];
				$month    = $co_array[1];
				$year     = $co_array[2];
				$checkOut = $year.'-'.$month.'-'.$day;
				
				$datestring = "%Y-%m-%d";
				$time       = time();
				$now        = mdate($datestring, $time);
				
				if (($checkOut <= $checkIn) || ($checkIn < $now)) {
				
					if ($checkOut <= $checkIn) {
						$error = lang("errorCheckInOutDates");
					}
					
					if ($checkIn < $now) {
						$error = lang("errorCheckInToday");
					}
				
					$reservationRooms = $this->ROM->getRoomReservationsGuest($hotel, 'id_reservation', $reservationId, null, null, null);
					
					$data['error'] = $error;
					$data['reservationRooms'] = $reservationRooms; 
				
					$this->load->view('pms/reservations/reservation_modify_dates_view', $data);
					
				} else {
					
					$iniArray = array();
					
					$reservationRoomInfo = $this->ROM->getRRInfo($hotel, 'fk_reservation', $reservationId);
					
					foreach ($reservationRoomInfo as $row) {
				
						$adults     = $row['adults'];
						$children   = $row['children'];
						$prevRoomId = $row['fk_room'];
						$roomType   = $row['fk_room_type'];
						
						$totalPers = $adults + $children;
						$pers      = $totalPers;
						$asRoom    = NULL;
						$newRoomId = NULL;
						
						$roomAvailability = $this->ROM->getRoomAvailability($hotel, $reservationId, $prevRoomId, $checkIn, $checkOut);
						
						if ($roomAvailability) {
							
							foreach ($roomAvailability as $row) {
							
								$newRoomId = $row['id_room'];
							}
						
						} else {
							
							$asRoom = $this->ROM->getAsRoom($hotel, $roomType, $checkIn, $checkOut);
							
							if ($asRoom) {
							
								$newRoomId = $asRoom['id_room'];
							
							} else {
							
								while (! $asRoom) {
					
									$asRoomType = $this->ROM->getAsRoomType($hotel, $pers, $totalPers);
										
									if ($asRoomType) {
										
										$asRoom = $this->ROM->getAsRoom($hotel, $asRoomType['id_room_type'], $checkIn, $checkOut);
									}
									
									if ($pers > 15) {
										break;
									}
									
									$pers++;
								}
								
								if ($asRoom) {
							
									$newRoomId = $asRoom['id_room'];
								} 
							}  
						}
						
						if ($newRoomId != NULL) {
							
							$Ids      = array ($prevRoomId, $newRoomId);
							$allIds   = array_merge($iniArray, $Ids);
							$iniArray = $allIds;
					
							/*
							echo 'IDS: ', print_r ($Ids)."<br>";
							echo 'ALL: ', print_r ($allIds)."<br>";
							echo 'INI: ', print_r ($iniArray)."<br><br>";
							*/
							
						} else {
							
							echo 'No hay disponibilidad en esas fechas!!';
						}
						
					} // end foreach reservationRoomInfo
					
					$totalRooms = count($reservationRoomInfo);
					$totalArray = $totalRooms * 2;
						
					$lengthArray = count($allIds);
					
					if ($lengthArray == $totalArray) {
						
						for ($i=0; $i<=($totalArray-1); $i+=2) {
							
							$prevRoomId = $allIds[$i];
							$newRoomId  = $allIds[$i+1];
							
							$data = array(
								'fk_room'  => $newRoomId
								);
						
							$this->GNM->doubleUpdate('ROOM_RESERVATION', 'fk_reservation', $reservationId, 'fk_room', $prevRoomId, $data);
						}
						
						$data = array(
							'checkIn'  => $checkIn,
							'checkOut' => $checkOut
							);
						
						$this->GNM->update('RESERVATION', 'id_reservation', $reservationId, $data);   
						
						$message = lang("modDatesReservationMessage");
			
						$this->infoReservation($reservationId, $message);
					}
						
				}// end else
			}//end else

		} else {
			
			$data['error'] = NULL;
			$this->load->view('pms/users/user_sign_in', $data);
		}
	}
	
	
	function modifyReservationDates2($reservationId, $newCheckIn, $newCheckOut)
	{
		$userId = $this->session->userdata('userid');
		
		if ($userId) {
			
			echo 'post: ', $order = $_GET['res_ci'];
		
		
		/*
		$reservations = $this->GM->get_info('RESERVATION','ID_RESERVATION', $reservation_id, null, null, null, 1);
		foreach ($reservation as $row)
		{
			$room_type = $row['ID_ROOM_TYPE'];
		}
		
		$available = $this->RM->get_availability($room_type, $check_in, $check_out);
		
		$data['available'] = $available;  
		
		$data = array(
				'FK_ID_ROOM' => $new_room_num
				);
				
		$this->GM->double_update('ROOM_RESERVATION', 'FK_ID_RESERVATION', $reservation_id, 'FK_ID_ROOM', $old_room_num, $data); 
		
		echo 'Habitacion cambiada!'; 
		
		$this->info_reservation($reservation_id);
			*/
		
		} else {
			
			$data['error'] = NULL;
			$this->load->view('pms/users/user_sign_in', $data);
		}
	}

	
	/*
	function modify_reservation_rooms_3($reservation_id, $old_room_num, $new_room_num)
	{
		$data = array(
				'FK_ID_ROOM' => $new_room_num
				);
				
		$this->GM->double_update('ROOM_RESERVATION', 'FK_ID_RESERVATION', $reservation_id, 'FK_ID_ROOM', $old_room_num, $data); 
		
		echo 'Habitacion cambiada!'; 
		
		$this->info_reservation($reservation_id);
		
	}
	
	*/
	
	
	function payReservation($reservationId)
	{
		$userId = $this->session->userdata('userid');
		
		if ($userId) {
		
			$hotel = $this->session->userdata('hotelid');
			$user  = $this->session->userdata('userid');
			
			$this->form_validation->set_rules('pers_type','lang:pers_type','trim|xss_clean|required');
			$this->form_validation->set_rules('pers_name','lang:name','trim|xss_clean|required|max_length[200]');
			$this->form_validation->set_rules('pers_id','lang:pers_id','trim|xss_clean|required|max_length[20]');
			$this->form_validation->set_rules('payment_amount','lang:payment_amount','trim|xss_clean|required|max_length[15]');
			$this->form_validation->set_rules('payment_type','lang:payment_type','trim|xss_clean|required');
			$this->form_validation->set_rules('payment_bank','lang:payment_bank','trim|xss_clean|max_length[50]');
			$this->form_validation->set_rules('check_num','lang:check_num','trim|xss_clean|max_length[50]');
			$this->form_validation->set_rules('transfer_num','lang:transfer_num','trim|xss_clean|max_length[50]');
			$this->form_validation->set_rules('payment_details','lang:details','trim|xss_clean|max_length[500]');
					
			if ($this->form_validation->run() == FALSE) {
				
				$guest       = $this->GSM->getGuestInfo($hotel, null, null, null, null, null, null);
				$reservation = $this->REM->getReservationInfo($hotel, 'id_reservation', $reservationId, null, null, null, 1);
			/**/	$payments    = $this->REM->getPaymentInfo($hotel, null, null, $reservationId);
				$reservationRoomInfo  = $this->ROM->getRRInfo($hotel, 'fk_reservation', $reservationId);
				$reservationRoomCount = $this->ROM->getRRCount($hotel, 'fk_reservation', $reservationId, null, null);
				
				$data['error'] = 1;
				$data['guest'] = $guest;
				$data['payments']    = $payments;
				$data['reservation'] = $reservation;
				$data['reservationRoomInfo']  = $reservationRoomInfo;
				$data['reservationRoomCount'] = $reservationRoomCount;
				
				$this->load->view('pms/reservations/reservation_payment_register_view', $data);
			
			} else {
			
				$persType       = set_value('pers_type');
				$persName       = set_value('pers_name');
				$persId         = set_value('pers_id');
				$paymentAmount  = set_value('payment_amount');
				$paymentType    = set_value('payment_type');
				$paymentBank    = set_value('payment_bank');
				$checkNum       = set_value('check_num');
				$transferNum    = set_value('transfer_num');
				$paymentDetails = set_value('payment_details');
				$error = 1;
				
				$amountToPay = $_POST['to_pay'];
				
				if ($paymentAmount > $amountToPay) {
					
					$error = lang("errorPaymentAmount");
				}
				if ( ($paymentType == 'check') && (($paymentBank == NULL) || ($checkNum == NULL)) ) {
					
					$error = lang("errorPaymentBank");
				} 
				if ( ($paymentType == 'transfer') && ($transferNum == NULL) ) {
					
					$error = lang("errorPaymentTransfer");
				} 
				
				if ($error != 1) {
				
					$guest       = $this->GSM->getGuestInfo($hotel, null, null, null, null, null, null);
					$reservation = $this->REM->getReservationInfo($hotel, 'id_reservation', $reservationId, null, null, null, 1);
					$payments    = $this->REM->getPaymentInfo($hotel, null, null, $reservationId);
					$reservationRoomInfo  = $this->ROM->getRRInfo($hotel, 'fk_reservation', $reservationId);
					$reservationRoomCount = $this->ROM->getRRCount($hotel, 'fk_reservation', $reservationId, null, null);
					
					$data['error'] = $error;
					$data['guest'] = $guest;
					$data['payments'] = $payments;
					$data['reservation'] = $reservation;
					$data['reservationRoomInfo']  = $reservationRoomInfo;
					$data['reservationRoomCount'] = $reservationRoomCount;
					
					$this->load->view('pms/reservations/reservation_payment_register_view', $data);
				
				} else {
					
					if ($paymentType == 'check') {
						$confirmNum = $checkNum;
					} else if ($paymentType == 'transfer') {
						$confirmNum = $transferNum;
					} else {
						$confirmNum = NULL;
					}
				
					$datestring = "%Y-%m-%d %h:%i";
					$time       = time();
					$date       = mdate($datestring, $time);
					
					$data = array(
						'date'   => $date,
						'amount' => $paymentAmount,
						'type'   => $paymentType,
						'bank'   => ucwords(strtolower($paymentBank)),
						'confirmNum' => $confirmNum,
						'persType'   => $persType,
						'persId'     => $persId,
						'persName'   => ucwords(strtolower($persName)),
						'details'    => $paymentDetails,
						'fk_reservation' => $reservationId,
						'fk_user'        => $user
						);
					
					$this->GNM->insert('PAYMENT', $data); 
					
					$payments = $this->REM->getPaymentInfo($hotel, null, null, $reservationId);
					
					$reservationRoomInfo = $this->ROM->getRRInfo($hotel, 'fk_reservation', $reservationId);
				
					$total = 0;
					foreach ($reservationRoomInfo as $row) {
						$total = $total + $row['total'];
					}
					
					$paid = 0;
					foreach ($payments as $row) {
						$paid = $paid + $row['amount'];
					}
					
					$toPay = $total - $paid;
					
					if ($toPay == 0) {
						
						$data = array(
						  'paymentStat' => 'Paid'
						);
					
						$this->GNM->update('RESERVATION', 'id_reservation', $reservationId, $data); 
					}
					
					$message = lang("paymentReservationMessage");
			
					$this->infoReservation($reservationId, $message);
				}
			}
			
		} else {
			
			$data['error'] = NULL;
			$this->load->view('pms/users/user_sign_in', $data);
		}
	}
	
	
	function viewReservationPayments($reservationId)
	{
		$userId = $this->session->userdata('userid');
		
		if ($userId) {
		
			$hotel = $this->session->userdata('hotelid');
			
			$guest       = $this->GSM->getGuestInfo($hotel, null, null, null, null, null, null);
			$reservation = $this->REM->getReservationInfo($hotel, 'id_reservation', $reservationId, null, null, null, 1);
			$payments    = $this->REM->getPaymentInfo($hotel, null, null, $reservationId);
			$reservationRoomInfo  = $this->ROM->getRRInfo($hotel, 'fk_reservation', $reservationId);
			$reservationRoomCount = $this->ROM->getRRCount($hotel, 'fk_reservation', $reservationId, null, null);
				
			$data['guest']       = $guest;
			$data['payments']    = $payments;
			$data['reservation'] = $reservation;
			$data['reservationRoomInfo']  = $reservationRoomInfo;
			$data['reservationRoomCount'] = $reservationRoomCount;
				
			$this->load->view('pms/reservations/reservation_payments_view', $data);
			
		} else {
		
			$data['error'] = NULL;
			$this->load->view('pms/users/user_sign_in', $data);
		}
	}
	
	
	function viewPaymentDetails()
	{
		$userId = $this->session->userdata('userid');
		
		if ($userId) {
		
			$reservationId = $this->uri->segment(3);
			$paymentId   = $this->uri->segment(4);
			
			$hotel = $this->session->userdata('hotelid');
			
			$payment = $this->REM->getPaymentInfo($hotel, 'id_payment', $paymentId, $reservationId);
			
			$data['payment'] = $payment;
				
			$this->load->view('pms/reservations/reservation_payment_info_view', $data);
		
		} else {
			
			$data['error'] = NULL;
			$this->load->view('pms/users/user_sign_in', $data);
		}
	}
	
	
	function searchReservation()
	{	
		$this->form_validation->set_rules('search','lang:search','trim|xss_clean|required|max_length[150]');
		
		if ($this->form_validation->run() == FALSE) {
		
			$this->viewPendingReservations();
			
		} else {
		
			$hotel = $this->session->userdata('hotelid');
				
			$searchString = set_value('search');
			
			$result = $this->REM->getReservationInfo($hotel, 'id_reservation', $searchString, null, null, null, null);
				
			if ($result) {
					
				foreach ($result as $row) {
					
					$reservationId = $row['id_reservation'];
				}
					
				$this->infoReservation($reservationId, null);
				 
			} else {
				
				$this->load->view('pms/reservations/reservation_info_view');
			}
		}
	}
	
	
	function validDate($str,$format= 'dd/mm/yyyy')
	{
		switch ($format) {
			
			
			case 'yyyy/mm/dd':
			
				if(preg_match("/^(19\d\d|2\d\d\d)[\/|-](0?[1-9]|1[012])[\/|-](0?[1-9]|[12][0-9]|3[01])$/", $str,$match) && checkdate($match[2],$match[3],$match[1])) {
					return FALSE;
				}
				
			break;
			
			case 'mm/dd/yyyy':
			
				if(preg_match("/^(0?[1-9]|1[012])[\/|-](0?[1-9]|[12][0-9]|3[01])[\/|-](19\d\d|2\d\d\d)$/", $str,$match) && checkdate($match[1],$match[2],$match[3])) {
				
					return FALSE;
				}
				
			break;
			
			default: // 'dd/mm/yyyy'
			
				if(preg_match("/^(0?[1-9]|[12][0-9]|3[01])[\/|-](0?[1-9]|1[012])[\/|-](19\d\d|2\d\d\d)$/", $str,$match) && checkdate($match[2],$match[1],$match[3])) {
				
					return TRUE;
				}
			
			break;
		}
		
		$this->form_validation->set_message('validDate', lang("errorValidDate"));
		return FALSE;
	} 
	
	
	function validDateY($str,$format= 'yyyy-mm-dd')
	{
		switch ($format) {
			
			case 'yyyy-mm-dd':
			
				if(preg_match("/^(19\d\d|2\d\d\d)[\/|-](0?[1-9]|1[012])[\/|-](0?[1-9]|[12][0-9]|3[01])$/", $str,$match) && checkdate($match[2],$match[3],$match[1])) {
					return TRUE;
				}
				
			break;
		}
		
		$this->form_validation->set_message('validDate', lang("errorValidDate"));
		return FALSE;
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