

<?php 

$this->load->view('pms/header'); 

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
	
	foreach ($availableType as $row) {?>
    
		<a href="<?php echo base_url().'reservations/modifyReservationRooms2/'.$reservationId.'/'.$roomId.'/'.$row['id_room']; ?>" onClick="return confirm('Seguro que desea cambiar?')" ><?php echo '# '.$row['number'];?></a><?php
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
					?>&nbsp;<a href="<?php echo base_url().'reservations/modifyReservationRooms2/'.$reservationId.'/'.$roomId.'/'.$row1['id_room']; ?>" onClick="return confirm('Seguro que desea cambiar?')" ><?php echo '# '.$row1['number'];?> </a>&nbsp;<?php
				}
			}
		}
		
		echo "<br><br>";
		
 	}
	
	/*
    foreach ($roomTypes as $row) {
	
        if ($row['id_room_type'] != $roomTypeId) echo "<br><br>".$row['name'].': ';
	 
		foreach ($availableOther as $row1) {
			
			if (($row1['fk_room_type'] == $row['id_room_type']) && ($row1['fk_room_type'] != $roomTypeId)) {
			
			    ?>&nbsp;<a href="<?php echo base_url().'reservations/modifyReservationRooms2/'.$reservationId.'/'.$roomId.'/'.$row1['id_room']; ?>" onClick="return confirm('Seguro que desea cambiar?')" ><?php echo '# '.$row1['number'];?> </a>&nbsp;<?php
			}
		}
 	}
	*/
	
} else {

	echo "<br><br>".'No hay otros tipos de habitaciones disponibles'."<br><br>";
}








/*
if ($available_other)	
{
	echo "<br><br><br>".'Otros tipos de habitaciones disponibles: '."<br>";

	foreach ($room_types as $row)
	{
		if ($row['ID_ROOM_TYPE'] != $room_type) echo "<br><br>".$row['NAME'].': ';
	 
		foreach ($available_other as $row1)
		{
			if (($row1['FK_ID_ROOM_TYPE'] == $row['ID_ROOM_TYPE']) && ($row1['FK_ID_ROOM_TYPE'] != $room_type))
			{
			?>&nbsp;<a href="<?php echo base_url().'reservations/modify_reservation_rooms_2/'.$reservation_id.'/'.$room_id.'/'.$row1['ID_ROOM']; ?>" onClick="return confirm('Seguro que desea cambiar?')" ><?php echo '# '.$row1['NUMBER'];?> </a>&nbsp;<?php
			}
		}
 	}
}
else
{
	echo 'NO HAY OTROS TIPOS DE HABITACIONES DISPONIBLES'."<br><br>";
}
*/


/*
if ($available_all)	
{	
	echo 'Habitaciones disponibles: '."<br><br>";
	
	foreach ($room_types as $row)
	{
		echo $row['ABRV'].': ';
		
		foreach ($available_all as $row1)
		{
			if ($row1['FK_ID_ROOM_TYPE'] == $row['ID_ROOM_TYPE'])
			{
				echo anchor(base_url().'reservations/modify_reservation_rooms_2/'.$reservation_id.'/'.$room_id.'/'.$row1['ID_ROOM'], '&nbsp;'.'# '.$row1['NUMBER']).'&nbsp;&nbsp;';
			}
		}
		echo "<br><br>";
	}
	
	echo "<br><br>";
	
}
else
{
	echo 'NO HAY OTRAS HABITACIONES DISPONIBLES'."<br><br>";
}
*/
?>


<p><a href="<?php echo base_url().'reservations/infoReservation/'.$reservationId?>">Volver</a></p>




