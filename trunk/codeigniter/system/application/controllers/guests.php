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
	
	
	function viewGuests()
	{
		$hotel = $this->session->userdata('hotelid');
		
		$guests = $this->GSM->getGuestInfo($hotel, null, null, 'lastName', null, null, 1);
		
		$data['guests'] = $guests;
		
		$this->load->view('pms/guests/guests_view', $data);
	}
	
	
	function viewDisableGuests()
	{
		$hotel = $this->session->userdata('hotelid');
		
		$guests = $this->GSM->getGuestInfo($hotel, 'G.disable', '0', 'lastName', null, null, null);
		
		$data['guests'] = $guests;
		
		$this->load->view('pms/guests/guests_disable_view', $data);
	}
	
	
	function infoGuestReservations($guestId)
	{
		//$order = $_POST["order"];
		$order = 'checkIn DESC';
		$hotel = $this->session->userdata('hotelid');
		
		$guest        = $this->GSM->getGuestInfo($hotel, 'id_guest', $guestId, null, null, null, null);
		$reservations = $this->ROM->getRoomReservationsGuest($hotel, 'RE.fk_guest', $guestId, $order);
		
		$data['guest']        = $guest;
		$data['reservations'] = $reservations;
		
		$this->load->view('pms/guests/guest_reservations_info_view', $data);
	}
	
	
	function editGuest($guestId)
	{
		$hotel = $this->session->userdata('hotelid');
		
		$this->form_validation->set_rules('guest_name','lang:name','required|max_length[30]');
		$this->form_validation->set_rules('guest_last_name','lang:last_name','required|max_length[30]');
		$this->form_validation->set_rules('guest_telephone','lang:telephone','required|numeric|max_length[20]');
		$this->form_validation->set_rules('guest_email','lang:email','required|valid_email|max_length[50]');
		$this->form_validation->set_rules('guest_address','lang:address','max_length[300]');
		
		if ($this->form_validation->run() == FALSE) {
		
			$guest = $this->GSM->getGuestInfo($hotel, 'id_guest', $guestId, null, null, null, 1);
			
			$data['guest'] = $guest;

			$this->load->view('pms/guests/guest_edit_view', $data);
			
		} else {
		
			$guestName      = set_value('guest_name');
			$guestLastName  = set_value('guest_last_name');
			$guestTelephone = set_value('guest_telephone');
			$guestEmail     = set_value('guest_email');
			$guestAddress   = set_value('guest_address');
			
			$data = array(
				'name'      => ucwords(strtolower($guestName)),
				'lastName'  => ucwords(strtolower($guestLastName)),
				'telephone' => $guestTelephone,
				'email'     => $guestEmail,
				'address'   => $guestAddress
				);
			
			$this->GNM->update('GUEST', 'id_guest', $guestId, $data);  
				
			$this->infoGuestReservations($guestId); 
		}
	}
	
	
	function disableGuest($guestId)
	{
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
				$resultado = array_merge($iniResNum, $newResNum);
				$iniResNum = $resultado;
				
				//echo 'new: ', print_r($new_res_num). "<br>";
				//echo 'res: ', print_r($resultado). "<br>";
				//echo 'ini: ', print_r($ini_res_num). "<br>";
	        }
		}
		
		if ($delete == 'No') {
		
			echo lang("errorPendingReservation")."<br>";
			foreach ($resultado as $actual)
    		echo '# ',$actual . "<br>"; 
			
			$this->infoGuestReservations($guestId);
			
		} else {
		
			$this->GNM->disable('GUEST', 'id_guest', $guestId);
			echo lang("guestDisabled");
			$this->viewGuests(); 
		}	
	}
	
	
	function enableGuest($guestId)
	{
		$data = array(
				'disable' => 1
				);
			
		$this->GNM->update('GUEST', 'id_guest', $guestId, $data);  
			
		echo lang("guestEnabled");	
		$this->infoGuestReservations($guestId);		
	}






}
?>