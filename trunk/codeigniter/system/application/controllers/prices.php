<?php

class Prices extends Controller
{
    function Prices()
	{
        parent::Controller();
        $this->load->model('general_model','GNM');
		$this->load->model('prices_model','PRM');
        $this->lang->load ('form_validation','spanish');
        //$this->load->library('form_validation');
		$this->load->library('session');
        $this->load->helper('hoteles');
        $this->load->helper('language');
        $this->load->helper('form');
        $this->load->helper('url');
	}
	
	/*
	function selectViewPrices()
	{	
		$this->load->view('pms/prices/prices_select_view');
	}
	*/
	
	function selectSeasonPrices()
	{
		$userId = $this->session->userdata('userid');
		
		if ($userId) {
		
			$hotel = $this->session->userdata('hotelid');
				
			$seasons   = $this->GNM->getInfo($hotel, 'SEASON',  null, null, null, null, null, 1);
			$rates     = $this->GNM->getInfo($hotel, 'RATE',    null, null, null, null, null, 1);
			$plans     = $this->GNM->getInfo($hotel, 'PLAN',    null, null, null, null, null, 1);
			$roomTypes = $this->GNM->getInfo($hotel, 'ROOM_TYPE', null, null, null, null, null, 1);
			
			$data['seasons']   = $seasons;
			$data['rates']     = $rates;
			$data['plans']     = $plans;
			$data['roomTypes'] = $roomTypes;
			
			$this->load->view('pms/prices/prices_select_season_view', $data);
			
		} else {
		
			$data['error'] = NULL;
			$this->load->view('pms/users/user_sign_in', $data);
		}
	}
	
	
	function selectRatePrices($seasonId)
	{
		$userId = $this->session->userdata('userid');
		
		if ($userId) {
		
			$hotel = $this->session->userdata('hotelid');
				
			$season = $this->GNM->getInfo($hotel, 'SEASON', 'id_season', $seasonId, null, null, null, 1);
			$rates  = $this->GNM->getInfo($hotel, 'RATE',      null, null, null, null, null, 1);
			
			$data['season'] = $season;
			$data['rates']  = $rates;
			
			$this->load->view('pms/prices/prices_select_rate_view', $data);
		
		} else {
			
			$data['error'] = NULL;
			$this->load->view('pms/users/user_sign_in', $data);
		}
	}
	
	
	function selectPlanPrices()
	{
		$userId = $this->session->userdata('userid');
		
		if ($userId) {
		
			$seasonId = $this->uri->segment(3);
			$rateId   = $this->uri->segment(4);
			
			$hotel = $this->session->userdata('hotelid');
				
			$season = $this->GNM->getInfo($hotel, 'SEASON', 'id_season', $seasonId, null, null, null, 1);
			$rate   = $this->GNM->getInfo($hotel, 'RATE',   'id_rate',   $rateId,   null, null, null, 1);
			$plans  = $this->GNM->getInfo($hotel, 'PLAN',    null,        null,     null, null, null, 1);
			
			$data['season'] = $season;
			$data['rate']  = $rate;
			$data['plans']  = $plans;
			
			$this->load->view('pms/prices/prices_select_plan_view', $data);
		
		} else {
			
			$data['error'] = NULL;
			$this->load->view('pms/users/user_sign_in', $data);
		}
	}
	
	
	function checkPrices()
	{
		$userId = $this->session->userdata('userid');
		
		if ($userId) {
		
			$seasonId = $this->uri->segment(3);
			$rateId   = $this->uri->segment(4);
			$planId   = $this->uri->segment(5);
			
			$hotel = $this->session->userdata('hotelid');
				
			$season    = $this->GNM->getInfo($hotel, 'SEASON',   'id_season', $seasonId, null, null, null, 1);
			$rate      = $this->GNM->getInfo($hotel, 'RATE',     'id_rate',   $rateId,   null, null, null, 1);
			$plan      = $this->GNM->getInfo($hotel, 'PLAN',     'id_plan',   $planId,   null, null, null, 1);
			$roomTypes = $this->GNM->getInfo($hotel, 'ROOM_TYPE', null,       null,      null, null, null, 1);
			$prices    = $this->PRM->getPriceInfo($seasonId, $rateId, $planId, null, null);
			
			if ($prices) {
			
				foreach ($prices as $row) {
					if ($row['hasWeekdays'] == 'Yes') {
						$type = 'hasWeekdays';
					} else {
						$type = 'noWeekdays';
					}
				}
			
				$data['type']      = $type;
				$data['season']    = $season;
				$data['rate']      = $rate;
				$data['plan']      = $plan;
				$data['roomTypes'] = $roomTypes;
				$data['prices']    = $prices;
			
				$this->load->view('pms/prices/prices_view', $data);
				
			} else {
				
				$data['type']      = 'noWeekdays';
				$data['error']     = 1;
				$data['season']    = $season;
				$data['rate']      = $rate;
				$data['plan']      = $plan;
				$data['roomTypes'] = $roomTypes;
			
				$this->load->view('pms/prices/prices_add_view', $data);
			}
			
		} else {
			
			$data['error'] = NULL;
			$this->load->view('pms/users/user_sign_in', $data);
		}
	}
	
	
	
