<?php

class Users extends Controller
{
	function Users()
	{
		parent::Controller();
		$this->load->model('users_model','USM');
		$this->load->model('general_model','GNM');
		$this->lang->load ('form_validation','spanish');
		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->helper('hoteles');
		$this->load->helper('form');
		$this->load->helper('url');
	}
	
	function index()
	{
		echo 'user controller';
	}
	
	
	function userSignIn()
	{
		$this->form_validation->set_rules('hotel_username','lang:username','trim|required|xss_clean');
		$this->form_validation->set_rules('hotel_password','lang:password','trim|required|xss_clean|md5');
		
		if ($this->form_validation->run() == FALSE) {
			
			$error = NULL;
			$data['error'] = $error;
			
			$this->load->view('pms/users/user_sign_in', $data);
		
		} else {
		
			$username = set_value('hotel_username');
			$password = set_value('hotel_password');
			
			$confirmHotelSignIn = $this->USM->getConfirmHotelUser(null, $username, $password);
		
			if(!$confirmHotelSignIn) {
			
				$error = 'Usuario o Contrase&ntilde;a Incorrecta';
				$data['error'] = $error;
				$this->load->view('pms/users/user_sign_in', $data);
			
			} else {
				
				foreach ($confirmHotelSignIn as $row) {
				
					$userId   = $row['id_user'];
					$hotelId  = $row['fk_hotel'];
				}
				
				$newdata = array(
                   'userid'  => $userId,
				   'hotelid' => $hotelId
               	);

				$this->session->set_userdata($newdata);

				$this->main();
			}
		}
	}
	
	
	function userSignOut()
	{
		$userId = $this->session->userdata('userid');
		
		if ($userId) {
		
			$array_items = array('userid' => '', 'userfullname' => '', 'hotelid' => '');

			$this->session->unset_userdata($array_items);
			$this->session->sess_destroy();

			$error = NULL;
			$data['error'] = $error;
			
			$this->load->view('pms/users/user_sign_in', $data);
		
		} else {
			
			$error = NULL;
			$data['error'] = $error;
			
			$this->load->view('pms/users/user_sign_in', $data);
		}	
	}

	function main()
	{
		$userId = $this->session->userdata('userid');
		$hotel = $this->session->userdata('hotelid');
		
		$userInfo  = $this->GNM->getInfo($hotel, 'USER',  'id_user',  $userId, null, null, null, 1);
		$hotelInfo = $this->GNM->getInfo(null,   'HOTEL', 'id_hotel', $hotel,  null, null, null, 1);
	
		$data['userInfo']  = $userInfo;
		$data['hotelInfo'] = $hotelInfo;
		
		$this->load->view('pms/main', $data);
	}


}
?>