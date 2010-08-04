<?php

class Plans extends Controller
{
    function Plans()
	{
        parent::Controller();
        $this->load->model('general_model','GNM');
		$this->load->model('plans_model','PLM');
        $this->lang->load ('form_validation','spanish');
        $this->load->library('form_validation');
		$this->load->library('session');
        $this->load->helper('form');
	}
	
	
	function viewPlans()
	{
		$hotel = $this->session->userdata('hotelid');
			
		$plans = $this->PLM->getPlanInfo($hotel, null, null);
		
		$data['plans'] = $plans;
		
		$this->load->view('pms/plans/plans_view', $data);
	}
	
	
	function addPlan()
	{
		$this->form_validation->set_rules('plan_name', 'lang:name', 'required|max_length[100]|callback_checkPlanName');
		
		if ($this->form_validation->run() == FALSE) {
		
			$this->load->view('pms/plans/plan_add_view', $data);
			
		} else {
		
			$planName = set_value('plan_name');
			
			$data = array(
				  'name' => ucwords(strtolower($rateName))
				   );
			
			$this->GNM->insert('PLAN', $data);  
				
			$this->viewPlan(); 
		}	
	}
	
	
	function editPlan($planId)
	{
		$this->form_validation->set_rules('plan_name', 'lang:name', 'required|max_length[100]|callback_checkPlanName');
		
		if ($this->form_validation->run() == FALSE) {
		
			$hotel = $this->session->userdata('hotelid');
			
		    $plan = $this->PLM->getPlanInfo($hotel, 'HP.fk_plan', $planId);
			
			$data['plan'] = $plan;
		
			$this->load->view('pms/plans/plan_edit_view', $data);
			
		} else {
		
			$planName = set_value('plan_name');
			
			$data = array(
				  'name' => ucwords(strtolower($planName))
				   );
			
			$this->GNM->update('PLAN', 'id_plan', $planId, $data);  
				
			$this->viewPlans();  
		}	
	}
	
	
	function checkPlanName($str)
	{
		$planId = $this->uri->segment(3);
		$hotel = $this->session->userdata('hotelid');
		
		$plans = $this->GNM->validationCheck($hotel, 'PLAN', 'name', $str, 'id_plan !=', $planId, null);

		if ($plans) {
		
			$this->form_validation->set_message('checkPlanName', 'Nombre de plan no disponible');
			return FALSE;
			
		} else {
		
			return TRUE;
		}
	}
	
	
	
	
	
	

}
?>