<?php

class Plans extends Controller
{
    function Plans()
	{
        parent::Controller();
        $this->load->model('general_model','GNM');
        $this->lang->load ('form_validation','spanish');
        $this->load->library('form_validation');
		$this->load->library('session');
		$this->load->helper('hoteles');
		$this->load->helper('language');
        $this->load->helper('form');
		$this->load->helper('url');
	}
	
	
	function viewPlans()
	{
		$userId = $this->session->userdata('userid');
		
		if ($userId) {
		
			$hotel = $this->session->userdata('hotelid');
				
			$plans    = $this->GNM->getInfo($hotel, 'PLAN', null,      null, null, null, null, 1);
			$plansDis = $this->GNM->getInfo($hotel, 'PLAN', 'disable', '0',  null, null, null, null);
			
			$data['plans'] = $plans;
			$data['plansDis'] = $plansDis;
			
			$this->load->view('pms/plans/plans_view', $data);
		
		} else {
			
			$data['error'] = NULL;
			$this->load->view('pms/users/user_sign_in', $data);
		}
	}
	
	
	function viewDisabledPlans()
	{
		$userId = $this->session->userdata('userid');
		
		if ($userId) {
		
			$hotel = $this->session->userdata('hotelid');
		
			$plansDis = $this->GNM->getInfo($hotel, 'PLAN', 'disable', '0',  null, null, null, null);
			
			$data['plansDis'] = $plansDis;
			
			$this->load->view('pms/plans/plans_disabled_view', $data);
			
		} else {
			
			$data['error'] = NULL;
			$this->load->view('pms/users/user_sign_in', $data);
		}
	}
	
	
	function addPlan()
	{
		$hotel = $this->session->userdata('hotelid');
		
		$this->form_validation->set_rules('plan_name', 'lang:name', 'trim|xss_clean|required|max_length[100]|callback_checkPlanName');
		$this->form_validation->set_rules('plan_description', 'lang:description', 'trim|xss_clean|max_length[300]');
		
		if ($this->form_validation->run() == FALSE) {
		
			$userId = $this->session->userdata('userid');
		
			if ($userId) {
		
				$this->load->view('pms/plans/plan_add_view');
			
			} else {
				
				$data['error'] = NULL;
				$this->load->view('pms/users/user_sign_in', $data);
			}
			
		} else {
		
			$planName = set_value('plan_name');
			$planDescription = set_value('plan_description');
			
			$data = array(
				  'name'        => ucwords(strtolower($planName)),
				  'description' => $planDescription,
				  'fk_hotel'    => $hotel
				   );
			
			$this->GNM->insert('PLAN', $data);  
				
			$this->viewPlans(); 
		}	
	}
	
	
	function editPlan($planId)
	{
		$hotel = $this->session->userdata('hotelid');
		
		$this->form_validation->set_rules('plan_name', 'lang:name', 'trim|xss_clean|required|max_length[100]|callback_checkPlanName');
		$this->form_validation->set_rules('plan_description', 'lang:description', 'trim|xss_clean|max_length[300]');
		
		if ($this->form_validation->run() == FALSE) {
			
			$userId = $this->session->userdata('userid');
		
			if ($userId) {
			
				$plan = $this->GNM->getInfo($hotel, 'PLAN','id_plan', $planId, null, null, null, 1);
				
				$data['plan'] = $plan;
			
				$this->load->view('pms/plans/plan_edit_view', $data);
				
			} else {
				
				$data['error'] = NULL;
				$this->load->view('pms/users/user_sign_in', $data);
			}
			
		} else {
		
			$planName = set_value('plan_name');
			$planDescription = set_value('plan_description');
			
			$data = array(
				  'name'        => ucwords(strtolower($planName)),
				  'description' => $planDescription
				   );
			
			$this->GNM->update('PLAN', 'id_plan', $planId, $data);  
				
			$this->viewPlans();  
		}	
	}
	
	
	function disablePlan($planId)
	{
		$userId = $this->session->userdata('userid');
		
		if ($userId) {

			$this->GNM->disable('PLAN', 'id_plan', $planId); 
			$this->viewPlans(); 
		
		} else {
			
			$data['error'] = NULL;
			$this->load->view('pms/users/user_sign_in', $data);
		}	
	}
	
	
	function enablePlan($planId)
	{
		$userId = $this->session->userdata('userid');
		
		if ($userId) {
		
			$data = array(
					'disable' => 1
					);
				
			$this->GNM->update('PLAN', 'id_plan', $planId, $data);   
			
			$this->viewPlans(); 	
			
		} else {
		
			$data['error'] = NULL;
			$this->load->view('pms/users/user_sign_in', $data);
		}
	}
	
	
	function checkPlanName($str)
	{
		$planId = $this->uri->segment(3);
		$hotel = $this->session->userdata('hotelid');
		
		$plans = $this->GNM->validationCheck($hotel, 'PLAN', 'name', $str, 'id_plan !=', $planId, null);

		if ($plans) {
		
			$this->form_validation->set_message('checkPlanName', lang("errorPlanName"));
			return FALSE;
			
		} else {
		
			return TRUE;
		}
	}
	
	
	
	
	
	

}
?>