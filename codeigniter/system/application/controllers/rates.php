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
        $this->load->helper('form');
	}
	
	
	function viewRates()
	{
		$hotel = $this->session->userdata('hotelid');
		
		$rates = $this->GNM->getInfo($hotel, 'RATE', null, null, null, null, null, 1);
		
		$data['rates'] = $rates;
		
		$this->load->view('pms/rates/rates_view', $data);
	}
	
	
	function addRate()
	{
		$hotel = $this->session->userdata('hotelid');
		
		$this->form_validation->set_rules('rate_name', 'lang:name', 'required|max_length[100]|callback_checkRateName');
		$this->form_validation->set_rules('rate_description', 'lang:description', 'max_length[300]');
		
		if ($this->form_validation->run() == FALSE) {
		
			$this->load->view('pms/rates/rate_add_view', $data);
			
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
		$this->form_validation->set_rules('rate_name', 'lang:name', 'required|max_length[100]|callback_checkRateName');
		$this->form_validation->set_rules('rate_description', 'lang:description', 'max_length[300]');
		
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