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
		$this->load->library('pagination');
		$this->load->library('encrypt');
		$this->load->library('session');
		$this->load->library('email');
		$this->load->helper('language');
		$this->load->helper('hoteles');
		$this->load->helper('date');
		$this->load->helper('form');
		$this->load->helper('url');
	}
	
	function index()
	{
		echo 'user controller';
	}
	
	
	function viewUsers()
	{
		$sessionUserId = $this->session->userdata('userid');
		
		if ($sessionUserId) {

			$hotel = $this->session->userdata('hotelid');
			
			$lim2      = $this->uri->segment(3);
			$totalRows = $this->GNM->getTotalRows($hotel, 'USER', null, null, 1);
			
			$config['base_url']    = base_url().'users/viewUsers';
			$config['total_rows']  = $totalRows;
			$config['per_page']    = '10';
			$config['num_links']   = '50';
			$config['uri_segment'] = 3;
			
			$this->pagination->initialize($config); 
			
			$users    = $this->GNM->getInfo($hotel, 'USER', null,      null, 'lastName', $config['per_page'], $lim2, 1);
			$usersDis = $this->GNM->getInfo($hotel, 'USER', 'disable', '0',  null,       null,                null,  null);
			
			$data['users']    = $users;
			$data['usersDis'] = $usersDis;
			
			$this->load->view('pms/users/users_view', $data);
			
		} else {
			
			$data['error'] = NULL;
			$this->load->view('pms/users/user_sign_in', $data);
		}
	}
	
	
	function viewDisabledUsers()
	{
		$sessionUserId = $this->session->userdata('userid');
		
		if ($sessionUserId) {
		
			$hotel = $this->session->userdata('hotelid');
		
			$lim2      = $this->uri->segment(3);
			$totalRows = $this->GNM->getTotalRows($hotel, 'USER', 'disable', '0', null);
			
			$config['base_url'] = base_url().'users/viewDisabledUsers/';
			$config['total_rows'] = $totalRows;
			$config['per_page'] = '10';
			$config['num_links'] = '50';
		
			$this->pagination->initialize($config);
			
			$usersDis = $this->GNM->getInfo($hotel, 'USER', 'disable', '0', 'lastName', $config['per_page'], $lim2, null);
			
			$data['usersDis'] = $usersDis;
			
			$this->load->view('pms/users/users_disabled_view', $data);
			
		} else {
			
			$data['error'] = NULL;
			$this->load->view('pms/users/user_sign_in', $data);
		}
	}
	
	
	function infoUser($userId)
	{
		$sessionUserId = $this->session->userdata('userid');
		
		if ($sessionUserId) {
		
			$hotel = $this->session->userdata('hotelid');
		
			$userId = $this->uri->segment(3);
			
			$user       = $this->GNM->getInfo($hotel, 'USER',      'id_user', $userId, 'lastName', null, null, null);
			$telephones = $this->GNM->getInfo(null,   'TELEPHONE', 'fk_user', $userId,  null,      null, null, null);
			
			$data['user']       = $user;
			$data['telephones'] = $telephones;
			
			$this->load->view('pms/users/user_info_view', $data);
		
		} else {
			
			$data['error'] = NULL;
			$this->load->view('pms/users/user_sign_in', $data);
		}
	}
	
	
	function addUser()
	{	
		$hotel = $this->session->userdata('hotelid');
	
		$this->form_validation->set_rules('user_id_type','lang:id_type','trim|xss_clean|required|max_length[2]');
		$this->form_validation->set_rules('user_id_num','lang:id_num','trim|xss_clean|required|max_length[10]|callback_checkUserId');
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
		$this->form_validation->set_rules('user_role','lang:role','trim|xss_clean|required|max_length[50]');
		$this->form_validation->set_rules('username','lang:username','trim|xss_clean|required|min_length[6]|max_length[20]|callback_checkUsername');
		$this->form_validation->set_rules('user_password','lang:password','trim|xss_clean|required|min_length[6]|max_length[30]|matches[user_repeat_password]');
		$this->form_validation->set_rules('user_repeat_password','lang:repeat_password','trim|xss_clean|required');
		
		if ($this->form_validation->run() == FALSE) {
		
			$sessionUserId = $this->session->userdata('userid');
			
			if ($sessionUserId) {
				
				$this->load->view('pms/users/user_add_view');
				
			} else {
	
				$data['error'] = NULL;
				$this->load->view('pms/users/user_sign_in', $data);
			}
		
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
			$userRole      = set_value('user_role');
			$username      = set_value('username');
			$userPassword  = set_value('user_password');
			
			$encodedPassword = $this->encrypt->encode($userPassword);
			
			$data = array(
				'idType'           => $userIdType,
				'idNum'            => $userIdNum,
				'name'             => ucwords(strtolower($userName)),
				'name2'            => ucwords(strtolower($user2Name)),
				'lastName'         => ucwords(strtolower($userLastName)),
				'lastName2'        => ucwords(strtolower($user2LastName)),
				'email'            => strtolower($userEmail),
				'address'          => ucwords(strtolower($userAddress)),
				'role'             => $userRole,
				'username'         => strtolower($username),
				'password'         => $encodedPassword,
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
		
			$data['message'] = lang("addUserMessage");
			$data['type'] = 'users'; 
				
			$this->load->view('pms/success', $data);
		}
	}
	
	
	function editUser($userId)
	{
		$sessionUserId = $this->session->userdata('userid');
		
		if ($sessionUserId) {
		
			$hotel = $this->session->userdata('hotelid');
	
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
			$this->form_validation->set_rules('user_role','lang:role','trim|xss_clean|required|max_length[50]');
			
			if ($this->form_validation->run() == FALSE) {
			
				$user       = $this->GNM->getInfo($hotel, 'USER',      'id_user', $userId, 'lastName', null, null, 1);
				$telephones = $this->GNM->getInfo(null,   'TELEPHONE', 'fk_user', $userId,  null,      null, null, null);
				
				$data['user']       = $user;
				$data['telephones'] = $telephones;
				
				$this->load->view('pms/users/user_edit_view', $data);
			
			} else {
				
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
				$userRole      = set_value('user_role');
				
				$data = array(
					'name'      => ucwords(strtolower($userName)),
					'name2'     => ucwords(strtolower($user2Name)),
					'lastName'  => ucwords(strtolower($userLastName)),
					'lastName2' => ucwords(strtolower($user2LastName)),
					'email'     => strtolower($userEmail),
					'address'   => ucwords(strtolower($userAddress)),
					'role'      => $userRole
					);
				
				$this->GNM->update('USER', 'id_user', $userId, $data);  
					
				$data = array(
					'type'              => $userTelType1,
					'number'            => $userTelNum1,
					'fk_hotel'          => NULL,
					'fk_user'           => $userId,
					'fk_travel_agency'  => NULL,
					'fk_representative' => NULL
					);
				
				$this->GNM->doubleUpdate('TELEPHONE', 'fk_user', $userId, 'telNum', 1, $data);
				
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
				
					$exTel = $this->USM->getTelInfo('fk_user', $userId, 'telNum', 2);
					
					if ($exTel) {
						
						$this->GNM->doubleUpdate('TELEPHONE', 'fk_user', $userId, 'telNum', 2, $data);
							
					} else {
					
						$this->GNM->insert('TELEPHONE', $data);
					}
				}
				
				$data['message'] = lang("editUserMessage");
				$data['type']    = 'session_user';
				$data['userId']  = $userId;
				
				$this->load->view('pms/success', $data);  
			}
			
		} else {
		
			$data['error'] = NULL;
			$this->load->view('pms/users/user_sign_in', $data);
		}
	}
	
	
	function modifyUserPassword($userId)
	{
		$sessionUserId = $this->session->userdata('userid');
		
		if ($sessionUserId) {
			
			$hotel = $this->session->userdata('hotelid');
	
			$this->form_validation->set_rules('user_password','lang:password','trim|xss_clean|required');
			$this->form_validation->set_rules('user_new_password','lang:new_password','trim|xss_clean|required|min_length[6]|max_length[30]|matches[user_repeat_new_password]');
			$this->form_validation->set_rules('user_repeat_new_password','lang:repeat_new_password','trim|xss_clean|required');
			
			if ($this->form_validation->run() == FALSE) {
				
				$user = $this->GNM->getInfo($hotel, 'USER', 'id_user', $userId, null, null, null, 1);
				
				$data['user'] = $user;
				
				$this->load->view('pms/users/user_modify_password_view', $data);
			
			} else {
			
				$userPassword    = set_value('user_password');
				$userNewPassword = set_value('user_new_password');				
				
				$user = $this->GNM->getInfo($hotel, 'USER', 'id_user', $userId, null, null, null, 1);
			
				foreach ($user as $row) {
					
					$encodedPassword = $row['password'];
				}
				
				$decodedPassword = $this->encrypt->decode($encodedPassword);
				
				if ($userPassword == $decodedPassword) {
					
					$encodedNewPassword = $this->encrypt->encode($userNewPassword);
					
					$data = array(
						'password' => $encodedNewPassword
						);
					
					$this->GNM->update('USER', 'id_user', $userId, $data); 
					
					$data['message'] = lang("modUserPassMessage");
					$data['type']    = 'session_user';
					$data['userId']  = $userId;
					
					$this->load->view('pms/success', $data);
					 
				} else {
					
					$user = $this->GNM->getInfo($hotel, 'USER', 'id_user', $userId, null, null, null, 1);
				
					$data['user']   = $user;
					$data['error']  = lang("errorWrongPassword");
					
					$this->load->view('pms/users/user_modify_password_view', $data);
				}
			}
			
		} else {
		
			$data['error'] = NULL;
			$this->load->view('pms/users/user_sign_in', $data);
		}
	}
	
	
	function forgottenPassword()
	{
		
		$hotel = $this->session->userdata('hotelid');
	
		$this->form_validation->set_rules('username','lang:username','trim|xss_clean|required|min_length[6]|max_length[20]');
		$this->form_validation->set_rules('user_email','lang:email','trim|xss_clean|required|valid_email|max_length[50]');
			
		if ($this->form_validation->run() == FALSE) {
		
			$this->load->view('pms/users/user_forgotten_password_view');
		
		} else {
		
			$username  = set_value('username');
			$userEmail = set_value('user_email');
			
			$checkUserEmail = $this->USM->getCheckEmail($username, $userEmail);
			
			if ($checkUserEmail) {
				
				$user = $this->GNM->getInfo($hotel, 'USER', 'username', $username, null, null, null, 1);
				
				foreach ($user as $row) {
					
					$encodedPassword = $row['password'];
				}
				
				$decodedPassword = $this->encrypt->decode($encodedPassword);
				
				$config['protocol'] = 'sendmail';
				$config['mailpath'] = '/usr/sbin/sendmail';
				$config['charset'] = 'iso-8859-1';
				$config['wordwrap'] = TRUE;

				$this->email->initialize($config);


				$this->email->from('elimpg@gmail.com', 'Hoteles.com.ve');
				$this->email->to($userEmail);
				
				$this->email->subject('Contraseña Olvidada');
				$this->email->message('Contraseña: '.$decodedPassword);
				
				$this->email->send();
				
				echo $this->email->print_debugger();
				
				if ($this->email->send()) {
				
					$data['message'] = lang("sentEmailMessage");
					$data['type'] = 'hotels';
					
					$this->load->view('pms/success', $data);
					
				} else {
					
					echo 'ERROR - NO SE ENVIO CORREO';
					
					$data['message'] = lang("sentEmailMessage");
					$data['type'] = 'hotels';
					
					$this->load->view('pms/success', $data);
				} 
				 
			} else {
				
				$data['error'] = lang("errorWrongUserNameOrEmail");
				
				$this->load->view('pms/users/user_forgotten_password_view', $data);
			}
		}
	}
	
	
	function disableUser($userId)
	{
		$sessionUserId = $this->session->userdata('userid');
		
		if ($sessionUserId) {
			
			$this->GNM->disable('USER', 'id_user', $userId);
				
			$data['message'] = lang("disableUserMessage");
			$data['type'] = 'users';
				
			$this->load->view('pms/success', $data);
			
		} else {
		
			$data['error'] = NULL;
			$this->load->view('pms/users/user_sign_in', $data);
		}
	}
	
	
	function enableUser($userId)
	{
		$sessionUserId = $this->session->userdata('userid');
		
		if ($sessionUserId) {
		
			$data = array(
					'disable' => 1
					);
				
			$this->GNM->update('USER', 'id_user', $userId, $data);  
				
			$data['message'] = lang("enableUserMessage");
			$data['type'] = 'users';
				
			$this->load->view('pms/success', $data);	
		
		} else {
		
			$data['error'] = NULL;
			$this->load->view('pms/users/user_sign_in', $data);
		}	
	}
	
	
	function userSignIn()
	{
		$this->form_validation->set_rules('username','lang:username','trim|xss_clean|required');
		$this->form_validation->set_rules('password','lang:password','trim|xss_clean|required');
		
		if ($this->form_validation->run() == FALSE) {
			
			$data['error'] = NULL;
			
			$this->load->view('pms/users/user_sign_in', $data);
		
		} else {
		
			$username = set_value('username');
			$password = set_value('password');
			
			$user = $this->GNM->getInfo($hotel, 'USER', 'username', $username, null, null, null, 1);
			
			foreach ($user as $row) {
				
				$encodedPassword = $row['password'];
			}
			
			$decodedPassword = $this->encrypt->decode($encodedPassword);
			
			if ($password != $decodedPassword) {
			
				$error         = lang("errorSignIn");
				$data['error'] = $error;
				
				$this->load->view('pms/users/user_sign_in', $data);
			
			} else {
				
				foreach ($user as $row) {
				
					$sessionUserId = $row['id_user'];
					$userRole      = $row['role'];
					$hotelId       = $row['fk_hotel'];
				}
				
				$newdata = array(
                   'userid'   => $sessionUserId,
				   'userrole' => $userRole,
				   'hotelid'  => $hotelId
               	);

				$this->session->set_userdata($newdata);

				$this->main();
			}
		}
	}
	
	
	function userSignOut()
	{
		$sessionUserId = $this->session->userdata('userid');
		
		if ($sessionUserId) {
		
			$array_items = array('userid' => '', 'userrole' => '', 'hotelid' => '');

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
		$sessionUserId = $this->session->userdata('userid');
		$hotel         = $this->session->userdata('hotelid');
		
		if ($sessionUserId) {
		
			$userInfo  = $this->GNM->getInfo($hotel, 'USER',  'id_user',  $sessionUserId, null, null, null, 1);
			$hotelInfo = $this->GNM->getInfo(null,   'HOTEL', 'id_hotel', $hotel,         null, null, null, 1);
		
			$data['userInfo']  = $userInfo;
			$data['hotelInfo'] = $hotelInfo;
			
			$this->load->view('pms/main', $data);
			
		} else {
		
			$data['error'] = NULL;
			$this->load->view('pms/users/user_sign_in', $data);
		}
	}
	
	
	function checkUserId($str)
	{
		$hotel = $this->session->userdata('hotelid');
	
		$users = $this->GNM->validationCheck($hotel, 'USER', 'idNum', $str, null, null, null); // OJO!! SE QUITO EL USER ID!!!	

		if ($users) {
		
			$this->form_validation->set_message('checkUserId', lang("errorId"));
			return FALSE;
			
		} else {
		
			return TRUE;
		}
	}
	
	
	function checkUsername($str)
	{
		$users = $this->GNM->validationCheck(null, 'USER', 'username', $str, null, null, null); // OJO!! SE QUITO EL USER ID!!!

		if ($users) {
		
			$this->form_validation->set_message('checkUsername', lang("errorUsername"));
			return FALSE;
			
		} else {
		
			return TRUE;
		}
	}





}
?>