
            
<?php 
$this->load->view('pms/header'); 

	foreach ($reservationRooms as $row) {
	
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
		
		echo 'Nuevo Check-In: ', $reservationCheckIn."<br>";
		echo 'Nuevo Check-Out: ', $reservationCheckOut."<br><br>";
		
		$roomId        = $row['id_room'];
		$roomNum       = $row['number'];
		$roomType      = $row['id_room_type'];
		$roomTypeAbrv  = $row['rtname'];
		$reservationId = $row['id_reservation'];
		$resCi         = $reservationCheckIn;
		$resCo         = $reservationCheckOut;
	}	

if ($availableType) {

	echo 'Habitaciones tipo "'.$row['rtname'].'" disponibles: '."<br><br>";	
	
	foreach ($availableType as $row) {?>
    
		<a href="<?php echo base_url().'reservations/modifyReservationDates2/'.$reservationId.'/'.$roomId.'/'.$row['id_room']; ?>" onClick="return confirm('Seguro que desea cambiar?')" ><?php echo '# '.$row['number'];?></a><?php
	}
	
} else {

	echo 'No hay otras habitaciones tipo "'.$row['rtname'].'" disponibles!';	
}


if ($availableOther) {

	echo "<br><br><br>".'Otros tipos de habitaciones disponibles: ';

	foreach ($roomTypes as $row) {
	
		if ($row['id_room_type'] != $roomType) echo "<br><br>".$row['name'].': ';
	 
		foreach ($availableOther as $row1) {
		
			if (($row1['fk_room_type'] == $row['id_room_type']) && ($row1['fk_room_type'] != $roomType)) {
			
			    ?>&nbsp;<a href="<?php echo base_url().'reservations/modifyReservationDate2/'.$reservationId.'/'.$roomId.'/'.$row1['id_room']; ?>" onClick="return confirm('Seguro que desea cambiar?')" ><?php echo '# '.$row1['number'];?> </a>&nbsp;<?php
			}
		}
 	}
	
} else {

	echo "<br><br>".'NO HAY OTROS TIPOS DE HABITACIONES DISPONIBLES'."<br><br>";
}

?>


<p><br /><a href="<?php echo base_url().'reservations/infoReservation/'.$reservationId?>" onClick="return confirm('Seguro que desea cancelar?')">Cancelar</a></p>




