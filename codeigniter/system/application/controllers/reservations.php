<?php

class Reservations extends Controller
{
    function Reservations()
	{
        parent::Controller();
		$this->load->model('general_model','GNM');
		$this->load->model('reservations_model','REM');
		$this->load->model('rooms_model','ROM');
	    $this->load->model('guests_model','GSM');
		$this->load->model('prices_model','PRM');
		$this->load->model('seasons_model','SEM');
        $this->lang->load ('form_validation','spanish');
        $this->load->library('form_validation');
		$this->load->library('session');
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
	
	
	function viewPendingReservations()
	{
		$userId = $this->session->userdata('userid');
		
		if ($userId) {
		
			if (isset($_POST["order"])) {
				$order = $_POST["order"];
			}else {
				$order = 'checkIn';
			}
		
			$hotel = $this->session->userdata('hotelid');
			
			$datestring = "%Y-%m-%d";
			$time       = time();
			$date       = mdate($datestring, $time);
			
			$exRooms         = $this->ROM->getRoomInfo($hotel, null, null, null, null, null, 1);
			$exSeasons       = $this->GNM->getInfo($hotel, 'SEASON', null, null, null, null, null, 1);
			$exRates         = $this->GNM->getInfo($hotel, 'RATE',   null, null, null, null, null, 1);
			$exPlans         = $this->GNM->getInfo($hotel, 'PLAN',   null, null, null, null, null, 1);
			$rooms           = $this->ROM->getRoomReservationsGuest($hotel, null, null, null);
			$guests          = $this->GSM->getGuestInfo($hotel, null, null, null, null, null, null);
			$penReservations = $this->REM->getReservationInfo($hotel, 'checkIn >=', $date, $order, null, null, 1);
			$allReservations = $this->REM->getReservationInfo($hotel, 'checkIn <=', $date, $order, null, null, 1);
			
			$data['exRooms']         = $exRooms;
			$data['exSeasons']       = $exSeasons;
			$data['exRates']         = $exRates;
			$data['exPlans']         = $exPlans;
			$data['rooms']           = $rooms;
			$data['guests']          = $guests;
			$data['penReservations'] = $penReservations;
			$data['allReservations'] = $allReservations;
			
			$this->load->view('pms/reservations/reservations_pending_view', $data);
		
		} else {
			
			$data['error'] = NULL;
			$this->load->view('pms/users/user_sign_in', $data);
		}
	}
	

    function viewAllReservations()
	{
		$userId = $this->session->userdata('userid');
		
		if ($userId) {
		
			if (isset($_POST["order"])) {
				$order = $_POST["order"];
			}else {
				$order = 'checkIn';
			}
	
			$hotel = $this->session->userdata('hotelid');
			
			$datestring = "%Y-%m-%d";
			$time       = time();
			$date       = mdate($datestring, $time);
			
			$rooms        = $this->ROM->getRoomReservationsGuest($hotel, null, null, null);
			$guests       = $this->GSM->getGuestInfo($hotel, null, null, null, null, null, null);
			$reservations = $this->REM->getReservationInfo($hotel, 'checkIn <=', $date, $order, null, null, 1);
			
			$data['rooms']        = $rooms;
			$data['guests']       = $guests;
			$data['reservations'] = $reservations;
			
			$this->load->view('pms/reservations/reservations_all_view', $data);
			
		} else {
		
			$data['error'] = NULL;
			$this->load->view('pms/users/user_sign_in', $data);
		}
	}
	
	
	function viewCheckedIn()
	{
		$userId = $this->session->userdata('userid');
		
		if ($userId) {
		
			if (isset($_POST["order"])) {
				$order = $_POST["order"];
			}else {
				$order = 'checkIn';
			}
		
			$hotel = $this->session->userdata('hotelid');
			
			$guests = $this->GSM->getGuestInfo($hotel, null, null, null, null, null, null);
			$reservationCheckedIn = $this->REM->getReservationInfo($hotel, 'RE.status', 'Checked In', $order, null, null, 1);
			
			$data['guests'] = $guests;
			$data['reservationCheckedIn'] = $reservationCheckedIn;
			
			$this->load->view('pms/reservations/reservations_checked_in_view', $data);
		
		} else {
			
			$data['error'] = NULL;
			$this->load->view('pms/users/user_sign_in', $data);
		}
	}
	
	
	function viewCheckIns()
	{
		$userId = $this->session->userdata('userid');
		
		if ($userId) {

			if (isset($_POST["order"])) {
				$order = $_POST["order"];
			}else {
				$order = 'checkIn';
			}
			
			$hotel = $this->session->userdata('hotelid');
			
			$datestring = "%Y-%m-%d";
			$time       = time();
			$today      = mdate($datestring, $time);
			
			if (isset($_POST["check_in_date"])) {
			
				$ciDate = $_POST["check_in_date"];
				$ci_array = explode('-', $ciDate);
				$day   = $ci_array[0];
				$month = $ci_array[1];
				$year  = $ci_array[2];
				$checkInDate = $year.'-'.$month.'-'.$day;
				
			}else {
			
				$checkInDate = $today;
			}
			
			if ($checkInDate == NULL) {
				$checkInDate = $today;
			}
			
			$guests = $this->GSM->getGuestInfo($hotel, null, null, null, null, null, null);
			$dateCheckIns = $this->REM->getReservationInfo($hotel, 'checkIn', $checkInDate, $order, null, null, 1);
			
			$data['guests'] = $guests;
			$data['checkInDate']  = $checkInDate;
			$data['dateCheckIns'] = $dateCheckIns;
			
			$this->load->view('pms/reservations/reservations_check_ins_view', $data);
			
		} else {
			
			$data['error'] = NULL;
			$this->load->view('pms/users/user_sign_in', $data);
		}
	}
	
	
	function viewCheckOuts()
	{
		$userId = $this->session->userdata('userid');
		
		if ($userId) {
		
			if (isset($_POST["order"])) {
				$order = $_POST["order"];
			}else {
				$order = 'checkOut';
			}
		
			$hotel = $this->session->userdata('hotelid');
			
			$datestring = "%Y-%m-%d";
			$time       = time();
			$today      = mdate($datestring, $time);
			
			if (isset($_POST["check_out_date"])) {
			
				$coDate = $_POST["check_out_date"];
				$co_array = explode('-', $coDate);
				$day   = $co_array[0];
				$month = $co_array[1];
				$year  = $co_array[2];
				$checkOutDate = $year.'-'.$month.'-'.$day;
				
			} else {
			
				$checkInDate = $today;
			}
				
			if ($checkOutDate == NULL) {
				$checkOutDate = $today;
			}
				
			$guests = $this->GSM->getGuestInfo($hotel, null, null, null, null, null, null);
			$dateCheckOuts = $this->REM->getReservationInfo($hotel, 'checkOut', $checkOutDate, $order, null, null, 1);
			
			$data['guests'] = $guests;
			$data['checkOutDate'] = $checkOutDate;
			$data['dateCheckOuts'] = $dateCheckOuts;
			
			$this->load->view('pms/reservations/reservations_check_outs_view', $data);
			
		} else {
		
			$data['error'] = NULL;
			$this->load->view('pms/users/user_sign_in', $data);
		}
	}
	
	
	function checkOutReservation($reservationId)
	{
		$userId = $this->session->userdata('userid');
		
		if ($userId) {
		
			$hotel = $this->session->userdata('hotelid');
			
			$room                  = $this->ROM->getRoomReservationsGuest($hotel, 'id_reservation', $reservationId, null);
			$reservationRoomsCount = $this->ROM->getRRCount($hotel, 'fk_reservation', $reservationId, null, null);
			$reservationRoomInfo   = $this->ROM->getRRInfo($hotel, 'fk_reservation', $reservationId);
			$reservation = $this->REM->getReservationInfo($hotel, 'id_reservation', $reservationId, null, null, null, 1);
			$payments    = $this->REM->getPaymentInfo($hotel, null, null, $reservationId);
			
			foreach ($reservation as $row) {
			
				$guestId  = $row['fk_guest'];
				$checkIn  = $row['checkIn'];
				$checkOut = $row['checkOut'];
				
				$checkIn_array = explode (' ',$checkIn);
				$ciDate = $checkIn_array[0];
		
				$checkOut_array = explode (' ',$checkOut);
				$coDate = $checkOut_array[0];
				
				$nights = (strtotime($coDate) - strtotime($ciDate)) / (60 * 60 * 24);
			}
			
			$guest      = $this->GSM->getGuestInfo($hotel, 'id_guest', $guestId, null, null, null, null);
			$otherGuest = $this->GSM->getOtherGuestInfo($hotel, 'OG.fk_reservation', $reservationId, null, null, null);
			
			$data['room']   = $room;
			$data['guest']  = $guest;
			$data['nights'] = $nights;
			$data['otherGuest']  = $otherGuest;
			$data['payments']    = $payments;
			$data['reservation'] = $reservation;
			$data['reservationRoomsCount'] = $reservationRoomsCount;
			$data['reservationRoomInfo']   = $reservationRoomInfo;
			
			$this->load->view('pms/reservations/reservation_do_check_out_view', $data);
			
		} else {
		
			$data['error'] = NULL;
			$this->load->view('pms/users/user_sign_in', $data);
		}
	}
	
	
	function infoReservation($reservationId)
	{
		$userId = $this->session->userdata('userid');
		
		if ($userId) {
		
			$hotel = $this->session->userdata('hotelid');
			
			$room                  = $this->ROM->getRoomReservationsGuest($hotel, 'id_reservation', $reservationId, null);
			$reservationRoomCount  = $this->ROM->getRRCount($hotel, 'fk_reservation', $reservationId, null, null);
			$reservationRoomInfo   = $this->ROM->getRRInfo($hotel, 'fk_reservation', $reservationId);
			$reservation = $this->REM->getReservationInfo($hotel, 'id_reservation', $reservationId, null, null, null, 1);
			$payments    = $this->REM->getPaymentInfo($hotel, null, null, $reservationId);
			
			foreach ($reservation as $row) {
			
				$guestId  = $row['fk_guest'];
				$checkIn  = $row['checkIn'];
				$checkOut = $row['checkOut'];
				
				$checkIn_array = explode (' ',$checkIn);
				$ciDate = $checkIn_array[0];
		
				$checkOut_array = explode (' ',$checkOut);
				$coDate = $checkOut_array[0];
				
				$nights = (strtotime($coDate) - strtotime($ciDate)) / (60 * 60 * 24);
			}
			
			$guest      = $this->GSM->getGuestInfo($hotel, 'id_guest', $guestId, null, null, null, null);
			$otherGuest = $this->GSM->getOtherGuestInfo($hotel, 'OG.fk_reservation', $reservationId, null, null, null);
			
			$data['room']   = $room;
			$data['guest']  = $guest;
			$data['nights'] = $nights;
			$data['otherGuest']  = $otherGuest;
			$data['payments']    = $payments;
			$data['reservation'] = $reservation;
			$data['reservationRoomCount'] = $reservationRoomCount;
			$data['reservationRoomInfo']   = $reservationRoomInfo;
			
			$this->load->view('pms/reservations/reservation_info_view', $data);
			
		} else {
		
			$data['error'] = NULL;
			$this->load->view('pms/users/user_sign_in', $data);
		}
	}
	
	
	function cancelReservation($reservationId, $guestId)
	{
		$userId = $this->session->userdata('userid');
		
		if ($userId) {
		
			$hotel = $this->session->userdata('hotelid');
			
			$data = array(
					'status' => 'Canceled'
					);
					
			$this->GNM->update('RESERVATION', 'id_reservation', $reservationId, $data);  
					
			$order = 'checkIn DESC';
			
			$guest        = $this->GSM->getGuestInfo($hotel, 'id_guest', $guestId, null, null, null, 1);
			$reservations = $this->ROM->getRoomReservationsGuest($hotel, 'RE.fk_guest', $guestId, $order);
			
			$data['guest']        = $guest;
			$data['reservations'] = $reservations;
			
			$this->load->view('pms/guests/guest_reservations_info_view', $data);
		
		} else {
			
			$data['error'] = NULL;
			$this->load->view('pms/users/user_sign_in', $data);
		}
	}
	
	
	function createReservation1()
	{
		$userId = $this->session->userdata('userid');
		
		if ($userId) {
		
			$hotel = $this->session->userdata('hotelid');
			
			$this->form_validation->set_rules('reservation_rate','lang:rate','trim|xss_clean|required');
			$this->form_validation->set_rules('reservation_plan','lang:plan','trim|xss_clean|required');
			$this->form_validation->set_rules('reservation_check_in','lang:check_in','trim|xss_clean|required|max_length[15]');
			$this->form_validation->set_rules('reservation_check_out','lang:check_out','trim|xss_clean|required|max_length[15]');
			$this->form_validation->set_rules('reservation_room_count','lang:room_count','trim|xss_clean|required');
			
			if ($this->form_validation->run() == FALSE) {
				
				$rates = $this->GNM->getInfo($hotel, 'RATE', null, null, null, null, null, 1);
				$plans = $this->GNM->getInfo($hotel, 'PLAN', null, null, null, null, null, 1);
				$error = 1;
			
				$data['rates'] = $rates;
				$data['plans'] = $plans;
				$data['error'] = $error;
			
				$this->load->view('pms/reservations/reservation_create_1_view', $data);
			
			} else {
			
				$reservationRate = set_value('reservation_rate');
				$reservationPlan = set_value('reservation_plan');
				$reservationCheckIn   = set_value('reservation_check_in');
				$reservationCheckOut  = set_value('reservation_check_out');
				$reservationRoomCount = set_value('reservation_room_count');
				
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
				
				$datestring = "%Y-%m-%d";
				$time       = time();
				$now        = mdate($datestring, $time);
					
				
				if (($checkOut <= $checkIn) || ($checkIn < $now)) {
				
					$rates = $this->GNM->getInfo($hotel, 'RATE', null, null, null, null, null, 1);
					$plans = $this->GNM->getInfo($hotel, 'PLAN', null, null, null, null, null, 1);
					
					if ($checkOut <= $checkIn) {
						$error = lang("errorCheckInOutDates");
					}
					
					if ($checkIn < $now) {
						$error = lang("errorCheckInToday");
					}
				
					$data['error'] = $error;
					$data['rates'] = $rates;
					$data['plans'] = $plans;
				
					$this->load->view('pms/reservations/reservation_create_1_view', $data);
					
				} else {
					
					$datestring = "%Y-%m-%d %h:%i";
					$time       = time();
					$nowTime    = mdate($datestring, $time);
		
					$data = array(
						'resDate'     => $nowTime,
						'status'      => 'Quotation',
						'checkIn'     => $checkIn,
						'checkOut'    => $checkOut,
						'details'     => NULL,
						'paymentStat' => 'Not paid',
						'billingStat' => 'Not billed',
						'fk_rate'     => $reservationRate,
						'fk_plan'     => $reservationPlan,
						'fk_guest'    => NULL
						);
					
					/*********************************************/
					//$this->db->trans_start();
					/********************************************/
					
					$this->GNM->insert('RESERVATION', $data);  
				
					$reservationId = $this->db->insert_id('RESERVATION');
					
					for ($i=1; $i<=$reservationRoomCount; $i++) {
						
						$valA = 'reservation_adults'.$i;
						$adults = $_POST[$valA];
						
						$valC = 'reservation_children'.$i;
						$children = $_POST[$valC];
						
						$totalPers = $adults + $children;
						$pers = $totalPers;
						$asRoom = NULL;
						
						while (! $asRoom) {
					
							$asRoomType = $this->ROM->getAsRoomType($hotel, $pers, $totalPers);
								
							if ($asRoomType) {
								
								$asRoom = $this->ROM->getAsRoom($hotel, $asRoomType['id_room_type'], $checkIn, $checkOut);
							}
							
							if ($pers > 6) {
								break;
							}
							
							$pers++;
						}
						
						if ($asRoom) {
							
							$roomId = $asRoom['id_room'];
							$roomNum = $asRoom['number'];
							
							$data = array(
								'adults'   => $adults,
								'children' => $children,
								'total'    => 0,
								'fk_room'  => $roomId,
								'fk_reservation' => $reservationId
							);
							
							$this->GNM->insert('ROOM_RESERVATION', $data);
						}  
					}
					
					$reservationRoomInfo = $this->ROM->getRRInfo($hotel, 'fk_reservation', $reservationId);
					
					if ($reservationRoomInfo) {
					
						$nights = $reservationCheckOut - $reservationCheckIn;
						
						$priceAdults   = 0;
						$priceChildren = 0;
						$date = $checkIn;
						
						foreach ($reservationRoomInfo as $row) {
							
							$roomType = $row['fk_room_type'];
							$room     = $row['fk_room'];
							$adults   = $row['adults'];
							$children = $row['children'];
							
							for ($i = 1; $i <= $nights; $i++) {
								
								$season = $this->SEM->getSeason($date);
								$rows = count($season);
							
								if ($rows == 1) {
									foreach ($season as $row) {
										$seasonId = $row['id_season'];
									}
								}
								if ($rows == 2) {
									foreach ($season as $row) {
										if ($row['fk_season'] != NULL) {
											$seasonId = $row['id_season'];
										}
									}
								}
								if ($rows == 3) {
									foreach ($season as $row) {
										foreach ($season as $row1) {
											if (($row1['fk_season'] == $row['id_season']) && ($row['fk_season'] != NULL)) {
												$seasonId = $row1['id_season'];
											}
										}
									}
								}
								
								$priceAdu = $this->PRM->getPriceInfo($seasonId, $reservationRate, $reservationPlan, $roomType, 'Adults');
								$priceChi = $this->PRM->getPriceInfo($seasonId, $reservationRate, $reservationPlan, null,      'Children');
							
								foreach ($priceAdu as $row){
									if ($row['hasWeekdays'] == 'No') {
										$priceAPN = $row['pricePerNight'];
									} else {
										 $dateDay = date('l', strtotime($date));
										 
										 if ($dateDay == 'Monday') {
											$priceAPN = $row['monPrice'];
										 }
										 if ($dateDay == 'Tuesday') {
											$priceAPN = $row['tuePrice'];
										 }
										 if ($dateDay == 'Wednesday') {
											$priceAPN = $row['wedPrice'];
										 }
										 if ($dateDay == 'Thursday') {
											$priceAPN = $row['thuPrice'];
										 }
										 if ($dateDay == 'Friday') {
											$priceAPN = $row['friPrice'];
										 }
										 if ($dateDay == 'Saturday') {
											$priceAPN = $row['satPrice'];
										 }
										 if ($dateDay == 'Sunday') {
											$priceAPN = $row['sunPrice'];
										 }
									}
								}
								
								foreach ($priceChi as $row){
									if ($row['hasWeekdays'] == 'No') {
										$priceCPN = $row['pricePerNight'];
									} else {
										$dateDay = date('l', strtotime($date));
										 if ($dateDay == 'Monday') {
											$priceCPN = $row['monPrice'];
										 }
										 if ($dateDay == 'Tuesday') {
											$priceCPN = $row['tuePrice'];
										 }
										 if ($dateDay == 'Wednesday') {
											$priceCPN = $row['wedPrice'];
										 }
										 if ($dateDay == 'Thursday') {
											$priceCPN = $row['thuPrice'];
										 }
										 if ($dateDay == 'Friday') {
											$priceCPN = $row['friPrice'];
										 }
										 if ($dateDay == 'Saturday') {
											$priceCPN = $row['satPrice'];
										 }
										 if ($dateDay == 'Sunday') {
											$priceCPN = $row['sunPrice'];
										 }
									}
								}
							
								$priceAdults   = $priceAdults   + $priceAPN;
								$priceChildren = $priceChildren + $priceCPN;
										
								$totalPriceAdults   = $priceAdults   * $adults;
								$totalPriceChildren = $priceChildren * $children;
								
								$date++;
							}
							
							$totalPrice = $totalPriceAdults + $totalPriceChildren;
							
							$data = array(
								'total' => $totalPrice
							);
						
							$this->GNM->doubleUpdate('ROOM_RESERVATION', 'fk_reservation', $reservationId, 'fk_room', $room, $data);
							
							$priceAdults   = 0;
							$priceChildren = 0;	
							$totalPrice    = 0;	
							$date = $checkIn;			
						}
						
						$reservationRoomInfo  = $this->ROM->getRRInfo($hotel, 'fk_reservation', $reservationId);
						$reservationRoomCount = $this->ROM->getRRCount($hotel, 'fk_reservation', $reservationId, null, null);
						$rates = $this->GNM->getInfo($hotel, 'RATE', null, null, null, null, null, 1);
						$plans = $this->GNM->getInfo($hotel, 'PLAN', null, null, null, null, null, 1);
				
						$data['nights'] = $nights;
						$data['rates']  = $rates;
						$data['plans']  = $plans;
						$data['reservationId']        = $reservationId;
						$data['reservationTotal']     = $reservationTotal;
						$data['reservationRoomInfo']  = $reservationRoomInfo;
						$data['reservationRoomCount'] = $reservationRoomCount;
							
						$this->load->view('pms/reservations/reservation_create_2_view', $data);
					
					} else {
					
						$this->GNM->delete('RESERVATION', 'id_reservation', $reservationId);
						
						$totalPrice = 0;
						$totalP = 0;
						
						for ($i=1; $i<=$reservationRoomCount; $i++) {
						
							$valA = 'reservation_adults'.$i;
							$adults = $_POST[$valA];
							
							$valC = 'reservation_children'.$i;
							$children = $_POST[$valC];
							
							$totalPers = $adults + $children;
							$pers = $totalPers;
								
							$quotationRoomType = $this->ROM->getAsRoomType($hotel, $pers, $totalPers);
							$roomTypeId = $quotationRoomType['id_room_type'];
							
							$nights = $reservationCheckOut - $reservationCheckIn;
						
							$priceAdults   = 0;
							$priceChildren = 0;
							$date = $checkIn;
							
							for ($j = 1; $j <= $nights; $j++) {
								
								$season = $this->SEM->getSeason($date);
								$rows = count($season);
							
								if ($rows == 1) {
									foreach ($season as $row) {
										$seasonId = $row['id_season'];
									}
								}
								if ($rows == 2) {
									foreach ($season as $row) {
										if ($row['fk_season'] != NULL) {
											$seasonId = $row['id_season'];
										}
									}
								}
								if ($rows == 3) {
									foreach ($season as $row) {
										foreach ($season as $row1) {
											if (($row1['fk_season'] == $row['id_season']) && ($row['fk_season'] != NULL)) {
												$seasonId = $row1['id_season'];
											}
										}
									}
								}
							
								$priceAdu = $this->PRM->getPriceInfo($seasonId, $reservationRate, $reservationPlan, $roomTypeId, 'Adults');
								$priceChi = $this->PRM->getPriceInfo($seasonId, $reservationRate, $reservationPlan, null,      'Children');
							
								foreach ($priceAdu as $row){
									if ($row['hasWeekdays'] == 'No') {
										$priceAPN = $row['pricePerNight'];
									} else {
										 $dateDay = date('l', strtotime($date));
										 
										 if ($dateDay == 'Monday') {
											$priceAPN = $row['monPrice'];
										 }
										 if ($dateDay == 'Tuesday') {
											$priceAPN = $row['tuePrice'];
										 }
										 if ($dateDay == 'Wednesday') {
											$priceAPN = $row['wedPrice'];
										 }
										 if ($dateDay == 'Thursday') {
											$priceAPN = $row['thuPrice'];
										 }
										 if ($dateDay == 'Friday') {
											$priceAPN = $row['friPrice'];
										 }
										 if ($dateDay == 'Saturday') {
											$priceAPN = $row['satPrice'];
										 }
										 if ($dateDay == 'Sunday') {
											$priceAPN = $row['sunPrice'];
										 }
									}
								}
								
								foreach ($priceChi as $row){
									if ($row['hasWeekdays'] == 'No') {
										$priceCPN = $row['pricePerNight'];
									} else {
										$dateDay = date('l', strtotime($date));
										 if ($dateDay == 'Monday') {
											$priceCPN = $row['monPrice'];
										 }
										 if ($dateDay == 'Tuesday') {
											$priceCPN = $row['tuePrice'];
										 }
										 if ($dateDay == 'Wednesday') {
											$priceCPN = $row['wedPrice'];
										 }
										 if ($dateDay == 'Thursday') {
											$priceCPN = $row['thuPrice'];
										 }
										 if ($dateDay == 'Friday') {
											$priceCPN = $row['friPrice'];
										 }
										 if ($dateDay == 'Saturday') {
											$priceCPN = $row['satPrice'];
										 }
										 if ($dateDay == 'Sunday') {
											$priceCPN = $row['sunPrice'];
										 }
									}
								}
							
								$priceAdults  = $priceAdults   + $priceAPN;
								$priceChildren = $priceChildren + $priceCPN;
										
								$totalPriceAdults   = $priceAdults   * $adults;
								$totalPriceChildren = $priceChildren * $children;
								
								$totalRoomPrice = $totalPriceAdults + $totalPriceChildren;
								$totalP = $totalP + $totalPers;
								
								$date++;
							}
						
							$totalPrice = $totalPrice + $totalRoomPrice;
							$totalPers = $totalPers + $adults + children;
						}
						
						$rate = $this->GNM->getInfo($hotel, 'RATE', 'id_rate', $reservationRate, null, null, null, 1);
						$plan = $this->GNM->getInfo($hotel, 'PLAN', 'id_plan', $reservationPlan, null, null, null, 1);
						
						$error = lang("NoAvailability");
						
						$data['error']      = $error;
						$data['rate']       = $rate;
						$data['plan']       = $plan;
						$data['nights']     = $nights;
						$data['checkIn']    = $reservationCheckIn;
						$data['checkOut']   = $reservationCheckOut;
						$data['roomCount']  = $reservationRoomCount;
						$data['totalPrice'] = $totalPrice;
						$data['totalP']     = $totalP;
				
						$this->load->view('pms/reservations/reservation_no_availability_view', $data);
					}
				}
			}
			
		} else {
		
			$data['error'] = NULL;
			$this->load->view('pms/users/user_sign_in', $data);
		}
	}
	
	
	function createReservation2($reservationId)
	{
		$userId = $this->session->userdata('userid');
		
		if ($userId) {

			$hotel = $this->session->userdata('hotelid');
			
			$reservationRoomInfo = $this->ROM->getRRInfo($hotel, 'fk_reservation', $reservationId);
			$reservationRoomCount = $this->ROM->getRRCount($hotel, 'fk_reservation', $reservationId, null, null);
			
			$data['error'] = 1;
			$data['reservationId']        = $reservationId;
			$data['reservationRoomInfo']  = $reservationRoomInfo;
			$data['reservationRoomCount'] = $reservationRoomCount;
						
			$this->load->view('pms/reservations/reservation_create_3_view', $data);	
		
		} else {
			
			$data['error'] = NULL;
			$this->load->view('pms/users/user_sign_in', $data);
		}
	}


	function createReservation3($reservationId)
	{	
		$userId = $this->session->userdata('userid');
		
		if ($userId) {
		
			$hotel = $this->session->userdata('hotelid');
	
			$this->form_validation->set_rules('guest_ci','lang:ci','trim|xss_clean|required|max_length[8]');
			$this->form_validation->set_rules('guest_name','lang:name','trim|xss_clean|required|max_length[30]');
			$this->form_validation->set_rules('guest_2name','lang:2name','trim|xss_clean|max_length[30]');
			$this->form_validation->set_rules('guest_last_name','lang:last_name','trim|xss_clean|required|max_length[30]');
			$this->form_validation->set_rules('guest_2last_name','lang:2last_name','trim|xss_clean|max_length[30]');
			$this->form_validation->set_rules('guest_telephone','lang:telephone','trim|xss_clean|required|max_length[20]');
			$this->form_validation->set_rules('guest_email','lang:email','trim|xss_clean|required|valid_email|max_length[50]');
			$this->form_validation->set_rules('guest_address','lang:address','trim|xss_clean|max_length[300]');
			
			if ($this->form_validation->run() == FALSE) {
			
				$reservationRoomInfo  = $this->ROM->getRRInfo($hotel, 'fk_reservation', $reservationId);
				$reservationRoomCount = $this->ROM->getRRCount($hotel, 'fk_reservation', $reservationId, null, null);
			
				$data['reservationRoomInfo'] = $reservationRoomInfo;
				$data['reservationRoomCount'] = $reservationRoomCount;
				$data['reservationId'] = $reservationId;
				
				$this->load->view('pms/reservations/reservation_create_3_view', $data);
			
			} else {
				
				//$reservationRoomCount = $this->ROM->getRRCount($hotel, 'fk_reservation', $reservationId, null, null);
				$reservationRoomInfo  = $this->ROM->getRRInfo($hotel, 'fk_reservation', $reservationId);
				$reservationRoomCount = $this->ROM->getRRCount($hotel, 'fk_reservation', $reservationId, null, null);
				
				$complete = 'Yes';
				
				if ($reservationRoomCount > 1) {
				
						foreach ($reservationRoomInfo as $row) {
					
						$varCi       = 'guest_ci'.$row['number'];
						$varName     = 'guest_name'.$row['number'];
						$varLastName = 'guest_last_name'.$row['number'];
						
						$otherGuestCi       = $_POST[$varCi];
						$otherGuestName     = $_POST[$varName];
						$otherGuestLastName = $_POST[$varLastName];
						
						if ( ($otherGuestCi == NULL) || ($otherGuestName == NULL) || ($otherGuestLastName == NULL) ) {
							$complete = 'No';
						}
					}
				}
				
				if ($complete == 'No') {
					
					$error = lang("errorOtherGuests");
					
					$reservationRoomInfo  = $this->ROM->getRRInfo($hotel, 'fk_reservation', $reservationId);
					$reservationRoomCount = $this->ROM->getRRCount($hotel, 'fk_reservation', $reservationId, null, null);
			
					$data['error'] = $error;
					$data['reservationRoomInfo'] = $reservationRoomInfo;
					$data['reservationRoomCount'] = $reservationRoomCount;
					$data['reservationId'] = $reservationId;
					
					$this->load->view('pms/reservations/reservation_create_3_view', $data);
				
				} else {
				
					foreach ($reservationRoomInfo as $row) {
									
						$varCi       = 'guest_ci'.$row['number'];
						$varName     = 'guest_name'.$row['number'];
						$varLastName = 'guest_last_name'.$row['number'];
						
						$otherGuestCi       = $_POST[$varCi];
						$otherGuestName     = $_POST[$varName];
						$otherGuestLastName = $_POST[$varLastName];
						
						$data = array(
							'ci'        => $otherGuestCi,
							'name'      => ucwords(strtolower($otherGuestName)),
							'lastName'  => ucwords(strtolower($otherGuestLastName)),
							'age'       => NULL,
							'fk_reservation' => $reservationId,
							'fk_room'   => $row['id_room']
						);
					
						$this->GNM->insert('OTHER_GUEST', $data);  
						
						if (($row['children'] != 0) && ($row['children'] != NULL)) {
							
							for ($i=1; $i<=$row['children']; $i++) {
								
								$varAge  = 'children_age'.$row['number'].'_'.$i;
								$otherGuestAge  = $_POST[$varAge];
								
								$data = array(
									'ci'        => NULL,
									'name'      => NULL,
									'lastName'  => NULL,
									'age'       => $otherGuestAge,
									'fk_reservation' => $reservationId,
									'fk_room'   => $row['id_room']
								);
					
								$this->GNM->insert('OTHER_GUEST', $data);
							}
						}
	
					}
				
					$reservationDetails  = set_value('reservation_details');
					
					$guestCi        = set_value('guest_ci');	
					$guestName      = set_value('guest_name');
					$guest2Name     = set_value('guest_2name');
					$guestLastName  = set_value('guest_last_name');
					$guest2LastName = set_value('guest_2last_name');
					$guestTelephone = set_value('guest_telephone');
					$guestEmail     = set_value('guest_email');
					$guestAddress   = set_value('guest_address');
					
					if ($guestCi == NULL) {
						$guestCi = NULL;
					}
					if ($guestName2 == NULL) {
						$guestName2 = NULL;
					}
					if ($guestLastName2 == NULL) {
						$guestLastName2 = NULL;
					}
					if ($guestAddress == NULL) {
						$guestAddress = NULL;
					}
					
					$data = array(
						'ci'        => $guestCi,
						'name'      => ucwords(strtolower($guestName)),
						'name2'     => ucwords(strtolower($guest2Name)),
						'lastName'  => ucwords(strtolower($guestLastName)),
						'lastName2' => ucwords(strtolower($guest2LastName)),
						'telephone' => $guestTelephone,
						'email'     => strtolower($guestEmail),
						'address'   => $guestAddress
						);
					
					$this->GNM->insert('GUEST', $data);  
					
					$guestId = $this->db->insert_id('GUEST');
					
					$datestring = "%Y-%m-%d %h:%i";
					$time       = time();
					$date       = mdate($datestring, $time);
		
					$data = array(
						'resDate'  => $date,
						'status'   => 'Reserved',
						'details'  => $reservationDetails,
						'fk_guest' => $guestId
						);
					
					$this->GNM->update('RESERVATION', 'id_reservation', $reservationId, $data);   
					
					/***************************************/
					//$this->db->trans_complete();
					/**************************************/
						
					$this->viewPendingReservations();
				}
			}
			
		} else {
		
			$data['error'] = NULL;
			$this->load->view('pms/users/user_sign_in', $data);
		}
	}
	
	
	function modifyRoomReservationTotal()
	{			
		$this->form_validation->set_rules('new_total','lang:new_total','trim|xss_clean|required|max_length[10]');
			
		if ($this->form_validation->run() == FALSE) {
			
			$userId = $this->session->userdata('userid');
		
			if ($userId) {
				
				$hotel = $this->session->userdata('hotelid');
		
				$reservationId = $this->uri->segment(3);
				$roomId = $this->uri->segment(4);
		
				$roomReservationInfo = $this->ROM->getRRInfo($hotel, 'fk_reservation', $reservationId);
				
				$data['roomId'] = $roomId;
				$data['roomReservationInfo'] = $roomReservationInfo;
				
				$this->load->view('pms/reservations/reservation_modify_room_total_view', $data);
				
			} else {
			
				$data['error'] = NULL;
				$this->load->view('pms/users/user_sign_in', $data);
			}
			
		} else {
		
			$reservationId = $this->uri->segment(3);
			$roomId = $this->uri->segment(4);
				
			$newTotal = set_value('new_total');
			
			$data = array(
					'total' => $newTotal
					);
					
			$this->GNM->doubleUpdate('ROOM_RESERVATION', 'fk_reservation', $reservationId, 'fk_room', $roomId, $data);
			
			$this->infoReservation($reservationId);
		}
	}
	
	
	function modifyReservationRooms()
	{
		$userId = $this->session->userdata('userid');
		
		if ($userId) {
		
			$reservationId = $this->uri->segment(3);
			$roomId = $this->uri->segment(4);
		
			$hotel = $this->session->userdata('hotelid');
			
			$roomReservationInfo = $this->ROM->getRoomReservationsGuest($hotel, 'id_reservation', $reservationId, null);
			$roomTypes        = $this->GNM->getInfo($hotel, 'ROOM_TYPE', null, null, null, null, null, 1);
			
			foreach ($roomReservationInfo as $row) {
			
				if ($row['id_room'] == $roomId) {
				
					$roomType = $row['id_room_type'];
					$checkIn  = $row['checkIn'];
					$checkOut = $row['checkOut'];
					$totalPer = $row['adults'] + $row['children'];
				}
			}
			
			$availableType  = $this->ROM->getAvailability ($hotel, $roomType, $checkIn, $checkOut);
			$availableOther = $this->ROM->getAvailabilityOther($hotel, $checkIn, $checkOut, $totalPer);
			
			$data['roomId']         = $roomId; 
			$data['roomTypes']      = $roomTypes; 
			$data['availableType']  = $availableType;  	
			$data['availableOther'] = $availableOther;  
			$data['roomReservationInfo'] = $roomReservationInfo; 
			
			$this->load->view('pms/reservations/reservation_modify_rooms_view', $data);
			
		} else {
		
			$data['error'] = NULL;
			$this->load->view('pms/users/user_sign_in', $data);
		}
	}
	
	
	/*
	function modifyReservationRooms2($reservationId, $oldRoomNum, $newRoomNum)
	{
	
		// MODIFICAR PRECIOOOOO!!!!!!!!!!!!!!!!!
		
		$userId = $this->session->userdata('userid');
		
		if ($userId) {
			
			$data = array(
					'fk_room' => $newRoomNum
					);
					
			$this->GNM->doubleUpdate('ROOM_RESERVATION', 'fk_reservation', $reservationId, 'fk_room', $oldRoomNum, $data);
			$this->GNM->doubleUpdate('OTHER_GUEST', 'fk_reservation', $reservationId, 'fk_room', $oldRoomNum, $data); 
			
			echo 'Habitacion cambiada!'; 
			
			$this->infoReservation($reservationId);
		
		} else {
			
			$data['error'] = NULL;
			$this->load->view('pms/users/user_sign_in', $data);
		}
	}
	*/
	
	function modifyReservationDates($reservationId)
	{
		$userId = $this->session->userdata('userid');
		
		if ($userId) {
		
			$hotel = $this->session->userdata('hotelid');
			
			$this->form_validation->set_rules('reservation_check_in','lang:check_in','trim|xss_clean|required|max_length[15]');
			$this->form_validation->set_rules('reservation_check_out','lang:check_out','trim|xss_clean|required|max_length[15]');
			
			if ($this->form_validation->run() == FALSE) {
			
				$reservationRooms = $this->ROM->getRoomReservationsGuest($hotel, 'id_reservation', $reservationId, null);
				
				$data['reservationRooms'] = $reservationRooms; 
				
				$this->load->view('pms/reservations/reservation_modify_dates_view', $data);
			
			} else {
			
				$reservationCheckIn  = set_value('reservation_check_in');
				$reservationCheckOut = set_value('reservation_check_out');
				
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
				
				$reservationRooms = $this->ROM->getRoomReservationsGuest($hotel, 'id_reservation', $reservationId, null);
				$roomTypes        = $this->GNM->getInfo($hotel, 'ROOM_TYPE', null, null, null, null, null, 1);
		
				foreach ($reservationRooms as $row) {
				
					$room = $row['id_room'];
					$roomType = $row['id_room_type'];
					$totalPer = $row['adults'] + $row['children'];
				}
				
				$availableRoom  = $this->ROM->getRoomAvailability ($hotel, $room, $reservationId, $checkIn, $checkOut);
				
				if (!$availableRoom) {
					
					$data = array(
						'checkIn'  => $reservationCheckIn,
						'checkOut' => $reservationCheckOut
					);
					
					$this->GNM->update('RESERVATION', 'id_reservation', $reservationId, $data);  
					
					echo 'Fechas cambiadas!'; 
			
					$this->infoReservation($reservationId);
			
				} else {
				
					/*$availableType  = $this->ROM->getAvailability ($hotel, $roomType, $checkIn, $checkOut);
					$availableOther = $this->ROM->getAvailabilityOther($hotel, $checkIn, $checkOut, $totalPer);
			 
					$data['availableType']       = $availableType;  	
					$data['availableOther']      = $availableOther; 
					$data['roomTypes']           = $roomTypes;  
					$data['reservationRooms']    = $reservationRooms; 
					$data['reservationCheckIn']  = $reservationCheckIn; 
					$data['reservationCheckOut'] = $reservationCheckOut; 
				
					$this->load->view('pms/reservations/reservation_modify_dates_2_view', $data);
					*/
					echo 'Esa hab no disp.';
				}
			}
		
		} else {
			
			$data['error'] = NULL;
			$this->load->view('pms/users/user_sign_in', $data);
		}
	}
	
	
	function modifyReservationDates2($reservationId, $newCheckIn, $newCheckOut)
	{
		$userId = $this->session->userdata('userid');
		
		if ($userId) {
			
			echo 'post: ', $order = $_GET['res_ci'];
		
		
		/*
		$reservations = $this->GM->get_info('RESERVATION','ID_RESERVATION', $reservation_id, null, null, null, 1);
		foreach ($reservation as $row)
		{
			$room_type = $row['ID_ROOM_TYPE'];
		}
		
		$available = $this->RM->get_availability($room_type, $check_in, $check_out);
		
		$data['available'] = $available;  
		
		$data = array(
				'FK_ID_ROOM' => $new_room_num
				);
				
		$this->GM->double_update('ROOM_RESERVATION', 'FK_ID_RESERVATION', $reservation_id, 'FK_ID_ROOM', $old_room_num, $data); 
		
		echo 'Habitacion cambiada!'; 
		
		$this->info_reservation($reservation_id);
			*/
		
		} else {
			
			$data['error'] = NULL;
			$this->load->view('pms/users/user_sign_in', $data);
		}
	}

	
	/*
	function modify_reservation_rooms_3($reservation_id, $old_room_num, $new_room_num)
	{
		$data = array(
				'FK_ID_ROOM' => $new_room_num
				);
				
		$this->GM->double_update('ROOM_RESERVATION', 'FK_ID_RESERVATION', $reservation_id, 'FK_ID_ROOM', $old_room_num, $data); 
		
		echo 'Habitacion cambiada!'; 
		
		$this->info_reservation($reservation_id);
		
	}
	
	*/
	
	
	function payReservation($reservationId)
	{
		$userId = $this->session->userdata('userid');
		
		if ($userId) {
		
			$hotel = $this->session->userdata('hotelid');
			$user  = $this->session->userdata('userid');
			
			$this->form_validation->set_rules('pers_type','lang:pers_type','trim|xss_clean|required');
			$this->form_validation->set_rules('pers_name','lang:name','trim|xss_clean|required|max_length[200]');
			$this->form_validation->set_rules('pers_id','lang:pers_id','trim|xss_clean|required|max_length[20]');
			$this->form_validation->set_rules('payment_amount','lang:payment_amount','trim|xss_clean|required|max_length[15]');
			$this->form_validation->set_rules('payment_type','lang:payment_type','trim|xss_clean|required');
			$this->form_validation->set_rules('payment_bank','lang:payment_bank','trim|xss_clean|max_length[50]');
			$this->form_validation->set_rules('check_num','lang:check_num','trim|xss_clean|max_length[50]');
			$this->form_validation->set_rules('transfer_num','lang:transfer_num','trim|xss_clean|max_length[50]');
			$this->form_validation->set_rules('payment_details','lang:details','trim|xss_clean|max_length[500]');
					
			if ($this->form_validation->run() == FALSE) {
				
				$guest       = $this->GSM->getGuestInfo($hotel, null, null, null, null, null, null);
				$reservation = $this->REM->getReservationInfo($hotel, 'id_reservation', $reservationId, null, null, null, 1);
			/**/	$payments    = $this->REM->getPaymentInfo($hotel, null, null, $reservationId);
				$reservationRoomInfo  = $this->ROM->getRRInfo($hotel, 'fk_reservation', $reservationId);
				$reservationRoomCount = $this->ROM->getRRCount($hotel, 'fk_reservation', $reservationId, null, null);
				
				$data['error'] = 1;
				$data['guest'] = $guest;
				$data['payments']    = $payments;
				$data['reservation'] = $reservation;
				$data['reservationRoomInfo']  = $reservationRoomInfo;
				$data['reservationRoomCount'] = $reservationRoomCount;
				
				$this->load->view('pms/reservations/reservation_payment_register_view', $data);
			
			} else {
			
				$persType       = set_value('pers_type');
				$persName       = set_value('pers_name');
				$persId         = set_value('pers_id');
				$paymentAmount  = set_value('payment_amount');
				$paymentType    = set_value('payment_type');
				$paymentBank    = set_value('payment_bank');
				$checkNum       = set_value('check_num');
				$transferNum    = set_value('transfer_num');
				$paymentDetails = set_value('payment_details');
				$error = 1;
				
				$amountToPay = $_POST['to_pay'];
				
				if ($paymentAmount > $amountToPay) {
					
					$error = lang("errorPaymentAmount");
				}
				if ( ($paymentType == 'check') && (($paymentBank == NULL) || ($checkNum == NULL)) ) {
					
					$error = lang("errorPaymentBank");
				} 
				if ( ($paymentType == 'transfer') && ($transferNum == NULL) ) {
					
					$error = lang("errorPaymentTransfer");
				} 
				
				if ($error != 1) {
				
					$guest       = $this->GSM->getGuestInfo($hotel, null, null, null, null, null, null);
					$reservation = $this->REM->getReservationInfo($hotel, 'id_reservation', $reservationId, null, null, null, 1);
		/**/			$payments    = $this->REM->getPaymentInfo($hotel, null, null, $reservationId);
					$reservationRoomInfo  = $this->ROM->getRRInfo($hotel, 'fk_reservation', $reservationId);
					$reservationRoomCount = $this->ROM->getRRCount($hotel, 'fk_reservation', $reservationId, null, null);
					
					$data['error'] = $error;
					$data['guest'] = $guest;
					$data['payments'] = $payments;
					$data['reservation'] = $reservation;
					$data['reservationRoomInfo']  = $reservationRoomInfo;
					$data['reservationRoomCount'] = $reservationRoomCount;
					
					$this->load->view('pms/reservations/reservation_payment_register_view', $data);
				
				} else {
					
					if ($paymentType == 'check') {
						$confirmNum = $checkNum;
					} else if ($paymentType == 'transfer') {
						$confirmNum = $transferNum;
					} else {
						$confirmNum = NULL;
					}
				
					$datestring = "%Y-%m-%d %h:%i";
					$time       = time();
					$date       = mdate($datestring, $time);
					
					$data = array(
						'date'   => $date,
						'amount' => $paymentAmount,
						'type'   => $paymentType,
						'bank'   => ucwords(strtolower($paymentBank)),
						'confirmNum' => $confirmNum,
						'persType'   => $persType,
						'persId'     => $persId,
						'persName'   => ucwords(strtolower($persName)),
						'details'    => $paymentDetails,
						'fk_reservation' => $reservationId,
						'fk_user'        => $user
						);
					
					$this->GNM->insert('PAYMENT', $data); 
					
	/**/				$payments = $this->REM->getPaymentInfo($hotel, null, null, $reservationId);
					
					$reservationRoomInfo = $this->ROM->getRRInfo($hotel, 'fk_reservation', $reservationId);
				
					$total = 0;
					foreach ($reservationRoomInfo as $row) {
						$total = $total + $row['total'];
					}
					
					$paid = 0;
					foreach ($payments as $row) {
						$paid = $paid + $row['amount'];
					}
					
					$toPay = $total - $paid;
					
					if ($toPay == 0) {
						
						$data = array(
						  'paymentStat' => 'Paid'
						);
					
						$this->GNM->update('RESERVATION', 'id_reservation', $reservationId, $data); 
					}
					
					$this->infoReservation($reservationId);
				}
			}
			
		} else {
			
			$data['error'] = NULL;
			$this->load->view('pms/users/user_sign_in', $data);
		}
	}
	
	
	function viewReservationPayments($reservationId)
	{
		$userId = $this->session->userdata('userid');
		
		if ($userId) {
		
			$hotel = $this->session->userdata('hotelid');
			
			$guest       = $this->GSM->getGuestInfo($hotel, null, null, null, null, null, null);
			$reservation = $this->REM->getReservationInfo($hotel, 'id_reservation', $reservationId, null, null, null, 1);
			$payments    = $this->REM->getPaymentInfo($hotel, null, null, $reservationId);
			$reservationRoomInfo  = $this->ROM->getRRInfo($hotel, 'fk_reservation', $reservationId);
			$reservationRoomCount = $this->ROM->getRRCount($hotel, 'fk_reservation', $reservationId, null, null);
				
			$data['guest']       = $guest;
			$data['payments']    = $payments;
			$data['reservation'] = $reservation;
			$data['reservationRoomInfo']  = $reservationRoomInfo;
			$data['reservationRoomCount'] = $reservationRoomCount;
				
			$this->load->view('pms/reservations/reservation_payments_view', $data);
			
		} else {
		
			$data['error'] = NULL;
			$this->load->view('pms/users/user_sign_in', $data);
		}
	}
	
	
	function viewPaymentDetails()
	{
		$userId = $this->session->userdata('userid');
		
		if ($userId) {
		
			$reservationId = $this->uri->segment(3);
			$paymentId   = $this->uri->segment(4);
			
			$hotel = $this->session->userdata('hotelid');
			
			$payment = $this->REM->getPaymentInfo($hotel, 'id_payment', $paymentId, $reservationId);
			
			$data['payment'] = $payment;
				
			$this->load->view('pms/reservations/reservation_payment_info_view', $data);
		
		} else {
			
			$data['error'] = NULL;
			$this->load->view('pms/users/user_sign_in', $data);
		}
	}
	
	
	function searchReservation()
	{	
		$this->form_validation->set_rules('search','lang:search','trim|xss_clean|required|max_length[150]');
		
		if ($this->form_validation->run() == FALSE) {
		
			$this->viewPendingReservations();
			
		} else {
		
			$hotel = $this->session->userdata('hotelid');
				
			$searchString = set_value('search');
			
			$result = $this->REM->getReservationInfo($hotel, 'id_reservation', $searchString, null, null, null, null);
				
			if ($result) {
					
				foreach ($result as $row) {
					
					$reservationId = $row['id_reservation'];
				}
					
				$this->infoReservation($reservationId);
				 
			} else {
				
				$this->load->view('pms/reservations/reservation_info_view');
			}
		}
	}
	






}
?>