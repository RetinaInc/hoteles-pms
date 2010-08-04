<?php

class Seasons extends Controller
{
    function Seasons()
	{
        parent::Controller();
        $this->load->model('general_model','GM');
        $this->lang->load ('form_validation','spanish');
        $this->load->library('form_validation');
        $this->load->helper('form');
	}
	
	
	function viewSeasons()
	{
		//$order = $_POST["order"];
		
		$order = 'dateStart';
	
		$seasons = $this->GM->getInfo('SEASON', null, null, $order, null, null, null);
		
		$data['seasons'] = $seasons;
		
		$this->load->view('pms/seasons/seasons_view', $data);
	}
	
	
	function addSeason()
	{
		$this->form_validation->set_rules('season_name', 'lang:name', 'required|max_length[300]|callback_checkSeasonName');
		$this->form_validation->set_rules('season_dateStart', 'lang:dateStart', 'required|max_length[10]');
		$this->form_validation->set_rules('season_dateEnd', 'lang:dateEnd', 'required|max_length[10]');
		$this->form_validation->set_rules('season_season','lang:season','');
		
		if ($this->form_validation->run() == FALSE) {
		
			$seasons = $this->GM->getInfo('SEASON', $field = null, $value = null, $order = null, $lim1 = null, $lim2 = null, $disable = null);
		
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
				'fk_season' => $seasonSeason
				);
			
			$this->GM->insert('SEASON', $data);  
				
			$this->viewSeasons(); 
		}	
	}
	
	
	function editSeason($seasonId)
	{
		$this->form_validation->set_rules('season_name', 'lang:name', 'required|max_length[300]|callback_checkSeasonName');
		$this->form_validation->set_rules('season_dateStart', 'lang:dateStart', 'required|max_length[10]');
		$this->form_validation->set_rules('season_dateEnd', 'lang:dateEnd', 'required|max_length[10]');
		$this->form_validation->set_rules('season_season','lang:season','');
		
		if ($this->form_validation->run() == FALSE) {
		
			$season  = $this->GM->getInfo('SEASON', 'id_season', $seasonId, null, null, null, null);
			$seasons = $this->GM->getInfo('SEASON', null,        null,      null, null, null, null);
		
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
			
			$this->GM->update('SEASON', 'id_season', $seasonId, $data);  
				
			$this->viewSeasons(); 
		}	
	}
	
	
	function checkSeasonName($str)
	{
		$seasonId = $this->uri->segment(3);
		
		$seasons = $this->GM->validationCheck('SEASON', 'name', $str, 'id_season !=', $seasonId, null);

		if ($seasons) {
		
			$this->form_validation->set_message('checkSeasonName', 'Nombre de temporada no disponible');
			return FALSE;
			
		} else {
		
			return TRUE;
		}
	}
	
	
	
	
	
	

}
?>