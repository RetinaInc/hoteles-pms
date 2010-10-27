<?php

class Rates extends Controller
{
    function Rates()
	{
        parent::Controller();
        $this->load->model('general_model','GNM');
        $this->lang->load ('form_validation','spanish');
        $this->load->library('form_validation');
		$this->load->library('pagination');
		$this->load->library('session');
		$this->load->helper('language');
		$this->load->helper('hoteles');
		$this->load->helper('date');
        $this->load->helper('form');
		$this->load->helper('url');
	}
	
	
	function viewRates()
	{
		$userId = $this->session->userdata('userid');
		
		if ($userId) {
		
			$hotel = $this->session->userdata('hotelid');
			
			$lim2      = $this->uri->segment(3);
			$totalRows = $this->GNM->getTotalRows($hotel, 'RATE', null, null, 1);
			
			$config['base_url'] = base_url().'rates/viewRates/';
			$config['total_rows'] = $totalRows;
			$config['per_page'] = '4';
			$config['num_links'] = '50';
		
			$this->pagination->initialize($config);
			
			$rates    = $this->GNM->getInfo($hotel, 'RATE', null, null, 'name', $config['per_page'] , $lim2, 1);
			$ratesDis = $this->GNM->getInfo($hotel, 'RATE', 'disable', '0', null, null, null, null);
			
			$data['rates'] = $rates;
			$data['ratesDis'] = $ratesDis;
			
			$this->load->view('pms/rates/rates_view', $data);
			
		} else {
		
			$data['error'] = NULL;
			$this->load->view('pms/users/user_sign_in', $data);
		}
	}
	
	
	function viewDisabledRates()
	{
		$userId = $this->session->userdata('userid');
		
		if ($userId) {
		
			$hotel = $this->session->userdata('hotelid');
		
			$lim2      = $this->uri->segment(3);
			$totalRows = $this->GNM->getTotalRows($hotel, 'RATE', 'disable', '0', null);
			
			$config['base_url'] = base_url().'rates/viewDisabledRates/';
			$config['total_rows'] = $totalRows;
			$config['per_page'] = '3';
			$config['num_links'] = '50';
		
			$this->pagination->initialize($config);
			
			$ratesDis = $this->GNM->getInfo($hotel, 'RATE', 'disable', '0', 'name', $config['per_page'], $lim2, null);
			
			$data['ratesDis'] = $ratesDis;
			
			$this->load->view('pms/rates/rates_disabled_view', $data);
		
		} else {
			
			$data['error'] = NULL;
			$this->load->view('pms/users/user_sign_in', $data);
		}
	}
	
	
	function addRate()
	{	
		$hotel = $this->session->userdata('hotelid');
			
		$this->form_validation->set_rules('rate_name', 'lang:name', 'trim|xss_clean|required|max_length[100]|callback_checkRateName');
		$this->form_validation->set_rules('rate_description', 'lang:description', 'trim|xss_clean|max_length[300]');
			
		if ($this->form_validation->run() == FALSE) {
			
			$userId = $this->session->userdata('userid');
		
			if ($userId) {
			
				$this->load->view('pms/rates/rate_add_view');
			
			} else {
			
				$data['error'] = NULL;
				$this->load->view('pms/users/user_sign_in', $data);
			}
				
		} else {
			
			$rateName        = set_value('rate_name');
			$rateDescription = set_value('rate_description');
				
			$data = array(
				'name'        => ucwords(strtolower($rateName)),
				'description' => $rateDescription,
				'fk_hotel'    => $hotel
					);
				
			$this->GNM->insert('RATE', $data);  
					
			$data['message'] = lang("addRateMessage");
			$data['type'] = 'rates';
				
			$this->load->view('pms/success', $data); 
		}	
	}
	
	
	function editRate($rateId)
	{	
		$this->form_validation->set_rules('rate_name', 'lang:name', 'trim|xss_clean|required|max_length[100]|callback_checkRateName');
		$this->form_validation->set_rules('rate_description', 'lang:description', 'trim|xss_clean|max_length[300]');
		
		if ($this->form_validation->run() == FALSE) {
		
			$userId = $this->session->userdata('userid');
		
			if ($userId) {
		
				$hotel = $this->session->userdata('hotelid');
				
				$rate = $this->GNM->getInfo($hotel, 'RATE', 'id_rate', $rateId, null, null, null, 1);
				
				$data['rate'] = $rate;
			
				$this->load->view('pms/rates/rate_edit_view', $data);
				
			} else {
				
				$data['error'] = NULL;
				$this->load->view('pms/users/user_sign_in', $data);
			}
			
		} else {
		
			$rateName        = set_value('rate_name');
			$rateDescription = set_value('rate_description');
			
			$data = array(
				  'name'      => ucwords(strtolower($rateName)),
				  'description' => $rateDescription
				   );
			
			$this->GNM->update('RATE', 'id_rate', $rateId, $data);  
				
			$data['message'] = lang("editRateMessage");
			$data['type'] = 'rates';
				
			$this->load->view('pms/success', $data);  
		}	
	}
	
	
	function disableRate($rateId)
	{
		$userId = $this->session->userdata('userid');
		
		if ($userId) {
		
			$this->GNM->disable('RATE', 'id_rate', $rateId); 
			
			$data['message'] = lang("disableRateMessage");
			$data['type'] = 'rates';
				
			$this->load->view('pms/success', $data);
		
		} else {
		
			$data['error'] = NULL;
			$this->load->view('pms/users/user_sign_in', $data);
		}	
	}
	
	
	function enableRate($rateId)
	{
		$userId = $this->session->userdata('userid');
		
		if ($userId) {
		
			$data = array(
					'disable' => 1
					);
				
			$this->GNM->update('RATE', 'id_rate', $rateId, $data);   
			
			$data['message'] = lang("enableRateMessage");
			$data['type'] = 'rates';
				
			$this->load->view('pms/success', $data);
				
		} else {
		
			$data['error'] = NULL;
			$this->load->view('pms/users/user_sign_in', $data);
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