	function addPricesPerNight()
	{
		$userId = $this->session->userdata('userid');
		
		if ($userId) {
		
			$seasonId = $this->uri->segment(3);
			$rateId   = $this->uri->segment(4);
			$planId   = $this->uri->segment(5);
			
			$hotel = $this->session->userdata('hotelid');
			
			$season    = $this->GNM->getInfo($hotel, 'SEASON',   'id_season', $seasonId, null, null, null, 1);
			$rate      = $this->GNM->getInfo($hotel, 'RATE',     'id_rate',   $rateId,   null, null, null, 1);
			$plan      = $this->GNM->getInfo($hotel, 'PLAN',     'id_plan',   $planId,   null, null, null, 1);
			$roomTypes = $this->GNM->getInfo($hotel, 'ROOM_TYPE', null,       null,      null, null, null, 1);
			
			$complete = 'Yes';
			
			foreach ($roomTypes as $row) {
			
				$id = $row['id_room_type'];
				
				$valP = 'pricepn'.$id;
				$pricePerNight = $_POST[$valP];		
	
				if ($pricePerNight == NULL) {
					$complete = 'No';
				} 
			}
			
			if ($complete == 'No') {
	
				$type  = 'noWeekdays';
				$error = lang("errorPrices");
					
				$data['type']      = $type;
				$data['error']     = $error;
				$data['season']    = $season;
				$data['rate']      = $rate;
				$data['plan']      = $plan;
				$data['roomTypes'] = $roomTypes;
				
				$this->load->view('pms/prices/prices_add_view', $data);
					
			} else {
			
				foreach ($roomTypes as $row) {
			
					$id = $row['id_room_type'];
					
					$valP = 'pricepn'.$id;
					$pricePerNight = $_POST[$valP];
							
					$data = array(
						'pricePerNight' => $pricePerNight,
						'hasWeekdays'   => 'No',
						'monPrice'  => NULL,
						'tuePrice'  => NULL,
						'wedPrice'  => NULL,
						'thuPrice'  => NULL,
						'friPrice'  => NULL,
						'satPrice'  => NULL,
						'sunPrice'  => NULL,
						'persType'  => 'Adults',
						'fk_season' => $seasonId,
						'fk_rate'   => $rateId,
						'fk_plan'   => $planId,
						'fk_room_type' => $id
						);
				
					$this->GNM->insert('PRICE', $data);  
				}
				
				if ($_POST['pricepn_children'] == NULL) {
					$pricePerNightChildren = NULL;
				} else {
					$pricePerNightChildren = $_POST['pricepn_children'];
				}
				
				if ($_POST['pricepn_seniors'] == NULL) {
					$pricePerNightSeniors = NULL;
				} else {
					$pricePerNightSeniors = $_POST['pricepn_seniors'];
				}
				
					$data = array(
						'pricePerNight' => $pricePerNightChildren,
						'hasWeekdays'   => 'No',
						'monPrice'  => NULL,
						'tuePrice'  => NULL,
						'wedPrice'  => NULL,
						'thuPrice'  => NULL,
						'friPrice'  => NULL,
						'satPrice'  => NULL,
						'sunPrice'  => NULL,
						'persType'  => 'Children',
						'fk_season' => $seasonId,
						'fk_rate'   => $rateId,
						'fk_plan'   => $planId,
						'fk_room_type' => NULL
						);
				
					$this->GNM->insert('PRICE', $data);  
					
					$data = array(
						'pricePerNight' => $pricePerNightSeniors,
						'hasWeekdays'   => 'No',
						'monPrice'  => NULL,
						'tuePrice'  => NULL,
						'wedPrice'  => NULL,
						'thuPrice'  => NULL,
						'friPrice'  => NULL,
						'satPrice'  => NULL,
						'sunPrice'  => NULL,
						'persType'  => 'Seniors',
						'fk_season' => $seasonId,
						'fk_rate'   => $rateId,
						'fk_plan'   => $planId,
						'fk_room_type' => NULL
						);
				
					$this->GNM->insert('PRICE', $data);
			
				$this->checkPrices($seasonId, $rateId, $planId);
			}
		
		} else {
			
			$data['error'] = NULL;
			$this->load->view('pms/users/user_sign_in', $data);
		}
	}
	
	
	function addPricesEachDay()
	{
		$userId = $this->session->userdata('userid');
		
		if ($userId) {
		
			$seasonId = $this->uri->segment(3);
			$rateId   = $this->uri->segment(4);
			$planId   = $this->uri->segment(5);
			
			$hotel = $this->session->userdata('hotelid');
			
			$season    = $this->GNM->getInfo($hotel, 'SEASON',   'id_season', $seasonId, null, null, null, 1);
			$rate      = $this->GNM->getInfo($hotel, 'RATE',     'id_rate',   $rateId,   null, null, null, 1);
			$plan      = $this->GNM->getInfo($hotel, 'PLAN',     'id_plan',   $planId,   null, null, null, 1);
			$roomTypes = $this->GNM->getInfo($hotel, 'ROOM_TYPE', null,       null,      null, null, null, 1);
			
			$complete = 'Yes';
			
			foreach ($roomTypes as $row) {
			
				$id = $row['id_room_type'];
				
				$valM = 'mon_price'.$id;
				$varM = $_POST[$valM];
			
				$valT = 'tue_price'.$id;
				$varT = $_POST[$valT];
				
				$valW = 'wed_price'.$id;
				$varW = $_POST[$valT];
				
				$valH = 'thu_price'.$id;
				$varH = $_POST[$valH];
				
				$valF = 'fri_price'.$id;
				$varF = $_POST[$valF];
				
				$valS = 'sat_price'.$id;
				$varS = $_POST[$valS];
				
				$valU = 'sun_price'.$id;
				$varU = $_POST[$valU];
	
				if (($varM == NULL) || ($varT == NULL) || ($varW == NULL) || ($varH == NULL) || 
					($varF == NULL) || ($varS == NULL) || ($varU == NULL) ) {
				
					$complete = 'No';
				} 
			}
			
			if ($complete == 'No') {
			
				$type  = 'hasWeekdays';
				$error = lang("errorPrices");
					
				$data['type']      = $type;
				$data['error']     = $error;
				$data['season']    = $season;
				$data['rate']      = $rate;
				$data['plan']      = $plan;
				$data['roomTypes'] = $roomTypes;
				
				$this->load->view('pms/prices/prices_add_view', $data);
		
			} else {
				
				foreach ($roomTypes as $row) {
			
					$id = $row['id_room_type'];
						
					$valM = 'mon_price'.$id;
					$varM = $_POST[$valM];
					
					$valT = 'tue_price'.$id;
					$varT = $_POST[$valT];
						
					$valW = 'wed_price'.$id;
					$varW = $_POST[$valT];
						
					$valH = 'thu_price'.$id;
					$varH = $_POST[$valH];
						
					$valF = 'fri_price'.$id;
					$varF = $_POST[$valF];
						
					$valS = 'sat_price'.$id;
					$varS = $_POST[$valS];
						
					$valU = 'sun_price'.$id;
					$varU = $_POST[$valU];
				
					$data = array(
						'pricePerNight' => NULL,
						'hasWeekdays'   => 'Yes',
						'monPrice'  => $varM,
						'tuePrice'  => $varT,
						'wedPrice'  => $varW,
						'thuPrice'  => $varH,
						'friPrice'  => $varF,
						'satPrice'  => $varS,
						'sunPrice'  => $varU,
						'persType'  => 'Adults',
						'fk_season' => $seasonId,
						'fk_rate'   => $rateId,
						'fk_plan'   => $planId,
						'fk_room_type' => $id
					);
				
					$this->GNM->insert('PRICE', $data);  
				}
				
				if ($_POST['mon_price_children'] == NULL) {
					$childrenMon = NULL;
				} else {
					$childrenMon = $_POST['mon_price_children'];
				}
				
				if ($_POST['tue_price_children'] == NULL) {
					$childrenTue = NULL;
				} else {
					$childrenTue = $_POST['tue_price_children'];
				}
				
				if ($_POST['wed_price_children'] == NULL) {
					$childrenWed = NULL;
				} else {
					$childrenWed = $_POST['wed_price_children'];
				}
				
				if ($_POST['thu_price_children'] == NULL) {
					$childrenThu = NULL;
				} else {
					$childrenThu = $_POST['thu_price_children'];
				}
				
				if ($_POST['fri_price_children'] == NULL) {
					$childrenFri = NULL;
				} else {
					$childrenFri = $_POST['fri_price_children'];
				}
				
				if ($_POST['sat_price_children'] == NULL) {
					$childrenSat = NULL;
				} else {
					$childrenSat = $_POST['sat_price_children'];
				}
				
				if ($_POST['sun_price_children'] == NULL) {
					$childrenSun = NULL;
				} else {
					$childrenSun = $_POST['sun_price_children'];
				}
				
				$data = array(
						'pricePerNight' => NULL,
						'hasWeekdays'   => 'Yes',
						'monPrice'  => $childrenMon,
						'tuePrice'  => $childrenTue,
						'wedPrice'  => $childrenWed,
						'thuPrice'  => $childrenThu,
						'friPrice'  => $childrenFri,
						'satPrice'  => $childrenSat,
						'sunPrice'  => $childrenSun,
						'persType'  => 'Children',
						'fk_season' => $seasonId,
						'fk_rate'   => $rateId,
						'fk_plan'   => $planId,
						'fk_room_type' => NULL
					);
				
				$this->GNM->insert('PRICE', $data);  
				
				
				if ($_POST['mon_price_seniors'] == NULL) {
					$seniorsMon = NULL;
				} else {
					$seniorsMon = $_POST['mon_price_seniors'];
				}
				
				if ($_POST['tue_price_seniors'] == NULL) {
					$seniorsTue = NULL;
				} else {
					$seniorsTue = $_POST['tue_price_seniors'];
				}
				
				if ($_POST['wed_price_seniors'] == NULL) {
					$seniorsWed = NULL;
				} else {
					$seniorsWed = $_POST['wed_price_seniors'];
				}
				
				if ($_POST['thu_price_seniors'] == NULL) {
					$seniorsThu = NULL;
				} else {
					$seniorsThu = $_POST['thu_price_seniors'];
				}
				
				if ($_POST['fri_price_seniors'] == NULL) {
					$seniorsFri = NULL;
				} else {
					$seniorsFri = $_POST['fri_price_seniors'];
				}
				
				if ($_POST['sat_price_seniors'] == NULL) {
					$seniorsSat = NULL;
				} else {
					$seniorsSat = $_POST['sat_price_seniors'];
				}
				
				if ($_POST['sun_price_seniors'] == NULL) {
					$seniorsSun = NULL;
				} else {
					$seniorsSun = $_POST['sun_price_seniors'];
				}
				
				$data = array(
						'pricePerNight' => NULL,
						'hasWeekdays'   => 'Yes',
						'monPrice'  => $seniorsMon,
						'tuePrice'  => $seniorsTue,
						'wedPrice'  => $seniorsWed,
						'thuPrice'  => $seniorsThu,
						'friPrice'  => $seniorsFri,
						'satPrice'  => $seniorsSat,
						'sunPrice'  => $seniorsSun,
						'persType'  => 'Seniors',
						'fk_season' => $seasonId,
						'fk_rate'   => $rateId,
						'fk_plan'   => $planId,
						'fk_room_type' => NULL
					);
				
				$this->GNM->insert('PRICE', $data);
				
				$this->checkPrices($seasonId, $rateId, $planId);
			}
			
		} else {
		
			$data['error'] = NULL;
			$this->load->view('pms/users/user_sign_in', $data);
		}
	}
	
	
	
