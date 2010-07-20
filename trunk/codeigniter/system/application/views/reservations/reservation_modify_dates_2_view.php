
            
<?php 
$this->load->view('pms/header'); 

	foreach ($reservation_rooms as $row)
	{
		$full_check_in = $row['CHECK_IN'];
		$array_check_in = explode (' ', $full_check_in);
		$check_in = $array_check_in [0];
		$ci_array = explode ('-',$check_in);
		$year = $ci_array[0];
		$month = $ci_array[1];
		$day = $ci_array[2];
		$ci = $day.'-'.$month.'-'.$year;
	
		$full_check_out = $row['CHECK_OUT'];
		$array_check_out = explode (' ', $full_check_out);
		$check_out = $array_check_out [0];
		$co_array = explode ('-',$check_out);
		$year = $co_array[0];
		$month = $co_array[1];
		$day = $co_array[2];
		$co = $day.'-'.$month.'-'.$year;
		
		echo 'RESERVACION # ', $row['ID_RESERVATION']."<br><br>";
		echo 'Check-In: ', $ci."<br>";
		echo 'Check-Out: ', $co."<br>";
		echo 'Habitación # '.$row['NUMBER'].' ('.$row['ABRV'].')'."<br><br>";
		
		echo 'Nuevo Check-In: ', $reservation_check_in."<br>";
		echo 'Nuevo Check-Out: ', $reservation_check_out."<br><br>";
		
		$room_id = $row['ID_ROOM'];
		$room_num = $row['NUMBER'];
		$room_type = $row['ID_ROOM_TYPE'];
		$room_type_abrv = $row['RTNAME'];
		$reservation_id = $row['ID_RESERVATION'];
		$res_ci = $reservation_check_in;
		$res_co = $reservation_check_out;
	}	

if ($available_type)
{
	echo 'Habitaciones tipo "'.$row['RTNAME'].'" disponibles: '."<br><br>";	
	
	foreach ($available_type as $row)
	{?>
		<a href="<?php echo base_url().'reservations/modifyReservationDates2/'.$reservation_id.'/'.$room_id.'/'.$row['ID_ROOM']; ?>" onClick="return confirm('Seguro que desea cambiar?')" ><?php echo '# '.$row['NUMBER'];?></a><?php
	}
	
}
else
{
	echo 'No hay otras habitaciones tipo "'.$row['RTNAME'].'" disponibles!';	
}


if ($available_other)	
{
	echo "<br><br><br>".'Otros tipos de habitaciones disponibles: ';

	foreach ($room_types as $row)
	{
		if ($row['ID_ROOM_TYPE'] != $room_type) echo "<br><br>".$row['NAME'].': ';
	 
		foreach ($available_other as $row1)
		{
			if (($row1['FK_ID_ROOM_TYPE'] == $row['ID_ROOM_TYPE']) && ($row1['FK_ID_ROOM_TYPE'] != $room_type))
			{
			?>&nbsp;<a href="<?php echo base_url().'reservations/modifyReservationDate2/'.$reservation_id.'/'.$room_id.'/'.$row1['ID_ROOM']; ?>" onClick="return confirm('Seguro que desea cambiar?')" ><?php echo '# '.$row1['NUMBER'];?> </a>&nbsp;<?php
			}
		}
 	}
}
else
{
	echo "<br><br>".'NO HAY OTROS TIPOS DE HABITACIONES DISPONIBLES'."<br><br>";
}

?>


<p><br /><a href="<?php echo base_url().'reservations/infoReservation/'.$reservation_id?>" onClick="return confirm('Seguro que desea cancelar?')">Cancelar</a></p>




