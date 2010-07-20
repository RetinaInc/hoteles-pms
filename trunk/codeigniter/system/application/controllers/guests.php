<?php

class Guests extends Controller
{
	function Guests()
	{
		parent::Controller();
		$this->load->model('general_model','GM');
		$this->lang->load ('form_validation','spanish');
		$this->load->library('form_validation');
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
		$guests = $this->GM->getInfo('GUEST', null, null, 'LASTNAME', null, null, 1);
		
		$data['guests'] = $guests;
		
		$this->load->view('pms/guests/guests_view', $data);
	}
	
	
	function infoGuestReservations($guestId)
	{
		//$order = $_POST["order"];
		$order = 'CHECK_IN DESC';
		
		$guest        = $this->GM->getInfo('GUEST',           'ID_GUEST',    $guestId, null,   null, null, 1);
		$reservations = $this->GM->getInfo('RESERVATION',     'FK_ID_GUEST', $guestId, $order, null, null, 1);
		
		$data['guest']        = $guest;
		$data['reservations'] = $reservations;
		
		$this->load->view('pms/guests/guest_reservations_info_view', $data);
	}
	
	
	function editGuest($guestId)
	{
		$this->form_validation->set_rules('guest_name','lang:name','required|max_length[30]');
		$this->form_validation->set_rules('guest_last_name','lang:last_name','required|max_length[30]');
		$this->form_validation->set_rules('guest_telephone','lang:telephone','required|numeric|max_length[20]');
		$this->form_validation->set_rules('guest_email','lang:email','required|valid_email|max_length[50]');
		$this->form_validation->set_rules('guest_address','lang:address','max_length[300]');
		
		if ($this->form_validation->run() == FALSE) {
		
			$guest = $this->GM->getInfo('GUEST', 'ID_GUEST', $guestId, null, null, null, 1);
			
			$data['guest'] = $guest;

			$this->load->view('pms/guests/guest_edit_view', $data);
			
		} else {
		
			$guestName      = set_value('guest_name');
			$guestLastName  = set_value('guest_last_name');
			$guestTelephone = set_value('guest_telephone');
			$guestEmail     = set_value('guest_email');
			$guestAddress   = set_value('guest_address');
			
			$data = array(
				'NAME'      => ucwords(strtolower($guestName)),
				'LAST_NAME' => ucwords(strtolower($guestLastName)),
				'TELEPHONE' => $guestTelephone,
				'EMAIL'     => $guestEmail,
				'ADDRESS'   => $guestAddress
				);
			
			$this->GM->update('GUEST', 'ID_GUEST', $guestId, $data);  
				
			$this->infoGuestReservations($guestId); 
		}
	}
	
	
	function deleteGuest($guestId)
	{
		$guestReservation = $this->GM->getInfo('RESERVATION', 'FK_ID_GUEST', $guestId, null, null, null, 1);
		
		$datestring = "%Y-%m-%d  %h:%i %a";
		$time       = time();
		$date       = mdate($datestring, $time);
		
		$delete    = 'Yes';
		$iniResNum = array();
		
		foreach ($guestReservation as $row) {
		
		 	$resNum   = $row['ID_RESERVATION'];
			$checkIn  = $row['CHECK_IN'];
			$checkOut = $row['CHECK_OUT'];
			$status   = $row['STATUS'];

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
		
			echo 'No se puede eliminar porque tiene reservaciones pendientes: '."<br>";
			foreach ($resultado as $actual)
    		echo '# ',$actual . "<br>"; 
			
			$this->infoGuestReservations($guestId);
			
		} else {
		
			$this->GM->disable('GUEST', 'ID_GUEST', $guestId);  
			echo 'Cliente eliminado!';
			$this->viewGuests(); 
		}	
	}
	
	
	






}
?>