<?php

class Reservations extends Controller
{
    function Reservations()
	{
        parent::Controller();
        $this->load->model('general_model','GM');
        $this->load->model('reservations_model','REM');
        $this->lang->load ('form_validation','spanish');
        $this->load->library('form_validation');
        $this->load->helper('hoteles');
        $this->load->helper('language');
        $this->load->helper('form');
        $this->load->helper('date');
        $this->load->helper('url');
	}
	
    function index()
	{
		echo 'reservations controller';
	}
	

    function viewAllReservations()
	{
		//$order = $_POST["order"];
		
		/*
		if ($order == NULL)
		{
			$order = 'CHECK_IN DESC';
		}
		*/
	
		$order = 'CHECK_IN DESC';
		
		$rooms        = $this->REM->getReservationRoom(null, null, null);
		$guests       = $this->GM->getInfo('GUEST',       null, null, null,   null, null, null);
		$reservations = $this->GM->getInfo('RESERVATION', null, null, $order, null, null, 1);
		
		$data['rooms']        = $rooms;
		$data['guests']       = $guests;
		$data['reservations'] = $reservations;
		
		$this->load->view('pms/reservations/reservations_all_view', $data);
	}
	
	
	function viewPendingReservations()
	{
		//$order = $_POST["order"];
		
		$order = 'ID_RESERVATION';
		
		$datestring = "%Y-%m-%d";
		$time       = time();
		$date       = mdate($datestring, $time);
		
		$rooms        = $this->REM->getReservationRoom(null, null, null);
		$guests       = $this->GM->getInfo('GUEST',      null,          null,  null,   null, null, null);
		$reservations = $this->GM->getInfo('RESERVATION','checkIn >=', $date, $order, null, null, 1);
		
		$data['rooms']        = $rooms;
		$data['guests']       = $guests;
		$data['reservations'] = $reservations;
		
		$this->load->view('pms/reservations/reservations_pending_view', $data);
		
	}
	
	
	function infoReservation($reservationId)
	{
		$room                  = $this->REM->getReservationRoom('ID_RESERVATION', $reservationId, null);
		$reservationRoomsCount = $this->GM->getCount('ROOM_RESERVATION', 'FK_ID_RESERVATION', $reservationId, null, null, null);
		$reservation           = $this->GM->getInfo('RESERVATION',      'ID_RESERVATION',    $reservationId, null, null, null, 1);
        $reservationRoomInfo   = $this->GM->getInfo('ROOM_RESERVATION', 'FK_ID_RESERVATION', $reservationId, null, null, null, 1);
		
		
		foreach ($reservation as $row) {
		
			$guestId  = $row['FK_ID_GUEST'];
			$checkIn  = $row['CHECK_IN'];
			$checkOut = $row['CHECK_OUT'];
			
			$checkIn_array = explode (' ',$checkIn);
			$ciDate = $checkIn_array[0];
	
			$checkOut_array = explode (' ',$checkOut);
			$coDate = $checkOut_array[0];
			
			$nights = (strtotime($coDate) - strtotime($ciDate)) / (60 * 60 * 24);
		}
		
		$guest = $this->GM->getInfo('GUEST', 'ID_GUEST', $guestId, null, null, null, null);
		
		$data['room']                  = $room;
		$data['reservationRoomsCount'] = $reservationRoomsCount;
		$data['reservation']           = $reservation;
		$data['reservationRoomInfo']   = $reservationRoomInfo;
		$data['nights']                = $nights;
		$data['guest']                 = $guest;
		
		$this->load->view('pms/reservations/reservation_info_view', $data);
	}
	
	
	function cancelReservation($reservationId, $guestId)
	{
		$data = array(
				'STATUS' => 'Canceled'
				);
				
		$this->GM->update('RESERVATION', 'ID_RESERVATION', $reservationId, $data);  
				
		$order = 'CHECK_IN DESC';
		
		$guest        = $this->GM->getInfo('GUEST',           'ID_GUEST',    $guestId, null,   null, null, 1);
		$reservations = $this->GM->getInfo('RESERVATION',     'FK_ID_GUEST', $guestId, $order, null, null, 1);
		
		$data['guest']        = $guest;
		$data['reservations'] = $reservations;
		
		$this->load->view('pms/guests/guest_reservations_info_view', $data);
	}
	
	
	function createReservation1()
	{
		$this->form_validation->set_rules('reservation_room_type','lang:room_type','required');
		$this->form_validation->set_rules('reservation_check_in','lang:check_in','required|max_length[15]');
		$this->form_validation->set_rules('reservation_check_out','lang:check_out','required|max_length[15]');
		
		if ($this->form_validation->run() == FALSE) {
		
			$rates     = $this->GM->getInfo('RATE',      null, null, null, null, null, 1);
			$roomTypes = $this->GM->getInfo('ROOM_TYPE', null, null, null, null, null, 1);
		
			$data['rates'] = $rates;
			$data['roomTypes'] = $roomTypes;
		
			$this->load->view('pms/reservations/reservation_create_1_view', $data);
		
		} else {
		
			$reservationRoomType = set_value('reservation_room_type');
			$reservationCheckIn  = set_value('reservation_check_in');
			$reservationCheckOut = set_value('reservation_check_out');
			
			$ci_array = explode ('-',$reservationCheckIn);
			$day      = $ci_array[0];
			$month    = $ci_array[1];
			$year     = $ci_array[2];
			$checkIn  = $year.'-'.$month.'-'.$day.' 12:00:00';
		
			$co_array = explode ('-',$reservationCheckOut);
			$day      = $co_array[0];
			$month    = $co_array[1];
			$year     = $co_array[2];
			$checkOut = $year.'-'.$month.'-'.$day.' 10:00:00';
		
			$available    = $this->REM->getAvailability($reservationRoomType, $checkIn, $checkOut);
			$roomTypeInfo = $this->GM->getInfo('ROOM_TYPE', 'ID_ROOM_TYPE', $reservationRoomType, null, null, null, 1);
			
			$data['available']           = $available; 
			$data['roomTypeInfo']        = $roomTypeInfo; 
			$data['reservationRoomType'] = $reservationRoomType; 
			$data['reservationCheckIn']  = $reservationCheckIn; 
			$data['reservationCheckOut'] = $reservationCheckOut; 
			
			$this->load->view('pms/reservations/reservation_create_2_view', $data);
		}
	}
	
	
	function createReservation2($roomId)
	{
		$roomType            = $_POST["room_type"];
		$reservationCheckIn  = $_POST["check_in"];
		$reservationCheckOut = $_POST["check_out"];
		
		$roomInfo     = $this->GM->getInfo('ROOM',      'ID_ROOM',      $roomId,   null, null, null, 1);
		$roomTypeInfo = $this->GM->getInfo('ROOM_TYPE', 'ID_ROOM_TYPE', $roomType, null, null, null, 1);
		
		$ci_array = explode ('-',$reservationCheckIn);
		$day      = $ci_array[0];
		$month    = $ci_array[1];
		$year     = $ci_array[2];
		$checkIn  = $year.'-'.$month.'-'.$day;
		
		$co_array = explode ('-',$reservationCheckOut);
		$day      = $co_array[0];
		$month    = $co_array[1];
		$year     = $co_array[2];
		$checkOut = $year.'-'.$month.'-'.$day;
		
		$nights = (strtotime($checkOut) - strtotime($checkIn)) / (60 * 60 * 24);
		
		$data['roomInfo']     = $roomInfo; 
		$data['roomTypeInfo'] = $roomTypeInfo; 
		$data['checkIn']      = $checkIn.' 12:00:00'; 
		$data['checkOut']     = $checkOut.' 10:00:00'; 
		$data['nights']       = $nights; 
			
		$this->load->view('pms/reservations/reservation_create_3_view', $data);
	}
	
	
	function createReservation3()
	{
		$roomId   = $_POST["room_number"];
		$roomType = $_POST["room_type"];
		$checkIn  = $_POST["check_in"];
		$checkOut = $_POST["check_out"];
		
		//$this->form_validation->set_rules('reservation_rate','lang:rate','required');
		$this->form_validation->set_rules('reservation_adults','lang:adults','required|integer|max_length[5]');
		$this->form_validation->set_rules('reservation_children','lang:children','required|integer|max_length[5]');
		$this->form_validation->set_rules('reservation_details','lang:details','max_length[300]');
		
		$this->form_validation->set_rules('guest_name','lang:name','required|max_length[30]');
		$this->form_validation->set_rules('guest_last_name','lang:last_name','required|max_length[30]');
		$this->form_validation->set_rules('guest_telephone','lang:telephone','required|max_length[20]');
		$this->form_validation->set_rules('guest_email','lang:email','valid_email|max_length[50]');
		$this->form_validation->set_rules('guest_address','lang:address','max_length[300]');
		
		if ($this->form_validation->run() == FALSE) {
		
			$roomInfo     = $this->GM->getInfo('ROOM',      'ID_ROOM',      $roomId,   null, null, null, 1);
			$roomTypeInfo = $this->GM->getInfo('ROOM_TYPE', 'ID_ROOM_TYPE', $roomType, null, null, null, 1);
			
			$checkIn_array  = explode (' ',$checkIn);
			$ciDate         = $checkIn_array[0];

			$checkOut_array = explode (' ',$checkOut);
			$coDate         = $checkOut_array[0];
			
			$nights = (strtotime($coDate) - strtotime($ciDate)) / (60 * 60 * 24);
		
			$data['roomInfo']     = $roomInfo; 
			$data['roomTypeInfo'] = $roomTypeInfo; 
			$data['checkIn']      = $checkIn; 
			$data['checkOut']     = $checkOut; 
			$data['nights']       = $nights; 
			
			$this->load->view('pms/reservations/reservation_create_3_view', $data);
		
		} else {
		
			//$reservation_rate = set_value('reservation_rate');
			$reservationAdults   = set_value('reservation_adults');
			$reservationChildren = set_value('reservation_children');
			$reservationDetails  = set_value('reservation_details');
			
		/*
			$data = array(
				'STATUS' => 
				'RES_DATE' => 
				'CHECK_IN' =>
				'CHECK_OUT' => 
				'PAYMENT_STAT' => 
				'DETAILS' => 
				'FK_ID_GUEST' => 
				);
			
			$this->GM->update('GUEST', 'ID_GUEST', $guest_id, $data);  
				
			$this->info_guest_reservations($guest_id); 
			*/
		}
	}
	
	
	function modifyReservationRooms($reservationId, $roomId)
	{
		$reservationRooms = $this->REM->getReservationRoom('ID_ROOM', $roomId, null);
		$roomTypes        = $this->GM->getInfo('ROOM_TYPE', null, null, null, null, null, 1);
		
		foreach ($reservationRooms as $row) {
		
			if ($row['ID_RESERVATION'] == $reservationId) {
			
				$roomType = $row['ID_ROOM_TYPE'];
				$checkIn  = $row['CHECK_IN'];
				$checkOut = $row['CHECK_OUT'];
				$totalPer = $row['ADULTS'] + $row['CHILDREN'];
			}
		}
		
		$availableType  = $this->REM->getAvailability ($roomType, $checkIn, $checkOut);
		$availableOther = $this->REM->getAvailability_other($checkIn, $checkOut, $totalPer);
		
		$data['availableType']    = $availableType;  	
		$data['availableOther']   = $availableOther;  
		$data['reservationId']    = $reservationId; 
		$data['roomTypes']        = $roomTypes; 
		$data['reservationRooms'] = $reservationRooms; 
		
		$this->load->view('pms/reservations/reservation_modify_rooms_view', $data);
	}
	
	
	function modifyReservationRooms2($reservationId, $oldRoomNum, $newRoomNum)
	{
		$data = array(
				'FK_ID_ROOM' => $newRoomNum
				);
				
		$this->REM->doubleUpdate('ROOM_RESERVATION', 'FK_ID_RESERVATION', $reservationId, 'FK_ID_ROOM', $oldRoomNum, $data); 
		
		echo 'Habitacion cambiada!'; 
		
		$this->infoReservation($reservationId);
	}
	
	
	function modifyReservationDates($reservationId)
	{
		$this->form_validation->set_rules('reservation_check_in','lang:check_in','required|max_length[15]');
		$this->form_validation->set_rules('reservation_check_out','lang:check_out','required|max_length[15]');
		
		if ($this->form_validation->run() == FALSE) {
		
			$reservationRooms = $this->REM->getReservationRoom('ID_RESERVATION', $reservationId, null);
			
			$data['reservationRooms'] = $reservationRooms; 
			
			$this->load->view('pms/reservations/reservation_modify_dates_view', $data);
		
		} else {
		
			$reservationCheckIn  = set_value('reservation_check_in');
			$reservationCheckOut = set_value('reservation_check_out');
			
			$ci_array = explode ('-',$reservationCheckIn);
			$day      = $ci_array[0];
			$month    = $ci_array[1];
			$year     = $ci_array[2];
			$checkIn  = $year.'-'.$month.'-'.$day.' 12:00:00';
		
			$co_array = explode ('-',$reservationCheckOut);
			$day      = $co_array[0];
			$month    = $co_array[1];
			$year     = $co_array[2];
			$checkOut = $year.'-'.$month.'-'.$day.' 10:00:00';
			
			$reservationRooms = $this->REM->getReservationRoom('ID_RESERVATION', $reservationId, null);
			$roomTypes        = $this->GM->getInfo('ROOM_TYPE', null, null, null, null, null, 1);
	
			foreach ($reservationRooms as $row) {
			
				$roomType = $row['ID_ROOM_TYPE'];
				$totalPer = $row['ADULTS'] + $row['CHILDREN'];
			}
		
			$availableType  = $this->REM->getAvailability ($roomType, $checkIn, $checkOut);
			$availableOther = $this->REM->getAvailabilityOther($checkIn, $checkOut, $totalPer);
		
			$data['availableType']       = $availableType;  	
			$data['availableOther']      = $availableOther; 
			$data['roomTypes']           = $roomTypes;  
			$data['reservationRooms']    = $reservationRooms; 
			$data['reservationCheckIn']  = $reservationCheckIn; 
			$data['reservationCheckOut'] = $reservationCheckOut; 
			
			$this->load->view('pms/reservations/reservation_modify_dates_2_view', $data);
		}
	}
	
	
	function modifyReservationDates2($reservationId, $newCheckIn, $newCheckOut)
	{
		echo 'post: ', $order = $_GET['res_ci'];
		
		
		/*
		$reservations = $this->GM->get_info('RESERVATION','ID_RESERVATION', $reservation_id, null, null, null, 1);
		foreach ($reservation as $row)
		{
			$room_type = $row['ID_ROOM_TYPE'];
		}
		
		$available = $this->REM->get_availability($room_type, $check_in, $check_out);
		
		$data['available'] = $available;  
		
		$data = array(
				'FK_ID_ROOM' => $new_room_num
				);
				
		$this->REM->double_update('ROOM_RESERVATION', 'FK_ID_RESERVATION', $reservation_id, 'FK_ID_ROOM', $old_room_num, $data); 
		
		echo 'Habitacion cambiada!'; 
		
		$this->info_reservation($reservation_id);
			*/
	}

	
	/*
	function modify_reservation_rooms_3($reservation_id, $old_room_num, $new_room_num)
	{
		$data = array(
				'FK_ID_ROOM' => $new_room_num
				);
				
		$this->REM->double_update('ROOM_RESERVATION', 'FK_ID_RESERVATION', $reservation_id, 'FK_ID_ROOM', $old_room_num, $data); 
		
		echo 'Habitacion cambiada!'; 
		
		$this->info_reservation($reservation_id);
		
	}
	
	*/
	
	
	
	






}
?>