<?php

class Seasons extends Controller
{
    function Seasons()
	{
        parent::Controller();
        $this->load->model('general_model','GNM');
        $this->lang->load ('form_validation','spanish');
        $this->load->library('form_validation');
		$this->load->library('session');
		$this->load->helper('hoteles');
		$this->load->helper('language');
		$this->load->helper('date');
        $this->load->helper('form');
		$this->load->helper('url');
	}
	
	
	function viewSeasons()
	{
		//$order = $_POST["order"];
		
		$order = 'dateStart';
	    $hotel = $this->session->userdata('hotelid');
	
		$seasons    = $this->GNM->getInfo($hotel, 'SEASON', null, null, $order, null, null, 1);
		$seasonsDis = $this->GNM->getInfo($hotel, 'SEASON', 'disable', '0', $order, null, null, null);
		
		$data['seasons']    = $seasons;
		$data['seasonsDis'] = $seasonsDis;
		
		$this->load->view('pms/seasons/seasons_view', $data);
	}
	
	
	function viewDisabledSeasons()
	{
		//$order = $_POST["order"];
		
		$order = 'dateStart';
	    $hotel = $this->session->userdata('hotelid');
	
		$seasonsDis = $this->GNM->getInfo($hotel, 'SEASON', 'disable', '0', $order, null, null, null);
		
		$data['seasonsDis']    = $seasonsDis;
		
		$this->load->view('pms/seasons/seasons_disabled_view', $data);
	}
	
	
	function infoSeason($seasonId)
	{	
	    $hotel = $this->session->userdata('hotelid');
	
		$season  = $this->GNM->getInfo($hotel, 'SEASON', 'id_season', $seasonId, null, null, null, null);
		$fSeason = $this->GNM->getInfo($hotel, 'SEASON', 'fk_season', $seasonId, null, null, null, null);
		
		$data['season'] = $season;
		$data['fSeason'] = $fSeason;
		
		$this->load->view('pms/seasons/season_info_view', $data);
	}
	
	
	function addSeason()
	{
		$hotel = $this->session->userdata('hotelid');
		 
		$this->form_validation->set_rules('season_name', 'lang:name', 'required|max_length[300]|callback_checkSeasonName');
		$this->form_validation->set_rules('season_dateStart', 'lang:dateStart', 'required|max_length[10]');
		$this->form_validation->set_rules('season_dateEnd', 'lang:dateEnd', 'required|max_length[10]');
		$this->form_validation->set_rules('season_season','lang:season','');
		
		if ($this->form_validation->run() == FALSE) {
		
			$seasons = $this->GNM->getInfo($hotel, 'SEASON', null, null, null, null, null, null);
		
			$data['seasons'] = $seasons;
		
			$this->load->view('pms/seasons/season_add_view', $data);
			
		} else {
		
			$seasonName      = set_value('season_name');
			$seasonDateStart = set_value('season_dateStart');
			$seasonDateEnd   = set_value('season_dateEnd');
			$seasonSeason    = set_value('season_season');
			
			$dS_array   = explode ('-',$seasonDateStart);
			$day        = $dS_array[0];
			$month      = $dS_array[1];
			$year       = $dS_array[2];
			$dateStart  = $year.'-'.$month.'-'.$day;
		
			$dE_array = explode ('-',$seasonDateEnd);
			$day      = $dE_array[0];
			$month    = $dE_array[1];
			$year     = $dE_array[2];
			$dateEnd  = $year.'-'.$month.'-'.$day;
			
			if ($seasonSeason == "NULL") {
			
				$seasonSeason = NULL;
			}
			
			$data = array(
				'name'      => ucwords(strtolower($seasonName)),
				'dateStart' => $dateStart,
				'dateEnd'   => $dateEnd,
				'fk_season' => $seasonSeason,
				'fk_hotel'  => $hotel
				);
			
			$this->GNM->insert('SEASON', $data);  
				
			$this->viewSeasons(); 
		}	
	}
	
	
	function editSeason($seasonId)
	{
		$hotel = $this->session->userdata('hotelid');
		
		$this->form_validation->set_rules('season_name', 'lang:name', 'required|max_length[300]|callback_checkSeasonName');
		$this->form_validation->set_rules('season_dateStart', 'lang:dateStart', 'required|max_length[10]');
		$this->form_validation->set_rules('season_dateEnd', 'lang:dateEnd', 'required|max_length[10]');
		$this->form_validation->set_rules('season_season','lang:season','');
		
		if ($this->form_validation->run() == FALSE) {
		
			$season  = $this->GNM->getInfo($hotel, 'SEASON', 'id_season', $seasonId, null, null, null, null);
			$seasons = $this->GNM->getInfo($hotel, 'SEASON', null,        null,      null, null, null, null);
		
			$data['season'] = $season;
			$data['seasons'] = $seasons;
		
			$this->load->view('pms/seasons/season_edit_view', $data);
			
		} else {
		
			$seasonName      = set_value('season_name');
			$seasonDateStart = set_value('season_dateStart');
			$seasonDateEnd   = set_value('season_dateEnd');
			$seasonSeason    = set_value('season_season');
			
			$dS_array   = explode ('-',$seasonDateStart);
			$day        = $dS_array[0];
			$month      = $dS_array[1];
			$year       = $dS_array[2];
			$dateStart  = $year.'-'.$month.'-'.$day;
		
			$dE_array = explode ('-',$seasonDateEnd);
			$day      = $dE_array[0];
			$month    = $dE_array[1];
			$year     = $dE_array[2];
			$dateEnd  = $year.'-'.$month.'-'.$day;
			
			if ($seasonSeason == "NULL") {
			
				$seasonSeason = NULL;
			}
			
			$data = array(
				'name'      => ucwords(strtolower($seasonName)),
				'dateStart' => $dateStart,
				'dateEnd'   => $dateEnd,
				'fk_season' => $seasonSeason
				);
			
			$this->GNM->update('SEASON', 'id_season', $seasonId, $data);  
				
			$this->viewSeasons(); 
		}	
	}
	
	
	function disableSeason($seasonId)
	{
		$hotel  = $this->session->userdata('hotelid');
		
		$season = $this->GNM->getInfo($hotel, 'SEASON', 'id_season', $seasonId, null, null, null, null);
		
		$datestring = "%Y-%m-%d  %h:%i %a";
		$time       = time();
		$date       = mdate($datestring, $time);
		
		$delete    = 'Yes';
		
		foreach ($season as $row) {
		
			$dateStart  = $row['dateStart'];
			$dateEnd    = $row['dateEnd'];
			
			if (($dateStart < $date) && ($date < $dateEnd)) {
				
				$delete = 'No';
			}
		}
		
		if ($delete == 'No') {
		
			echo lang("errorCurrentSeason")."<br>";
		
			$this->infoSeason($seasonId);
			
		} else {
		
			$this->GNM->disable('SEASON', 'id_season', $seasonId); 
			$this->GNM->disable('SEASON', 'fk_season', $seasonId);   
			$this->viewSeasons(); 
		}	
	}
	
	
	function enableSeason($seasonId)
	{
		$data = array(
				'disable' => 1
				);
			
		$this->GNM->update('SEASON', 'id_season', $seasonId, $data); 
		$this->GNM->update('SEASON', 'fk_season', $seasonId, $data);   
		
		$this->viewSeasons(); 	
	}
	
	
	function checkSeasonName($str)
	{
		$seasonId = $this->uri->segment(3);
		$hotel = $this->session->userdata('hotelid');
		 
		$seasons = $this->GNM->validationCheck($hotel, 'SEASON', 'name', $str, 'id_season !=', $seasonId, null);

		if ($seasons) {
		
			$this->form_validation->set_message('checkSeasonName', 'Nombre de temporada no disponible');
			return FALSE;
			
		} else {
		
			return TRUE;
		}
	}
	
	
	
	
	
	

}
?>