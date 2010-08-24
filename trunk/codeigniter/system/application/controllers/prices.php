<?php

class Prices extends Controller
{
    function Prices()
	{
        parent::Controller();
        $this->load->model('general_model','GNM');
		$this->load->model('prices_model','PRM');
        //$this->load->model('reservations_model','REM');
        //$this->lang->load ('form_validation','spanish');
        //$this->load->library('form_validation');
		$this->load->library('session');
        $this->load->helper('hoteles');
        //$this->load->helper('language');
        $this->load->helper('form');
        //$this->load->helper('date');
        $this->load->helper('url');
	}
	
	function selectViewPrices()
	{	
		$this->load->view('pms/prices/prices_select_view');
	}
	
	
	function selectSeasonPrices()
	{
		$hotel = $this->session->userdata('hotelid');
			
		$seasons   = $this->GNM->getInfo($hotel, 'SEASON',    null, null, null, null, null, 1);
		
		$data['seasons']  = $seasons;
		
		$this->load->view('pms/prices/prices_select_season_view', $data);
	}
	
	
	function selectRatePrices($seasonId)
	{
		$hotel = $this->session->userdata('hotelid');
			
		$season = $this->GNM->getInfo($hotel, 'SEASON', 'id_season', $seasonId, null, null, null, 1);
		$rates  = $this->GNM->getInfo($hotel, 'RATE',      null, null, null, null, null, 1);
		
		$data['season'] = $season;
		$data['rates']  = $rates;
		
		$this->load->view('pms/prices/prices_select_rate_view', $data);
	}
	
	
	function selectPlanPrices()
	{
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
	}
	
	
	function checkPrices()
	{
		$seasonId = $this->uri->segment(3);
		$rateId   = $this->uri->segment(4);
		$planId   = $this->uri->segment(5);
		
		$hotel = $this->session->userdata('hotelid');
			
		$season    = $this->GNM->getInfo($hotel, 'SEASON',   'id_season', $seasonId, null, null, null, 1);
		$rate      = $this->GNM->getInfo($hotel, 'RATE',     'id_rate',   $rateId,   null, null, null, 1);
		$plan      = $this->GNM->getInfo($hotel, 'PLAN',     'id_plan',   $planId,   null, null, null, 1);
		$roomTypes = $this->GNM->getInfo($hotel, 'ROOM_TYPE', null,       null,      null, null, null, 1);
		$prices    = $this->PRM->getPriceInfo($seasonId, $rateId, $planId, null);
		
		if ($prices) {
		
			$data['season']    = $season;
			$data['rate']      = $rate;
			$data['plan']      = $plan;
			$data['roomTypes'] = $roomTypes;
			$data['prices']    = $prices;
		
			$this->load->view('pms/prices/prices_s_view', $data);
			
		} else {
		
			$data['season']    = $season;
			$data['rate']      = $rate;
			$data['plan']      = $plan;
			$data['roomTypes'] = $roomTypes;
		
			$this->load->view('pms/prices/prices_add_view', $data);
		
		}
	}
	
	
	function editPrices()
	{
		$seasonId = $this->uri->segment(3);
		$rateId   = $this->uri->segment(4);
		$planId   = $this->uri->segment(5);
		
		$hotel = $this->session->userdata('hotelid');
			
		$season    = $this->GNM->getInfo($hotel, 'SEASON',   'id_season', $seasonId, null, null, null, 1);
		$rate      = $this->GNM->getInfo($hotel, 'RATE',     'id_rate',   $rateId,   null, null, null, 1);
		$plan      = $this->GNM->getInfo($hotel, 'PLAN',     'id_plan',   $planId,   null, null, null, 1);
		$roomTypes = $this->GNM->getInfo($hotel, 'ROOM_TYPE', null,       null,      null, null, null, 1);
		$prices    = $this->PRM->getPriceInfo($seasonId, $rateId, $planId, null);
		
		$data['season']    = $season;
		$data['rate']      = $rate;
		$data['plan']      = $plan;
		$data['roomTypes'] = $roomTypes;
		$data['prices']    = $prices;
		
		$this->load->view('pms/prices/prices_edit_view', $data);
	}
	
	
	function addPrices()
	{
		$seasonId = $this->uri->segment(3);
		$rateId   = $this->uri->segment(4);
		$planId   = $this->uri->segment(5);
		
		$hotel = $this->session->userdata('hotelid');
			
		$season    = $this->GNM->getInfo($hotel, 'SEASON',   'id_season', $seasonId, null, null, null, 1);
		$rate      = $this->GNM->getInfo($hotel, 'RATE',     'id_rate',   $rateId,   null, null, null, 1);
		$plan      = $this->GNM->getInfo($hotel, 'PLAN',     'id_plan',   $planId,   null, null, null, 1);
		$roomTypes = $this->GNM->getInfo($hotel, 'ROOM_TYPE', null,       null,      null, null, null, 1);
		
		$data['season']    = $season;
		$data['rate']      = $rate;
		$data['plan']      = $plan;
		$data['roomTypes'] = $roomTypes;
		
		$this->load->view('pms/prices/prices_add_view', $data);
	}
	
	
	function addPrices2()
	{
		$seasonId = $this->uri->segment(3);
		$rateId   = $this->uri->segment(4);
		$planId   = $this->uri->segment(5);
		
		$hotel = $this->session->userdata('hotelid');
		
		$roomTypes = $this->GNM->getInfo($hotel, 'ROOM_TYPE', null, null, null, null, null, 1);
		
		$unPrice = $_POST["un_price"];
		
		foreach ($roomTypes as $row) {
		
			$id = $row['id_room_type'];
			
			$varM = 'monPrice'.$id;
			$valM = 'mon_price'.$id;
			if ($_POST[$valM] == NULL) {
				$varM = $unPrice;
			} else {
				$varM = $_POST[$valM];
			}
			
			
			$varT = 'tuePrice'.$id;
			$valT = 'tue_price'.$id;
			if ($_POST[$valT] == NULL) {
				$varT = $unPrice;
			} else {
				$varT = $_POST[$valT];
			}
			
			$varW = 'wedPrice'.$id;
			$valW = 'wed_price'.$id;
			if ($_POST[$valW] == NULL) {
				$varW = $unPrice;
			} else {
				$varW = $_POST[$valT];
			}
			
			$varH = 'thuPrice'.$id;
			$valH = 'thu_price'.$id;
			if ($_POST[$valH] == NULL) {
				$varH = $unPrice;
			} else {
				$varH = $_POST[$valH];
			}
			
			$varF = 'friPrice'.$id;
			$valF = 'fri_price'.$id;
			if ($_POST[$valF] == NULL) {
				$varF = $unPrice;
			} else {
				$varF = $_POST[$valF];
			}
			
			$varS = 'satPrice'.$id;
			$valS = 'sat_price'.$id;
			if ($_POST[$valS] == NULL) {
				$varS = $unPrice;
			} else {
				$varS = $_POST[$valS];
			}
			
			$varU = 'sunPrice'.$id;
			$valU = 'sun_price'.$id;
			if ($_POST[$valU] == NULL) {
				$varU = $unPrice;
			} else {
				$varU = $_POST[$valU];
			}
			
			$data = array(
				'pricePerNight' => $unPrice,
				'monPrice'  => $varM,
				'tuePrice'  => $varT,
				'wedPrice'  => $varW,
				'thuPrice'  => $varH,
				'friPrice'  => $varF,
				'satPrice'  => $varS,
				'sunPrice'  => $varU,
				'persType'  => 'Adulto',
				'fk_season' => $seasonId,
				'fk_rate'   => $rateId,
				'fk_plan'   => $planId,
				'fk_room_type' => $id
				);
			
			$this->GNM->insert('PRICE', $data);  
		}
		
		$this->selectViewPrices();
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