	function editPrices()
	{
		$userId = $this->session->userdata('userid');
		
		if ($userId) {
		
			$seasonId = $this->uri->segment(3);
			$rateId   = $this->uri->segment(4);
			$planId   = $this->uri->segment(5);
			
			$hotel = $this->session->userdata('hotelid');
				
			$season    = $this->GNM->getInfo($hotel, 'SEASON',   'id_season', $seasonId, null, null, null, 1);
			$rate      = $this->GNM->getInfo($hotel, 'RATE',     'id_rate',   $rateId,   null, null, null, 1);
			$plan      = $this->GNM->getInfo($hotel, 'PLAN',     'id_plan',   $planId,   null, null, null, 1);
			$roomTypes = $this->GNM->getInfo($hotel, 'ROOM_TYPE', null,       null,      null, null, null, 1);
			$prices    = $this->PRM->getPriceInfo($seasonId, $rateId, $planId, null, null);
			
			foreach ($prices as $row) {
				if ($row['hasWeekdays'] == 'Yes') {
					$type = 'hasWeekdays';
				} else {
					$type = 'noWeekdays';
				}
			}
			
			$data['type']      = $type;
			$data['season']    = $season;
			$data['rate']      = $rate;
			$data['plan']      = $plan;
			$data['roomTypes'] = $roomTypes;
			$data['prices']    = $prices;
			
			$this->load->view('pms/prices/prices_edit_view', $data);
			
		} else {
			
			$data['error'] = NULL;
			$this->load->view('pms/users/user_sign_in', $data);
		}
	}
	
	
	
