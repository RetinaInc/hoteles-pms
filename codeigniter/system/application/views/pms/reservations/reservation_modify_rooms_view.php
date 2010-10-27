
<?php 
$this->load->view('pms/header'); 
?>

<h3>Modificar Habitación</h3>

<?php
foreach ($roomReservationInfo as $row) {

	if ($row['id_room'] == $roomId) {
		
		$fullCheckIn   = $row['checkIn'];
		$checkIn_array = explode (' ', $fullCheckIn);
		$checkIn       = $checkIn_array [0];
		$ci_array      = explode ('-',$checkIn);
		$year          = $ci_array[0];
		$month         = $ci_array[1];
		$day           = $ci_array[2];
		$ci            = $day.'-'.$month.'-'.$year;
	
		$fullCheckOut   = $row['checkOut'];
		$checkOut_array = explode (' ', $fullCheckOut);
		$checkOut       = $checkOut_array [0];
		$co_array       = explode ('-',$checkOut);
		$year           = $co_array[0];
		$month          = $co_array[1];
		$day            = $co_array[2];
		$co             = $day.'-'.$month.'-'.$year;
		
		echo 'RESERVACION # ', $row['id_reservation']."<br><br>";
		echo 'Check-In: ', $ci."<br>";
		echo 'Check-Out: ', $co."<br>";
		echo 'Habitación # '.$row['number'].' ('.$row['abrv'].')'."<br><br>";
		
		$roomId        = $row['id_room'];
		$roomTypeId    = $row['id_room_type'];
		$roomTypeAbrv  = $row['abrv'];
		$roomTypeName  = $row['rtname'];
		$reservationId = $row['id_reservation'];
	}	
}	

if ($availableType) {

	echo 'Otras habitaciones tipo "'.$roomTypeName.'" disponibles: '."<br><br>";	
	
	foreach ($availableType as $row) {
		
		if ($row['id_room'] != $roomId) {
			
			echo anchor('reservations/modifyReservationRooms2/'.$reservationId.'/'.$roomId.'/'.$row['id_room'], ' # '.$row['number'].' ', array('onClick' => "return confirm('Seguro que desea cambiar?')"));
			
		}
	}
	
} else {

	echo 'No hay otras habitaciones tipo "'.$roomTypeName.'" disponibles!';	
}


if ($availableOther) {

	echo "<br><br><br>".'Otros tipos de habitaciones disponibles: ';

	 foreach ($roomTypes as $row) {
	 
	 	$availableType = 'No';
	 
		foreach ($availableOther as $row1) {
			
			if (($row1['fk_room_type'] == $row['id_room_type']) && ($row1['fk_room_type'] != $roomTypeId)) {
			
			    $availableType = 'Yes';
			}
		}
		
		if ($availableType == 'Yes') {
			
			foreach ($availableOther as $row1) {
				
				if (($row1['fk_room_type'] == $row['id_room_type']) && ($row1['fk_room_type'] != $roomTypeId)) {
				
					echo $row['name'].': ';
					echo anchor('reservations/modifyReservationRooms2/'.$reservationId.'/'.$roomId.'/'.$row1['id_room'], ' # '.$row1['number'].' ', array('onClick' => "return confirm('Seguro que desea cambiar?')"));
				}
			}
		}
		
		echo "<br><br>";
		
 	}
	
} else {

	echo "<br><br>".'No hay otros tipos de habitaciones disponibles'."<br><br>";
}

echo anchor('reservations/infoReservation/'.$reservationId.'/n/', 'Volver');

?>





