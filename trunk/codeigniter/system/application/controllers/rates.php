<?php

class Rates extends Controller
{
    function Rates()
	{
        parent::Controller();
        $this->load->model('general_model','GNM');
        $this->lang->load ('form_validation','spanish');
        $this->load->library('form_validation');
		$this->load->library('session');
		$this->load->helper('hoteles');
        $this->load->helper('form');
		$this->load->helper('url');
	}
	
	
	function viewRates()
	{
		$hotel = $this->session->userdata('hotelid');
		
		$rates    = $this->GNM->getInfo($hotel, 'RATE', null, null, null, null, null, 1);
		$ratesDis = $this->GNM->getInfo($hotel, 'RATE', 'disable', '0', null, null, null, null);
		
		$data['rates'] = $rates;
		$data['ratesDis'] = $ratesDis;
		
		$this->load->view('pms/rates/rates_view', $data);
	}
	
	
	function viewDisabledRates()
	{
	    $hotel = $this->session->userdata('hotelid');
	
		$ratesDis = $this->GNM->getInfo($hotel, 'RATE', 'disable', '0', null, null, null, null);
		
		$data['ratesDis'] = $ratesDis;
		
		$this->load->view('pms/rates/rates_disabled_view', $data);
	}
	
	
	function addRate()
	{
		$hotel = $this->session->userdata('hotelid');
		
		$this->form_validation->set_rules('rate_name', 'lang:name', 'trim|xss_clean|required|max_length[100]|callback_checkRateName');
		$this->form_validation->set_rules('rate_description', 'lang:description', 'trim|xss_clean|max_length[300]');
		
		if ($this->form_validation->run() == FALSE) {
		
			$this->load->view('pms/rates/rate_add_view');
			
		} else {
		
			$rateName        = set_value('rate_name');
			$rateDescription = set_value('rate_description');
			
			$data = array(
				  'name'        => ucwords(strtolower($rateName)),
				  'description' => $rateDescription,
				  'fk_hotel'    => $hotel
				   );
			
			$this->GNM->insert('RATE', $data);  
				
			$this->viewRates(); 
		}	
	}
	
	
	function editRate($rateId)
	{	
		$this->form_validation->set_rules('rate_name', 'lang:name', 'trim|xss_clean|required|max_length[100]|callback_checkRateName');
		$this->form_validation->set_rules('rate_description', 'lang:description', 'trim|xss_clean|max_length[300]');
		
		if ($this->form_validation->run() == FALSE) {
		
			$hotel = $this->session->userdata('hotelid');
			
			$rate = $this->GNM->getInfo($hotel, 'RATE', 'id_rate', $rateId, null, null, null, 1);
			
			$data['rate'] = $rate;
		
			$this->load->view('pms/rates/rate_edit_view', $data);
			
		} else {
		
			$rateName        = set_value('rate_name');
			$rateDescription = set_value('rate_description');
			
			$data = array(
				  'name'      => ucwords(strtolower($rateName)),
				  'description' => $rateDescription
				   );
			
			$this->GNM->update('RATE', 'id_rate', $rateId, $data);  
				
			$this->viewRates();  
		}	
	}
	
	
	function disableRate($rateId)
	{
		$this->GNM->disable('RATE', 'id_rate', $rateId); 
		
		$this->viewRates(); 	
	}
	
	
	function enableRate($rateId)
	{
		$data = array(
				'disable' => 1
				);
			
		$this->GNM->update('RATE', 'id_rate', $rateId, $data);   
		
		$this->viewRates(); 	
	}
	
	
	function checkRateName($str)
	{
		$rateId = $this->uri->segment(3);
		$hotel = $this->session->userdata('hotelid');
		
		$rates = $this->GNM->validationCheck($hotel, 'RATE', 'name', $str, 'id_rate !=', $rateId, 1);

		if ($rates) {
		
			$this->form_validation->set_message('checkRateName', 'Nombre de tarifa no disponible');
			return FALSE;
			
		} else {
		
			return TRUE;
		}
	}
	
	
	
	
	
	

}
?>