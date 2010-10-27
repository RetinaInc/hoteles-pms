<?php

class Seasons extends Controller
{
    function Seasons()
	{
        parent::Controller();
        $this->load->model('general_model','GNM');
		$this->load->model('seasons_model','SEM');
		$this->load->model('reservations_model','REM');
        $this->lang->load ('form_validation','spanish');
        $this->load->library('form_validation');
		$this->load->library('pagination');
		$this->load->library('session');
		$this->load->helper('hoteles');
		$this->load->helper('language');
		$this->load->helper('date');
        $this->load->helper('form');
		$this->load->helper('url');
	}
	
	
	function viewSeasons()
	{
		$userId = $this->session->userdata('userid');
		
		if ($userId) {
	
			$hotel = $this->session->userdata('hotelid');
		
			$order = $this->uri->segment(3);
			$lim2  = $this->uri->segment(4);
			
			if (($this->uri->segment(4) == FALSE) && ($this->uri->segment(3) == FALSE)) {
				
				$order = 'dateStart';
				$lim2  = NULL;
			}
			
			if (($this->uri->segment(4) == FALSE) && ($this->uri->segment(3) > 0)) {
				
				$order = 'dateStart';
				$lim2  = $this->uri->segment(3);
			}
			
			$totalRows = $this->GNM->getTotalRows($hotel, 'SEASON', null, null, 1);
			
			$config['base_url'] = base_url().'seasons/viewSeasons/'.$order;
			$config['total_rows'] = $totalRows;
			$config['per_page'] = '8';
			$config['num_links'] = '50';
			$config['uri_segment'] = 4;
			
			$this->pagination->initialize($config);
			
			$seasons    = $this->GNM->getInfo($hotel, 'SEASON', null, null, $order, $config['per_page'], $lim2, 1);
			$subSeasons = $this->GNM->getInfo($hotel, 'SEASON', null, null, 'dateStart', null, null, 1);
			$seasonsDis = $this->GNM->getInfo($hotel, 'SEASON', 'disable', '0', $order, null, null, null);
			
			$data['seasons']    = $seasons;
			$data['subSeasons'] = $subSeasons;
			$data['seasonsDis'] = $seasonsDis;
			
			$this->load->view('pms/seasons/seasons_view', $data);
			
		} else {
			
			$data['error'] = NULL;
			$this->load->view('pms/users/user_sign_in', $data);
		}
	}
	
	
	function viewDisabledSeasons()
	{
		$userId = $this->session->userdata('userid');
		
		if ($userId) {
		
			if (isset($_POST["order"])) {
				$order = $_POST["order"];
			}else {
				$order = 'dateStart';
			}
			
			$hotel = $this->session->userdata('hotelid');
		
			$lim2      = $this->uri->segment(3);
			$totalRows = $this->GNM->getTotalRows($hotel, 'SEASON', 'disable', '0', null);
			
			$config['base_url'] = base_url().'seasons/viewDisabledSeasons/';
			$config['total_rows'] = $totalRows;
			$config['per_page'] = '7';
			$config['num_links'] = '50';
		
			$this->pagination->initialize($config);
			
			$seasonsDis = $this->GNM->getInfo($hotel, 'SEASON', 'disable', '0', $order, $config['per_page'], $lim2, null);
			
			$data['seasonsDis']    = $seasonsDis;
			
			$this->load->view('pms/seasons/seasons_disabled_view', $data);
			
		} else {
		
			$data['error'] = NULL;
			$this->load->view('pms/users/user_sign_in', $data);
		}
	}
	
	
	function infoSeason($seasonId, $message)
	{
		$userId = $this->session->userdata('userid');
		
		if ($userId) {
			
			$hotel = $this->session->userdata('hotelid');
		
			$season  = $this->GNM->getInfo($hotel, 'SEASON', 'id_season', $seasonId, null, null, null, null);
			$fSeason = $this->GNM->getInfo($hotel, 'SEASON', 'fk_season', $seasonId, null, null, null, null);
			
			$data['season']  = $season;
			$data['fSeason'] = $fSeason;
			$data['message'] = $message;
			
			$this->load->view('pms/seasons/season_info_view', $data);
		
		} else {
			
			$data['error'] = NULL;
			$this->load->view('pms/users/user_sign_in', $data);
		}
	}
	
	
	function addSeason()
	{
		$hotel = $this->session->userdata('hotelid');
		 
        $this->form_validation->set_rules('season_name', 'lang:name', 'trim|xss_clean|required|max_length[300]|callback_checkSeasonName');
		$this->form_validation->set_rules('season_dateStart', 'lang:dateStart', 'trim|xss_clean|required|max_length[10]|callback_validDate');
		$this->form_validation->set_rules('season_dateEnd', 'lang:dateEnd', 'trim|xss_clean|required|max_length[10]|callback_validDate');
		
		if ($this->form_validation->run() == FALSE) {
		
			$userId = $this->session->userdata('userid');
		
			if ($userId) {
				
				$this->load->view('pms/seasons/season_add_view');
				
			} else {
				
				$data['error'] = NULL;
				$this->load->view('pms/users/user_sign_in', $data);
			}
			
		} else {
		
			$seasonName      = set_value('season_name');
			$seasonDateStart = set_value('season_dateStart');
			$seasonDateEnd   = set_value('season_dateEnd');
	
			$dS_array  = explode ('-',$seasonDateStart);
			$dayS      = $dS_array[0];
			$monthS    = $dS_array[1];
			$yearS     = $dS_array[2];
			$dateStart = $yearS.'-'.$monthS.'-'.$dayS;			
			$unixDateS = strtotime($dateStart);
			
			$dE_array  = explode ('-',$seasonDateEnd);
			$dayE      = $dE_array[0];
			$monthE    = $dE_array[1];
			$yearE     = $dE_array[2];
			$dateEnd   = $yearE.'-'.$monthE.'-'.$dayE;
			$unixDateE = strtotime($dateEnd);
			
			//checkSeason//
			$fkSeason = NULL;
			$info     = NULL;
			$add      = 'Yes';
			$nights   = ((strtotime($dateEnd) - strtotime($dateStart)) / (60 * 60 * 24)) + 1;
			
			if ($dateEnd < $dateStart) {
				
				$add   = 'No';
				$error = lang("errorSeasonDates");
			} 	
			
			$dSInSeason = $this->SEM->getInSeason($hotel, $dateStart, NULL, NULL, NULL);
			$dEInSeason = $this->SEM->getInSeason($hotel, $dateEnd, NULL, NULL, NULL);
			
			if (($dSInSeason) && ($dEInSeason)) {				
				
				foreach ($dSInSeason as $row) {
					
					$dSInSeasonId   = $row['id_season'];
					$dSInSeasonName = $row['name'];
				}
			
				foreach ($dEInSeason as $row) {
					
					$dEInSeasonId = $row['id_season'];
					$dEInSeasonName = $row['name'];
				}
				
				if ($dSInSeasonId != $dEInSeasonId) {

					$add   = 'No';
					$error = lang("errorNotInSameSeason");
					$info  = $dSInSeasonName."<br>".$dEInSeasonName;
				
				} else {
					
					$rows = count($dSInSeason);

					if ($rows >= 3) {
						
						$add   = 'No';
						$error = lang("errorToManySubseasons");	
					} 
					
					$date  = $dateStart;
					$match = 'No';
					
					for ($i=1; $i<=$nights; $i++) {
		
						$matchDays = $this->SEM->getInSeason($hotel, $date, NULL, NULL, 1);
						
						if ($matchDays) {
							
							$match = 'Yes';
						}
						
						$dateUnix = mktime(0,0,0,date($monthS),date($dayS)+$i,date($yearS));
						$date = date("Y-m-d", $dateUnix);
					}
				
					if ($match == 'Yes') {
						
						$add   = 'No';
						$error = lang("errorDaysInOtherSeason");
						
					} else {
						
						$fkSeason = $dSInSeasonId;
					}
				}
			
			} else if (!$dSInSeason && !$dEInSeason){

				$date     = $dateStart;
				$inSeason = 'No';
				
				for ($i=1; $i<=$nights; $i++) {

					$insideSeason = $this->SEM->getInSeason($hotel, $date, NULL, NULL, NULL);
					
					if ($insideSeason) {
						
						$inSeason = 'Yes';
					}
					
					$dateUnix = mktime(0,0,0,date($monthS),date($dayS)+$i,date($yearS));
					$date = date("Y-m-d", $dateUnix);
				}
			
				if ($inSeason == 'Yes') {
					
					$add   = 'No';
					$error = lang("errorDaysInOtherSeason");
				}
			
			} else {
				
				$add   = 'No';
				$error = lang("errorNotInSameSeason");
			}
			
			$checkSeason = $this->SEM->getCheckSeason($hotel, $dateStart, $dateEnd, NULL);
			
			if ($checkSeason) {
				
				$add   = 'No';
				$error = lang("errorRepeatedDates");
			}
			
			if ($add == 'Yes') {
	
				$data = array(
					'name'      => ucwords(strtolower($seasonName)),
					'dateStart' => $dateStart,
					'dateEnd'   => $dateEnd,
					'fk_season' => $fkSeason,
					'fk_hotel'  => $hotel
					);
				
				$this->GNM->insert('SEASON', $data);  
					
				$data['message'] = lang("addSeasonMessage");
				$data['type'] = 'seasons';
					
				$this->load->view('pms/success', $data); 
				
			} else {

				$data['error'] = $error;
				$data['info']  = $info;
				
				$this->load->view('pms/seasons/season_add_view', $data);
			}
		}	
	}
	
	
	function editSeason($seasonId)
	{
		$hotel = $this->session->userdata('hotelid');
		
		$this->form_validation->set_rules('season_name', 'lang:name', 'required|max_length[300]|callback_checkSeasonName');
		$this->form_validation->set_rules('season_dateStart', 'lang:dateStart', 'required|max_length[10]|callback_validDate');
		$this->form_validation->set_rules('season_dateEnd', 'lang:dateEnd', 'required|max_length[10]|callback_validDate');
		
		if ($this->form_validation->run() == FALSE) {
		
			$userId = $this->session->userdata('userid');
		
			if ($userId) {
		
				$season = $this->GNM->getInfo($hotel, 'SEASON', 'id_season', $seasonId, null, null, null, null);
				
				$data['season'] = $season;
				
				$this->load->view('pms/seasons/season_edit_view', $data);
			
			} else {
				
				$data['error'] = NULL;
				$this->load->view('pms/users/user_sign_in', $data);
			}
			
		} else {
		
			$seasonName      = set_value('season_name');
			$seasonDateStart = set_value('season_dateStart');
			$seasonDateEnd   = set_value('season_dateEnd');
			
			$dS_array   = explode ('-',$seasonDateStart);
			$dayS       = $dS_array[0];
			$monthS     = $dS_array[1];
			$yearS      = $dS_array[2];
			$dateStart  = $yearS.'-'.$monthS.'-'.$dayS;
			$unixDateS = strtotime($dateStart);
			
			$dE_array  = explode ('-',$seasonDateEnd);
			$dayE      = $dE_array[0];
			$monthE    = $dE_array[1];
			$yearE     = $dE_array[2];
			$dateEnd   = $yearE.'-'.$monthE.'-'.$dayE;
			$unixDateE = strtotime($dateEnd);
			
			//checkSeason//
			$fkSeason = NULL;
			$add      = 'Yes';
			$date     = $dateStart;
			$nights   = ((strtotime($dateEnd) - strtotime($dateStart)) / (60 * 60 * 24)) + 1;
			
			if ($dateEnd < $dateStart) {
				
				$add   = 'No';
				$error = lang("errorSeasonDates");
			} 
	
			$season = $this->GNM->getInfo($hotel, 'SEASON', 'id_season', $seasonId, null, null, null, null);
			
			foreach ($season as $row) {
				
				$fkSeason = $row['fk_season'];
			}
			
			$dSInSeason = $this->SEM->getInSeason($hotel, $dateStart, $seasonId, $fkSeason, NULL);
			$dEInSeason = $this->SEM->getInSeason($hotel, $dateEnd, $seasonId, $fkSeason, NULL);

			if (($dSInSeason) && ($dEInSeason)) {				
	
				foreach ($dSInSeason as $row) {
					
					$dSInSeasonId   = $row['id_season'];
					$dSInSeasonName = $row['name'];
				}
			
				foreach ($dEInSeason as $row) {
					
					$dEInSeasonId = $row['id_season'];
					$dEInSeasonName = $row['name'];
				}
				
				if ($dSInSeasonId != $dEInSeasonId) {

					$add   = 'No';
					$error = lang("errorNotInSameSeason");
					$info  = $dSInSeasonName."<br>".$dEInSeasonName;
				
				} else {
					
					$rows = count($dSInSeason);

					if ($rows >= 3) {
						
						$add   = 'No';
						$error = lang("errorToManySubseasons");	
						
					} 
					
					$date  = $dateStart;
					$match = 'No';
					
					for ($i=1; $i<=$nights; $i++) {
		
						$matchDays = $this->SEM->getInSeason($hotel, $date, NULL, NULL, 1);
						
						if ($matchDays) {
							
							$match = 'Yes';
						}
						
						$dateUnix = mktime(0,0,0,date($monthS),date($dayS)+$i,date($yearS));
						$date = date("Y-m-d", $dateUnix);
					}
				
					if ($match == 'Yes') {
						
						$add   = 'No';
						$error = lang("errorDaysInOtherSeason");
						
					} else {
						
						$fkSeason = $dSInSeasonId;
					}
				}
			
			} else if (!$dSInSeason && !$dEInSeason){

      			$date = $dateStart;
				$sum = 1;
				$inSeason = 'No';
				
				for ($i=1; $i<=$nights; $i++) {
	
					$insideSeason = $this->SEM->getInSeason($hotel, $date, $seasonId, $fkSeason, NULL);
					
					if ($insideSeason) {
						
						$inSeason = 'Yes';
					}
					 
					$dateUnix = mktime(0,0,0,date($monthS),date($dayS)+$i,date($yearS));
					$date = date("Y-m-d", $dateUnix);  
				}
			
				if ($inSeason == 'Yes') {
					
					$add   = 'No';
					$error = lang("errorDaysInOtherSeason");
				}
			
			} else {
				
				$add   = 'No';
				$error = lang("errorNotInSameSeason");
			}
			
			$checkSeason = $this->SEM->getCheckSeason($hotel, $dateStart, $dateEnd, $seasonId);
			
			if ($checkSeason) {
				
				$add   = 'No';
				$error = lang("errorRepeatedDates");
			}
	
			if ($add == 'Yes') {

				$data = array(
					'name'      => ucwords(strtolower($seasonName)),
					'dateStart' => $dateStart,
					'dateEnd'   => $dateEnd,
					'fk_season' => $fkSeason
					);
			
				$this->GNM->update('SEASON', 'id_season', $seasonId, $data); 
					
				$message = lang("editSeasonMessage");
			
				$this->infoSeason($seasonId, $message);
				
			} else {

				$season = $this->GNM->getInfo($hotel, 'SEASON', 'id_season', $seasonId, null, null, null, null);
				
				$data['season'] = $season;
				$data['error']  = $error;
				
				$this->load->view('pms/seasons/season_edit_view', $data);
			}
		}	
	}
	
	
	function disableSeason($seasonId)
	{
		$userId = $this->session->userdata('userid');
		
		if ($userId) {
		
			$hotel  = $this->session->userdata('hotelid');
			
			$season = $this->GNM->getInfo($hotel, 'SEASON', 'id_season', $seasonId, null, null, null, null);
			
			$datestring = "%Y-%m-%d  %h:%i %a";
			$time       = time();
			$date       = mdate($datestring, $time);
			
			$disable = 'Yes';
			
			foreach ($season as $row) {
			
				$dateStart  = $row['dateStart'];
				$dateEnd    = $row['dateEnd'];
			}
				
			if (($dateStart <= $date) && ($date <= $dateEnd)) {
					
				$disable = 'No';
				$error   = lang("errorCurrentSeason");
			}
			
			if (($dateStart >= $date) && ($dateEnd >= $date)) {
			
				$ds_array = explode ('-',$dateStart);
				$yearS    = $ds_array[0];
				$monthS   = $ds_array[1];
				$dayS     = $ds_array[2];
			
				$seaNights = ((strtotime($dateEnd) - strtotime($dateStart)) / (60 * 60 * 24)) + 1;
				
				$iniResNum = array();
				
				$penReservations = $this->REM->getReservationInfo($hotel, 'RE.status', 'Reserved', null, null, null, 1);
				
				foreach ($penReservations as $row) {
					
					$resNum       = $row['id_reservation'];
					$fullCheckIn  = $row['checkIn'];
					$fullCheckOut = $row['checkOut']; 
					
					$fci_array  = explode (' ',$fullCheckIn);
					$checkIn    = $fci_array[0];
					
					$ci_array  = explode ('-',$checkIn);
					$yearI     = $ci_array[0];
					$monthI    = $ci_array[1];
					$dayI      = $ci_array[2];
					
					$resNights = (strtotime($fullCheckOut) - strtotime($fullCheckIn)) / (60 * 60 * 24);
					
					$resDate = $checkIn;
					$seaDate = $dateStart;
					
					for ($i=1; $i<=$resNights; $i++) {	
						
						for ($j=1; $j<=$seaNights; $j++) {
							
							if ($resDate == $seaDate) {
					
								$disable = 'No';
								$error   = lang("errorPenResInSeason");
								
								$newResNum = array ($resNum);
								$result    = array_merge($iniResNum, $newResNum);
								$iniResNum = $result;
							}
							
							$seaDateUnix = mktime(0,0,0,date($monthS),date($dayS)+$j,date($yearS));
							$seaDate = date("Y-m-d", $seaDateUnix);
				
						}
						
						$resDateUnix = mktime(0,0,0,date($monthI),date($dayI)+$i,date($yearI));
						$resDate = date("Y-m-d", $resDateUnix);
					}
					
				}
			}
			
			if ($disable == 'No') {
			
				$result = array_unique ($result); 
				
				$data['error']  = $error;
				$data['result'] = $result;
				$data['type']   = 'error_season';
				
				$this->load->view('pms/error', $data);
				
			} else {
			
				$this->GNM->disable('SEASON', 'id_season', $seasonId); 
				$this->GNM->disable('SEASON', 'fk_season', $seasonId);   
				
				$data['message'] = lang("disableSeasonMessage");
				$data['type'] = 'seasons';
				
				$this->load->view('pms/success', $data);  
			}
			
		} else {
			
			$data['error'] = NULL;
			$this->load->view('pms/users/user_sign_in', $data);
		}	
	}
	
	
	function enableSeason($seasonId)
	{
		$userId = $this->session->userdata('userid');
		
		if ($userId) {
		
			$data = array(
					'disable' => 1
					);
				
			$this->GNM->update('SEASON', 'id_season', $seasonId, $data); 
			$this->GNM->update('SEASON', 'fk_season', $seasonId, $data);   
			
			$data['message'] = lang("enableSeasonMessage");
			$data['type'] = 'seasons';
				
			$this->load->view('pms/success', $data);
		
		} else {
			
			$data['error'] = NULL;
			$this->load->view('pms/users/user_sign_in', $data);
		}	
	}
	
	
	function validDate($str,$format= 'dd/mm/yyyy')
	{
		switch ($format) {
			
			
			case 'yyyy/mm/dd':
			
				if(preg_match("/^(19\d\d|2\d\d\d)[\/|-](0?[1-9]|1[012])[\/|-](0?[1-9]|[12][0-9]|3[01])$/", $str,$match) && checkdate($match[2],$match[3],$match[1])) {
					return FALSE;
				}
				
			break;
			
			case 'mm/dd/yyyy':
			
				if(preg_match("/^(0?[1-9]|1[012])[\/|-](0?[1-9]|[12][0-9]|3[01])[\/|-](19\d\d|2\d\d\d)$/", $str,$match) && checkdate($match[1],$match[2],$match[3])) {
				
					return FALSE;
				}
				
			break;
			
			default: // 'dd/mm/yyyy'
			
				if(preg_match("/^(0?[1-9]|[12][0-9]|3[01])[\/|-](0?[1-9]|1[012])[\/|-](19\d\d|2\d\d\d)$/", $str,$match) && checkdate($match[2],$match[1],$match[3])) {
				
					return TRUE;
				}
			
			break;
		}
		
		$this->form_validation->set_message('validDate', lang("errorValidDate"));
		return FALSE;
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