	function editPricesPerNight()
	{
		$userId = $this->session->userdata('userid');
		
		if ($userId) {
		
			$seasonId = $this->uri->segment(3);
			$rateId   = $this->uri->segment(4);
			$planId   = $this->uri->segment(5);
			
			$hotel = $this->session->userdata('hotelid');
			
			$season    = $this->GNM->getInfo($hotel, 'SEASON',   'id_season', $seasonId, null, null, null, 1);
			$rate      = $this->GNM->getInfo($hotel, 'RATE',     'id_rate',   $rateId,   null, null, null, 1);
			$plan      = $this->GNM->getInfo($hotel, 'PLAN',     'id_plan',   $planId,   null, null, null, 1);
			$roomTypes = $this->GNM->getInfo($hotel, 'ROOM_TYPE', null,       null,      null, null, null, 1);
			$prices    = $this->PRM->getPriceInfo($seasonId, $rateId, $planId, null, null);
			
			$complete = 'Yes';
			
			foreach ($roomTypes as $row) {
			
				$id = $row['id_room_type'];
				
				$valP = 'pricepn'.$id;
				$pricePerNight = $_POST[$valP];		
	
				if ($pricePerNight == NULL) {
					$complete = 'No';
				} 
			}
			
			if ($complete == 'No') {
	
				$type  = 'noWeekdays';
				$error = lang("errorPrices");
					
				$data['type']      = $type;
				$data['error']     = $error;
				$data['season']    = $season;
				$data['rate']      = $rate;
				$data['plan']      = $plan;
				$data['roomTypes'] = $roomTypes;
				$data['prices']    = $prices;
				
				$this->load->view('pms/prices/prices_edit_view', $data);
					
			} else {
			
				foreach ($roomTypes as $row) {
			
					$id = $row['id_room_type'];
					
					$valP = 'pricepn'.$id;
					$pricePerNight = $_POST[$valP];
							
					$data = array(
						'pricePerNight' => $pricePerNight,
						'hasWeekdays'   => 'No',
						'monPrice'  => NULL,
						'tuePrice'  => NULL,
						'wedPrice'  => NULL,
						'thuPrice'  => NULL,
						'friPrice'  => NULL,
						'satPrice'  => NULL,
						'sunPrice'  => NULL,
						'persType'  => 'Adults',
						'fk_season' => $seasonId,
						'fk_rate'   => $rateId,
						'fk_plan'   => $planId,
						'fk_room_type' => $id
						);
				
					$this->PRM->updatePrice($seasonId, $rateId, $planId, $id, 'Adults', $data);  
				}
				
				if ($_POST['pricepn_children'] == NULL) {
					$pricePerNightChildren = NULL;
				} else {
					$pricePerNightChildren = $_POST['pricepn_children'];
				}
				
				if ($_POST['pricepn_seniors'] == NULL) {
					$pricePerNightSeniors = NULL;
				} else {
					$pricePerNightSeniors = $_POST['pricepn_seniors'];
				}
				
				if ($pricePerNightChildren != NULL) {
				
					$data = array(
						'pricePerNight' => $pricePerNightChildren,
						'hasWeekdays'   => 'No',
						'monPrice'  => NULL,
						'tuePrice'  => NULL,
						'wedPrice'  => NULL,
						'thuPrice'  => NULL,
						'friPrice'  => NULL,
						'satPrice'  => NULL,
						'sunPrice'  => NULL,
						'persType'  => 'Children',
						'fk_season' => $seasonId,
						'fk_rate'   => $rateId,
						'fk_plan'   => $planId,
						'fk_room_type' => NULL
						);
				
					$exPrice = $this->PRM->getPriceInfo($seasonId, $rateId, $planId, null, 'Children');
					
					if ($exPrice) {
					
						$this->PRM->updatePrice($seasonId, $rateId, $planId, null, 'Children', $data); 
						
					} else {
					
						$this->GNM->insert('PRICE', $data);
					}
				}
				
				if ($pricePerNightSeniors != NULL) {
					
					$data = array(
						'pricePerNight' => $pricePerNightSeniors,
						'hasWeekdays'   => 'No',
						'monPrice'  => NULL,
						'tuePrice'  => NULL,
						'wedPrice'  => NULL,
						'thuPrice'  => NULL,
						'friPrice'  => NULL,
						'satPrice'  => NULL,
						'sunPrice'  => NULL,
						'persType'  => 'Seniors',
						'fk_season' => $seasonId,
						'fk_rate'   => $rateId,
						'fk_plan'   => $planId,
						'fk_room_type' => NULL
						);
				
					$exPrice = $this->PRM->getPriceInfo($seasonId, $rateId, $planId, null, 'Seniors');
					
					if ($exPrice) {
					
						$this->PRM->updatePrice($seasonId, $rateId, $planId, null, 'Seniors', $data); 
						
					} else {
					
						$this->GNM->insert('PRICE', $data);
					}
				}
			
				$this->checkPrices($seasonId, $rateId, $planId);
			}
			
		 } else {
		 
		 	$data['error'] = NULL;
			$this->load->view('pms/users/user_sign_in', $data);
		 }
	}
	
	
	
