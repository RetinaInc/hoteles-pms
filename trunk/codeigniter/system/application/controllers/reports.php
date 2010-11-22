<?php

class Reports extends Controller
{
    function Reports()
	{
        parent::Controller();
        $this->load->model('general_model','GNM');
		$this->load->model('rooms_model','ROM');
		$this->load->model('reservations_model','REM');
		$this->load->library('pagination');
		$this->load->library('session');
		$this->load->helper('hoteles');
		$this->load->helper('date');
        $this->load->helper('form');
		$this->load->helper('url');
	}
	
	
	function selectReport()
	{
		$userId = $this->session->userdata('userid');
		
		if ($userId) {
		
			$this->load->view('pms/reports/select_report_view');
			
		} else {
		
			$data['error'] = NULL;
			$this->load->view('pms/users/user_sign_in', $data);
		}
	}
	
	
	function monthlyReport()
	{	
		$userId = $this->session->userdata('userid');
		
		if ($userId) {
		
			$hotel = $this->session->userdata('hotelid');
			
			$datestring = "%Y-%m-%d";
			$time       = time();
			$currDate   = mdate($datestring, $time);
			
			$date_array = explode('-', $currDate);
			$currYear  = $date_array[0];
			$currMonth = $date_array[1];
			$currDay   = $date_array[2];
			
			if (isset($_POST["report_year"])) {
			
				$year  = $_POST["report_year"];
				$month = $_POST["report_month"];
				
				if ($year == NULL) {
			
					$year = $currYear;
				} 
				
			} else {
				
				$year  = $currYear;
				$month = $currMonth;
			}
			
			$styReservations    = $this->REM->getReservationsReport($hotel, 'RE.status !=',  'Canceled', 'RE.status !=',  'No Show', $month, $year);
			$canReservations    = $this->REM->getReservationsReport($hotel, 'RE.status',  'Canceled', NULL, NULL, $month, $year);
			$noShowReservations = $this->REM->getReservationsReport($hotel, 'RE.status',  'No Show', NULL, NULL, $month, $year);
			
			$resRR = $this->REM->getRoomResReport($hotel, 'RE.status !=',  'Canceled', 'RE.status !=',  'No Show', $field3, $value3, $month, $year);
			//$canRR = $this->REM->getRoomResReport($hotel, 'RE.status',  'Canceled', $field2, $value2, $field3, $value3, $month, $year);
			//$nShRR = $this->REM->getRoomResReport($hotel, 'RE.status',  'No Show', $field2, $value2, $field3, $value3, $month, $year);
			
			$data['styReservations']    = $styReservations;
			$data['canReservations']    = $canReservations;
			$data['noShowReservations'] = $noShowReservations;
			$data['resRR']              = $resRR;
			//$data['canRR']              = $canRR;
			//$data['nShRR']              = $nShRR;
			$data['year']               = $year;
			$data['month']              = $month;
	
			$this->load->view('pms/reports/report_monthly_view', $data);
			
		} else {
		
			$data['error'] = NULL;
			$this->load->view('pms/users/user_sign_in', $data);
		}
	}
	
	
	function monthlyRoomTypesReport()
	{
		$userId = $this->session->userdata('userid');
		
		if ($userId) {
		
			$hotel = $this->session->userdata('hotelid');
			
			$lim2      = $this->uri->segment(3);
			$totalRows = $this->GNM->getTotalRows($hotel, 'ROOM_TYPE', null, null, 1);
	
			$config['base_url']    = base_url().'reports/monthlyRoomTypesReport';
			$config['total_rows']  = $totalRows;
			$config['per_page']    = '12';
			$config['num_links']   = '50';
			$config['uri_segment'] = 3;
			
			$this->pagination->initialize($config); 
		
			$datestring = "%Y-%m-%d";
			$time       = time();
			$currDate   = mdate($datestring, $time);
			
			$date_array = explode('-', $currDate);
			$currYear  = $date_array[0];
			$currMonth = $date_array[1];
			$currDay   = $date_array[2];
			
			if (isset($_POST["report_year"])) {
			
				$year  = $_POST["report_year"];
				$month = $_POST["report_month"];
				
				if ($year == NULL) {
			
					$year = $currYear;
				} 
				
			} else {
				
				$year  = $currYear;
				$month = $currMonth;
			}
			
			$roomTypes = $this->GNM->getInfo($hotel, 'ROOM_TYPE', NULL, NULL, 'scale', $config['per_page'], $lim2, 1);
			
			$data['year']      = $year;
			$data['month']     = $month;
			$data['roomTypes'] = $roomTypes;			
	
			$this->load->view('pms/reports/report_monthly_room_types_view', $data);
			
		} else {
		
			$data['error'] = NULL;
			$this->load->view('pms/users/user_sign_in', $data);
		}
	}
	
	
	function monthlyRoomsReport()
	{
		$userId = $this->session->userdata('userid');
		
		if ($userId) {
		
			$hotel = $this->session->userdata('hotelid');
			
			$lim2      = $this->uri->segment(3);
			$totalRows = $this->ROM->getTotalRowsRooms($hotel, null, null, 1);
	
			$config['base_url']    = base_url().'reports/monthlyRoomsReport';
			$config['total_rows']  = $totalRows;
			$config['per_page']    = '10';
			$config['num_links']   = '50';
			$config['uri_segment'] = 3;
			
			$this->pagination->initialize($config); 
		
			$datestring = "%Y-%m-%d";
			$time       = time();
			$currDate   = mdate($datestring, $time);
			
			$date_array = explode('-', $currDate);
			$currYear  = $date_array[0];
			$currMonth = $date_array[1];
			$currDay   = $date_array[2];
			
			if (isset($_POST["report_year"])) {
			
				$year  = $_POST["report_year"];
				$month = $_POST["report_month"];
				
				if ($year == NULL) {
			
					$year = $currYear;
				} 
				
			} else {
				
				$year  = $currYear;
				$month = $currMonth;
			}
			
			$rooms = $this->ROM->getRoomInfo($hotel, NULL, NULL, 'number', $config['per_page'], $lim2, 1);
			
			$data['year']  = $year;
			$data['month'] = $month;
			$data['rooms'] = $rooms;			
	
			$this->load->view('pms/reports/report_monthly_rooms_view', $data);
			
		} else {
		
			$data['error'] = NULL;
			$this->load->view('pms/users/user_sign_in', $data);
		}
	}
	
	
	

	

	
	
	
	
	
	

}
?>