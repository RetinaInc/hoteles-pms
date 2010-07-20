

<?php 

$this->load->view('pms/header'); 

foreach ($reservation as $row)
{
	$reservation_id = $row['ID_RESERVATION'];
	$status = $row['STATUS'];
	$check_in = $row['CHECK_IN'];
	$guest_id = $row['FK_ID_GUEST'];

	echo 'RESERVACIÓN #'.$reservation_id."<br>";
	echo 'Estado: ', lang($row['STATUS'])."<br>"; 
}

$datestring = "%Y-%m-%d";
$time = time();
$date = mdate($datestring, $time);

$check_in_array = explode (' ',$check_in);
$ci_date = $check_in_array[0];

if (($date == $ci_date) && ($status != 'Canceled'))
{
	echo anchor(base_url().'reservations/checkInReservation/'.$reservation_id,'Check-In')."<br>";
}

if (($date < $ci_date)&& ($status != 'Canceled'))
{
	?><a href="<?php echo base_url().'reservations/cancelReservation/'.$reservation_id.'/'.$guest_id ?>" onClick="return confirm('Seguro que desea cancelar?')">Cancelar Reservación</a><br /><?php
} 

echo "<br>".'INFORMACIÓN CLIENTE'."<br><br>";
foreach ($guest as $row)
{
	echo 'Nombre: '.$row['NAME'].' '.$row['LAST_NAME']."<br>";
	
	if ($row['DISABLE'] == 1)
	{
		echo 'Teléfono: '.$row['TELEPHONE']."<br>";
		if ($row['EMAIL'] != NULL)
		{
			echo 'Correo: '.$row['EMAIL']."<br>";
		}
		if ($row['ADDRESS'] != NULL)
		{
			echo 'Dirección: '.$row['ADDRESS']."<br>";
		}
	}
}

echo "<br>".'INFORMACIÓN RESERVACIÓN'."<br>";
if (($date < $ci_date)&& ($status != 'Canceled'))
{
	echo anchor(base_url().'reservations/modifyReservationDates/'.$reservation_id, 'Cambiar fechas')."<br><br>";
} 

foreach ($reservation as $row)
{
	echo '# Confirmación: ', $row['ID_RESERVATION']."<br>";
	$unix_ci = human_to_unix($row['CHECK_IN']);
	$unix_co = human_to_unix($row['CHECK_OUT']);
	echo 'Check In: ', date ("D  j/m/Y  g:i a" , $unix_ci)."<br>";
	echo 'Check Out: ', date ("D  j/m/Y  g:i a" , $unix_co)."<br>";
	echo 'Cant. noches: ', $nights."<br>";
	echo 'Cant. habitaciones: ', $reservation_rooms_count."<br><br>";
	
	echo 'INFORMACIÓN HABITACIÓN(ES)'."<br><br>";
	
	foreach ($room as $row1)
	{
		echo '# Habitación: ', $row1['NUMBER']."&nbsp;&nbsp;";
			if (($date < $ci_date)&& ($status != 'Canceled'))
			{
			echo anchor(base_url().'reservations/modifyReservationRooms/'.$reservation_id.'/'.$row1['ID_ROOM'],'Cambiar');
			} 

		if ($row1['RNAME'] != NULL)
		{
			echo "<br>".'Habitación: ', $row1['RNAME']."<br>";
		}
		echo "<br>".'Tipo habitación: ', $row1['ABRV']."<br>";
		
		foreach ($reservation_room_info as $row2)
		{
			if ($row2['FK_ID_ROOM'] == $row1['ID_ROOM'])
			{
				echo 'Número de adultos: ', $row2['ADULTS']."<br>";
				if ($row2['CHILDREN'] != NULL)
				{
					echo 'Número de niños: ', $row2['CHILDREN']."<br><br>";
				}
			}
		}
	}
	
	echo 'Información de tarifa: ???'."<br>";
	echo 'Politica de cancelacion: ???'."<br><br>";

}


$referer = $_SERVER['HTTP_REFERER'];
echo "<a href='" . $referer . "'> Volver</a><br>";

?>