	function editPricesEachDay()
	{
		$userId = $this->session->userdata('userid');
		
		if ($userId) {
			
			$seasonId = $this->uri->segment(3);
			$rateId   = $this->uri->segment(4);
			$planId   = $this->uri->segment(5);
			
			$hotel = $this->session->userdata('hotelid');
			
			$season    = $this->GNM->getInfo($hotel, 'SEASON',   'id_season', $seasonId, null, null, null, 1);
			$rate      = $this->GNM->getInfo($hotel, 'RATE',     'id_rate',   $rateId,   null, null, null, 1);
			$plan      = $this->GNM->getInfo($hotel, 'PLAN',     'id_plan',   $planId,   null, null, null, 1);
			$roomTypes = $this->GNM->getInfo($hotel, 'ROOM_TYPE', null,       null,      null, null, null, 1);
			$prices    = $this->PRM->getPriceInfo($seasonId, $rateId, $planId, null, null);
			
			$complete = 'Yes';
			
			foreach ($roomTypes as $row) {
			
				$id = $row['id_room_type'];
				
				$valM = 'mon_price'.$id;
				$varM = $_POST[$valM];
			
				$valT = 'tue_price'.$id;
				$varT = $_POST[$valT];
				
				$valW = 'wed_price'.$id;
				$varW = $_POST[$valT];
				
				$valH = 'thu_price'.$id;
				$varH = $_POST[$valH];
				
				$valF = 'fri_price'.$id;
				$varF = $_POST[$valF];
				
				$valS = 'sat_price'.$id;
				$varS = $_POST[$valS];
				
				$valU = 'sun_price'.$id;
				$varU = $_POST[$valU];
	
				if (($varM == NULL) || ($varT == NULL) || ($varW == NULL) || ($varH == NULL) || 
					($varF == NULL) || ($varS == NULL) || ($varU == NULL) ) {
				
					$complete = 'No';
				} 
			}
			
			if ($complete == 'No') {
			
				$type  = 'hasWeekdays';
				$error = lang("errorPrices");
			
				$data['type']      = $type;
				$data['error']     = $error;
				$data['season']    = $season;
				$data['rate']      = $rate;
				$data['plan']      = $plan;
				$data['roomTypes'] = $roomTypes;
				$data['prices']    = $prices;
				
				$this->load->view('pms/prices/prices_edit_view', $data);
		
			} else {
				
				foreach ($roomTypes as $row) {
			
					$id = $row['id_room_type'];
						
					$valM = 'mon_price'.$id;
					$varM = $_POST[$valM];
					
					$valT = 'tue_price'.$id;
					$varT = $_POST[$valT];
						
					$valW = 'wed_price'.$id;
					$varW = $_POST[$valT];
						
					$valH = 'thu_price'.$id;
					$varH = $_POST[$valH];
						
					$valF = 'fri_price'.$id;
					$varF = $_POST[$valF];
						
					$valS = 'sat_price'.$id;
					$varS = $_POST[$valS];
						
					$valU = 'sun_price'.$id;
					$varU = $_POST[$valU];
				
					$data = array(
						'pricePerNight' => NULL,
						'hasWeekdays'   => 'Yes',
						'monPrice'  => $varM,
						'tuePrice'  => $varT,
						'wedPrice'  => $varW,
						'thuPrice'  => $varH,
						'friPrice'  => $varF,
						'satPrice'  => $varS,
						'sunPrice'  => $varU,
						'persType'  => 'Adults',
						'fk_season' => $seasonId,
						'fk_rate'   => $rateId,
						'fk_plan'   => $planId,
						'fk_room_type' => $id
					);
				
					$this->PRM->updatePrice($seasonId, $rateId, $planId, $id, 'Adults', $data);   
				}
				
				
				if ($_POST['mon_price_children'] == NULL) {
					$childrenMon = NULL;
				} else {
					$childrenMon = $_POST['mon_price_children'];
				}
				
				if ($_POST['tue_price_children'] == NULL) {
					$childrenTue = NULL;
				} else {
					$childrenTue = $_POST['tue_price_children'];
				}
				
				if ($_POST['wed_price_children'] == NULL) {
					$childrenWed = NULL;
				} else {
					$childrenWed = $_POST['wed_price_children'];
				}
				
				if ($_POST['thu_price_children'] == NULL) {
					$childrenThu = NULL;
				} else {
					$childrenThu = $_POST['thu_price_children'];
				}
				
				if ($_POST['fri_price_children'] == NULL) {
					$childrenFri = NULL;
				} else {
					$childrenFri = $_POST['fri_price_children'];
				}
				
				if ($_POST['sat_price_children'] == NULL) {
					$childrenSat = NULL;
				} else {
					$childrenSat = $_POST['sat_price_children'];
				}
				
				if ($_POST['sun_price_children'] == NULL) {
					$childrenSun = NULL;
				} else {
					$childrenSun = $_POST['sun_price_children'];
				}
				
				
				$data = array(
						'pricePerNight' => NULL,
						'hasWeekdays'   => 'Yes',
						'monPrice'  => $childrenMon,
						'tuePrice'  => $childrenTue,
						'wedPrice'  => $childrenWed,
						'thuPrice'  => $childrenThu,
						'friPrice'  => $childrenFri,
						'satPrice'  => $childrenSat,
						'sunPrice'  => $childrenSun,
						'persType'  => 'Children',
						'fk_season' => $seasonId,
						'fk_rate'   => $rateId,
						'fk_plan'   => $planId,
						'fk_room_type' => NULL
					);
				
				$exPrice = $this->PRM->getPriceInfo($seasonId, $rateId, $planId, null, 'Children');
					
				if ($exPrice) {
					
					$this->PRM->updatePrice($seasonId, $rateId, $planId, null, 'Children', $data); 
						
				} else {
					
					$this->GNM->insert('PRICE', $data);
				} 
				
				
				if ($_POST['mon_price_seniors'] == NULL) {
					$seniorsMon = NULL;
				} else {
					$seniorsMon = $_POST['mon_price_seniors'];
				}
				
				if ($_POST['tue_price_seniors'] == NULL) {
					$seniorsTue = NULL;
				} else {
					$seniorsTue = $_POST['tue_price_seniors'];
				}
				
				if ($_POST['wed_price_seniors'] == NULL) {
					$seniorsWed = NULL;
				} else {
					$seniorsWed = $_POST['wed_price_seniors'];
				}
				
				if ($_POST['thu_price_seniors'] == NULL) {
					$seniorsThu = NULL;
				} else {
					$seniorsThu = $_POST['thu_price_seniors'];
				}
				
				if ($_POST['fri_price_seniors'] == NULL) {
					$seniorsFri = NULL;
				} else {
					$seniorsFri = $_POST['fri_price_seniors'];
				}
				
				if ($_POST['sat_price_seniors'] == NULL) {
					$seniorsSat = NULL;
				} else {
					$seniorsSat = $_POST['sat_price_seniors'];
				}
				
				if ($_POST['sun_price_seniors'] == NULL) {
					$seniorsSun = NULL;
				} else {
					$seniorsSun = $_POST['sun_price_seniors'];
				}
				
				$data = array(
						'pricePerNight' => NULL,
						'hasWeekdays'   => 'Yes',
						'monPrice'  => $seniorsMon,
						'tuePrice'  => $seniorsTue,
						'wedPrice'  => $seniorsWed,
						'thuPrice'  => $seniorsThu,
						'friPrice'  => $seniorsFri,
						'satPrice'  => $seniorsSat,
						'sunPrice'  => $seniorsSun,
						'persType'  => 'Seniors',
						'fk_season' => $seasonId,
						'fk_rate'   => $rateId,
						'fk_plan'   => $planId,
						'fk_room_type' => NULL
					);
				
				$exPrice = $this->PRM->getPriceInfo($seasonId, $rateId, $planId, null, 'Seniors');
					
				if ($exPrice) {
					
					$this->PRM->updatePrice($seasonId, $rateId, $planId, null, 'Seniors', $data); 
						
				} else {
					
					$this->GNM->insert('PRICE', $data);
				}
				
				$this->checkPrices($seasonId, $rateId, $planId);
			}
			
		} else {
			
			$data['error'] = NULL;
			$this->load->view('pms/users/user_sign_in', $data);
		}
	}
	
	
	/*function viewPrices2()
	{
		$hotel = $this->session->userdata('hotelid');
			
		$roomTypes = $this->GNM->getInfo($hotel, 'ROOM_TYPE', null, null, null, null, null, 1);
		$seasons   = $this->GNM->getInfo($hotel, 'SEASON',    null, null, null, null, null, 1);
		$rates     = $this->GNM->getInfo($hotel, 'RATE',      null, null, null, null, null, 1);
		$plans     = $this->GNM->getInfo($hotel, 'PLAN',      null, null, null, null, null, 1);
		
		$data['roomTypes'] = $roomTypes;
		$data['seasons']  = $seasons;
		$data['rates']    = $rates;
		$data['plans']    = $plans;
		
		$this->load->view('pms/prices/prices_view', $data);
	}*/
}
?>