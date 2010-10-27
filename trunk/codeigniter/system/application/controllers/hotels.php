<?php

class Hotels extends Controller
{
	function Hotels()
	{
		parent::Controller();
		$this->load->model('general_model','GNM');
		$this->load->model('users_model','USM');
		$this->lang->load ('form_validation','spanish');
		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->helper('language');
		$this->load->helper('hoteles');
		$this->load->helper('date');
		$this->load->helper('form');
		$this->load->helper('url');
	}
	
	function index()
	{
		echo 'hotel controller';
	}
	
	
	function infoHotel()
	{
		$sessionUserId = $this->session->userdata('userid');
		
		if ($sessionUserId) {
			
			$hotel = $this->session->userdata('hotelid');
			
			$hotelInfo  = $this->GNM->getInfo(null,   'HOTEL',    'id_hotel', $hotel,  null, null, null, 1);
			$telephones = $this->GNM->getInfo($hotel, 'TELEPHONE', null,      null,    null, null, null, null);
			$places     = $this->GNM->getInfo(null,   'PLACE',     null,      null,    null, null, null, null);
			
			$data['hotelInfo']  = $hotelInfo;
			$data['telephones'] = $telephones;
			$data['places']     = $places;
			
			$this->load->view('pms/hotels/hotel_info_view', $data);
			
		} else {
			
			$data['error'] = NULL;
			$this->load->view('pms/users/user_sign_in', $data);
		}
	}
	
	
	function registerHotel()
	{
		$this->form_validation->set_rules('hotel_name','lang:name','trim|xss_clean|required|max_length[500]|callback_checkHotelName');
		$this->form_validation->set_rules('hotel_type','lang:type','trim|xss_clean|required|max_length[50]');
		$this->form_validation->set_rules('hotel_description','lang:description','trim|xss_clean|required|max_length[300]');
		$this->form_validation->set_rules('hotel_country','lang:country','trim|xss_clean|required');
		$this->form_validation->set_rules('hotel_city','lang:city','trim|xss_clean|required');
		$this->form_validation->set_rules('hotel_address','lang:address','trim|xss_clean|required|max_length[300]');
		$this->form_validation->set_rules('hotel_ref_address','lang:ref_address','trim|xss_clean|max_length[500]');
		$this->form_validation->set_rules('hotel_tel_type_1','lang:tel_type','trim|xss_clean|required');
		$this->form_validation->set_rules('hotel_tel_num_1','lang:tel_num','trim|xss_clean|required');
		$this->form_validation->set_rules('hotel_tel_type_2','lang:tel_type','trim|xss_clean');
		$this->form_validation->set_rules('hotel_tel_num_2','lang:tel_num','trim|xss_clean');
		$this->form_validation->set_rules('hotel_tel_type_3','lang:tel_type','trim|xss_clean');
		$this->form_validation->set_rules('hotel_tel_num_3','lang:tel_num','trim|xss_clean');
		$this->form_validation->set_rules('hotel_web_page','lang:web_page','trim|xss_clean|max_length[100]');
		$this->form_validation->set_rules('hotel_email','lang:email','trim|xss_clean|required|valid_email|max_length[50]');
		$this->form_validation->set_rules('hotel_cancel_info','lang:cancel_info','trim|xss_clean|max_length[800]');
		
		if ($this->form_validation->run() == FALSE) {
			
			$countries = $this->GNM->getInfo(null, 'PLACE', 'type', 'Country', 'name', null, null, null);
			
			$data['countries'] = $countries;
			
			$this->load->view('pms/hotels/hotel_register_view', $data);
			
		} else {
		
			$hotelName        = set_value('hotel_name');
			$hotelType        = set_value('hotel_type');
			$hotelDescription = set_value('hotel_description');
			$hotelCity        = set_value('hotel_city');
			$hotelAddress     = set_value('hotel_address');
			$hotelRefAddress  = set_value('hotel_ref_address');
			$hotelWebPage     = set_value('hotel_web_page');
			$hotelEmail       = set_value('hotel_email');
			$hotelCancelInfo  = set_value('hotel_cancel_info');
			
			$hotelTelType1    = set_value('hotel_tel_type_1');
			$hotelTelNum1     = set_value('hotel_tel_num_1');
			$hotelTelType2    = set_value('hotel_tel_type_2');
			$hotelTelNum2     = set_value('hotel_tel_num_2');
			$hotelTelType3    = set_value('hotel_tel_type_3');
			$hotelTelNum3     = set_value('hotel_tel_num_3');
			
			$data = array(
				'name'        => ucwords(strtolower($hotelName)),
				'type'        => ucwords(strtolower($hotelType)),
				'description' => $hotelDescription,
				'address'     => ucwords(strtolower($hotelAddress)),
				'refAddress'  => $hotelRefAddress,
				'webPage'     => strtolower($hotelWebPage),
				'email'       => strtolower($hotelEmail),
				'cancelInfo'  => $hotelCancelInfo,
				'pms'         => 1,
				'fk_place'    => $hotelCity
				);
			
			$this->GNM->insert('HOTEL', $data);
			
			$hotelId = $this->db->insert_id('HOTEL');
			
			$data = array(
				'telNum'            => 1,
				'type'              => $hotelTelType1,
				'number'            => $hotelTelNum1,
				'fk_hotel'          => $hotelId,
				'fk_user'           => NULL,
				'fk_travel_agency'  => NULL,
				'fk_representative' => NULL
				);
			
			$this->GNM->insert('TELEPHONE', $data);
			
			if ($hotelTelNum2 != NULL) {
			
				$data = array(
					'telNum'            => 2,
					'type'              => $hotelTelType2,
					'number'            => $hotelTelNum2,
					'fk_hotel'          => $hotelId,
					'fk_user'           => NULL,
					'fk_travel_agency'  => NULL,
					'fk_representative' => NULL
				);
			
				$this->GNM->insert('TELEPHONE', $data);
			}
			
			if ($hotelTelNum3 != NULL) {
			
				$data = array(
					'telNum'            => 3,
					'type'              => $hotelTelType3,
					'number'            => $hotelTelNum3,
					'fk_hotel'          => $hotelId,
					'fk_user'           => NULL,
					'fk_travel_agency'  => NULL,
					'fk_representative' => NULL
				);
			
				$this->GNM->insert('TELEPHONE', $data);
			}
		
			$data['hotelId'] = $hotelId;
			
			$this->load->view('pms/hotels/hotel_register_2_view', $data); 
		}
	}
	
	
	function registerHotel2()
	{	
		$hotel = $this->uri->segment(3);
		
		if ($hotel) {
	
			$this->form_validation->set_rules('user_id_type','lang:id_type','trim|xss_clean|required|max_length[2]');
			$this->form_validation->set_rules('user_id_num','lang:id_num','trim|xss_clean|required|max_length[10]|callback_checkNewUserId');
			$this->form_validation->set_rules('user_name','lang:name','trim|xss_clean|required|max_length[30]');
			$this->form_validation->set_rules('user_2name','lang:2name','trim|xss_clean|max_length[30]');
			$this->form_validation->set_rules('user_last_name','lang:last_name','trim|xss_clean|required|max_length[30]');
			$this->form_validation->set_rules('user_2last_name','lang:2last_name','trim|xss_clean|max_length[30]');
			$this->form_validation->set_rules('user_tel_type_1','lang:tel_type','trim|xss_clean|required');
			$this->form_validation->set_rules('user_tel_num_1','lang:tel_num','trim|xss_clean|required');
			$this->form_validation->set_rules('user_tel_type_2','lang:tel_type','trim|xss_clean');
			$this->form_validation->set_rules('user_tel_num_2','lang:tel_num','trim|xss_clean');
			$this->form_validation->set_rules('user_email','lang:email','trim|xss_clean|required|valid_email|max_length[50]');
			$this->form_validation->set_rules('user_address','lang:address','trim|xss_clean|max_length[300]');
			$this->form_validation->set_rules('username','lang:username','trim|xss_clean|required|min_length[6]|max_length[20]|callback_checkUsername');
			$this->form_validation->set_rules('user_password','lang:password','trim|xss_clean|required|min_length[6]|max_length[30]|matches[user_repeat_password]|md5');
			$this->form_validation->set_rules('user_repeat_password','lang:repeat_password','trim|xss_clean|required');
			
			if ($this->form_validation->run() == FALSE) {
			
				$this->load->view('pms/users/user_add_master_view');
			
			} else {
				
				$userIdType    = set_value('user_id_type');	
				$userIdNum     = set_value('user_id_num');	
				$userName      = set_value('user_name');
				$user2Name     = set_value('user_2name');
				$userLastName  = set_value('user_last_name');
				$user2LastName = set_value('user_2last_name');
				$userTelType1  = set_value('user_tel_type_1');
				$userTelNum1   = set_value('user_tel_num_1');
				$userTelType2  = set_value('user_tel_type_2');
				$userTelNum2   = set_value('user_tel_num_2');
				$userEmail     = set_value('user_email');
				$userAddress   = set_value('user_address');
				$username      = set_value('username');
				$userPassword  = set_value('user_password');
				
				$data = array(
					'idType'           => $userIdType,
					'idNum'            => $userIdNum,
					'name'             => ucwords(strtolower($userName)),
					'name2'            => ucwords(strtolower($user2Name)),
					'lastName'         => ucwords(strtolower($userLastName)),
					'lastName2'        => ucwords(strtolower($user2LastName)),
					'email'            => strtolower($userEmail),
					'address'          => ucwords(strtolower($userAddress)),
					'role'             => 'Master',
					'username'         => strtolower($username),
					'password'         => $userPassword,
					'fk_hotel'         => $hotel,
					'fk_travel_agency' => NULL
					);
				
				$this->GNM->insert('USER', $data);  
				
				$userId = $this->db->insert_id('USER');
			
				$data = array(
					'telNum'            => 1,
					'type'              => $userTelType1,
					'number'            => $userTelNum1,
					'fk_hotel'          => NULL,
					'fk_user'           => $userId,
					'fk_travel_agency'  => NULL,
					'fk_representative' => NULL
					);
				
				$this->GNM->insert('TELEPHONE', $data);
				
				if ($userTelNum2 != NULL) {
				
					$data = array(
						'telNum'            => 2,
						'type'              => $userTelType2,
						'number'            => $userTelNum2,
						'fk_hotel'          => NULL,
						'fk_user'           => $userId,
						'fk_travel_agency'  => NULL,
						'fk_representative' => NULL
						);
				
					$this->GNM->insert('TELEPHONE', $data);
				}
			
				$data['message'] = lang("registerHotelMessage");
				$data['type'] = 'hotels'; 
				
				$this->load->view('pms/success', $data);
			}
			
		} else {
		
			$data['error'] = NULL;
			$this->load->view('pms/users/user_sign_in', $data);
		}
	}
	
	
	function editHotel($hotelId)
	{	
		$sessionUserId = $this->session->userdata('userid');
		
		if ($sessionUserId) {
			
			$this->form_validation->set_rules('hotel_name','lang:name','trim|xss_clean|required|max_length[500]');
			$this->form_validation->set_rules('hotel_type','lang:type','trim|xss_clean|required|max_length[50]');
			$this->form_validation->set_rules('hotel_description','lang:description','trim|xss_clean|max_length[300]');
			$this->form_validation->set_rules('hotel_country','lang:country','trim|xss_clean|required');
			$this->form_validation->set_rules('hotel_city','lang:city','trim|xss_clean|required');
			$this->form_validation->set_rules('hotel_address','lang:address','trim|xss_clean|required|max_length[300]');
			$this->form_validation->set_rules('hotel_ref_address','lang:ref_address','trim|xss_clean|max_length[500]');
			$this->form_validation->set_rules('hotel_tel_type_1','lang:tel_type','trim|xss_clean|required');
			$this->form_validation->set_rules('hotel_tel_num_1','lang:tel_num','trim|xss_clean|required');
			$this->form_validation->set_rules('hotel_tel_type_2','lang:tel_type','trim|xss_clean');
			$this->form_validation->set_rules('hotel_tel_num_2','lang:tel_num','trim|xss_clean');
			$this->form_validation->set_rules('hotel_tel_type_3','lang:tel_type','trim|xss_clean');
			$this->form_validation->set_rules('hotel_tel_num_3','lang:tel_num','trim|xss_clean');
			$this->form_validation->set_rules('hotel_web_page','lang:web_page','trim|xss_clean|required|max_length[100]');
			$this->form_validation->set_rules('hotel_email','lang:email','trim|xss_clean|required|valid_email|max_length[50]');
			$this->form_validation->set_rules('hotel_cancel_info','lang:cancel_info','trim|xss_clean|max_length[800]');
			
			if ($this->form_validation->run() == FALSE) {
				
				$hotelInfo  = $this->GNM->getInfo(null,     'HOTEL',    'id_hotel', $hotelId,  null,   null, null, 1);
				$telephones = $this->GNM->getInfo($hotelId, 'TELEPHONE', null,      null,      null,   null, null, null);
				$places     = $this->GNM->getInfo(null,     'PLACE',     null,      null,      null,   null, null, null);
				
				$data['hotelInfo']  = $hotelInfo;
				$data['telephones'] = $telephones;
				$data['places']     = $places;
				
				$this->load->view('pms/hotels/hotel_edit_view', $data);
				
			} else {
			
				$hotelName        = set_value('hotel_name');
				$hotelType        = set_value('hotel_type');
				$hotelDescription = set_value('hotel_description');
				$hotelCity        = set_value('hotel_city');
				$hotelAddress     = set_value('hotel_address');
				$hotelRefAddress  = set_value('hotel_ref_address');
				$hotelWebPage     = set_value('hotel_web_page');
				$hotelEmail       = set_value('hotel_email');
				$hotelCancelInfo  = set_value('hotel_cancel_info');
				
				$hotelTelType1    = set_value('hotel_tel_type_1');
				$hotelTelNum1     = set_value('hotel_tel_num_1');
				$hotelTelType2    = set_value('hotel_tel_type_2');
				$hotelTelNum2     = set_value('hotel_tel_num_2');
				$hotelTelType3    = set_value('hotel_tel_type_3');
				$hotelTelNum3     = set_value('hotel_tel_num_3');
				
				$data = array(
					'name'        => $hotelName,
					'type'        => $hotelType,
					'description' => $hotelDescription,
					'address'     => $hotelAddress,
					'refAddress'  => $hotelRefAddress,
					'webPage'     => $hotelWebPage,
					'email'       => $hotelEmail,
					'cancelInfo'  => $hotelCancelInfo,
					'pms'         => 1,
					'fk_place'    => $hotelCity
					);
				
				$this->GNM->update('HOTEL', 'id_hotel', $hotelId, $data);  
				
				$data = array(
					'telNum' => 1,
					'type'   => $hotelTelType1,
					'number' => $hotelTelNum1
					);
				
				$this->GNM->doubleUpdate('TELEPHONE', 'fk_hotel', $hotelId, 'telNum', 1, $data);
				
			
				if ($hotelTelNum2 != NULL) {
				
					$data = array(
						'telNum'            => 2,
						'type'              => $hotelTelType2,
						'number'            => $hotelTelNum2,
						'fk_hotel'          => $hotelId,
						'fk_user'           => NULL,
						'fk_travel_agency'  => NULL,
						'fk_representative' => NULL
					);
					
					$exTel = $this->USM->getTelInfo('fk_hotel', $hotelId, 'telNum', 2);
					
					if ($exTel) {
						
						$this->GNM->doubleUpdate('TELEPHONE', 'fk_hotel', $hotelId, 'telNum', 2, $data);
							
					} else {
					
						$this->GNM->insert('TELEPHONE', $data);
					}
				}
				
				if ($hotelTelNum3 != NULL) {
				
					$data = array(
						'telNum'            => 3,
						'type'              => $hotelTelType3,
						'number'            => $hotelTelNum3,
						'fk_hotel'          => $hotelId,
						'fk_user'           => NULL,
						'fk_travel_agency'  => NULL,
						'fk_representative' => NULL
					);
				
					$exTel = $this->USM->getTelInfo('fk_hotel', $hotelId, 'telNum', 3);
					
					if ($exTel) {
						
						$this->GNM->doubleUpdate('TELEPHONE', 'fk_hotel', $hotelId, 'telNum', 3, $data);
							
					} else {
					
						$this->GNM->insert('TELEPHONE', $data);
					}
				}
				
				$this->infoHotel();
			}
			
		} else {
		
			$data['error'] = NULL;
			$this->load->view('pms/users/user_sign_in', $data);
		}
	}
	
	
	function cancelHotelAccount($hotelId)
	{
		$sessionUserId = $this->session->userdata('userid');
		
		if ($sessionUserId) {
			
			$this->GNM->delete('HOTEL', 'id_hotel', $hotelId);
		
			$array_items = array('userid' => '', 'userrole' => '', 'hotelid' => '');

			$this->session->unset_userdata($array_items);
			$this->session->sess_destroy();
			
			$data['message'] = lang("cancelHotelAccountMessage");
			$data['type'] = 'cancelHotelAccount'; 
				
			$this->load->view('pms/success', $data);
		
		} else {
			
			$data['error'] = NULL;
			$this->load->view('pms/users/user_sign_in', $data);
		}
	}
	
	
	function deleteHotel($hotelId)
	{
		$user = $this->GNM->getInfo($hotelId, 'USER', null, null, null, null, null, null);
		
		if ($user) {
			
			$data['error'] = NULL;
			$this->load->view('pms/users/user_sign_in', $data);
			
		} else {
			
			$this->GNM->delete('HOTEL', 'id_hotel', $hotelId);
			
			$data['error'] = NULL;
			$this->load->view('pms/users/user_sign_in', $data);
		} 
	}
	
	
	function ajax_get_cities()
	{
		$countryId = $this->uri->rsegment(3);
		
		if ($countryId) {
		
			$cities = $this->GNM->getInfo(null, 'PLACE', 'fk_place', $countryId, 'name', null, null, null);
			$result = '';
		
			foreach ($cities as $row) {
			
				$result .= '<option value="'.$row['id_place'].'"'. set_select('hotel_city', $row['id_place']).'>'.$row['name'].'</option>';
			}
		
			echo $result;
		}
		else
		{
			$result = '<option value="">Seleccionar</option>';

			echo $result;
		}
	}
	
	
	function checkHotelName($str)
	{
		$hotelId = $this->uri->segment(3);
		
		$hotels = $this->GNM->validationCheck(null, 'HOTEL', 'name', $str, 'id_hotel !=', $hotelId, null);

		if ($hotels) {
		
			$this->form_validation->set_message('checkHotelName', lang("errorHotelName"));
			return FALSE;
			
		} else {
		
			return TRUE;
		}
	}
	
	
	function checkUsername($str)
	{
		$users = $this->GNM->validationCheck(null, 'USER', 'username', $str, null, null, null);

		if ($users) {
		
			$this->form_validation->set_message('checkUsername', lang("errorUsername"));
			return FALSE;
			
		} else {
		
			return TRUE;
		}
	}






}
?>