

<?php 

$this->load->view('header'); 

foreach ($reservation as $row)
{
	$reservation_id = $row['ID_RESERVATION'];
	$status = $row['STATUS'];
	$check_in = $row['CHECK_IN'];
	$guest_id = $row['FK_ID_GUEST'];

	echo 'RESERVACI�N #'.$reservation_id."<br>";
	echo 'Estado: ', lang($row['STATUS'])."<br>"; 
}

$datestring = "%Y-%m-%d";
$time = time();
$date = mdate($datestring, $time);

$check_in_array = explode (' ',$check_in);
$ci_date = $check_in_array[0];

if (($date == $ci_date) && ($status != 'Canceled'))
{
	echo anchor(base_url().'reservations/check_in_reservation/'.$reservation_id,'Check-In')."<br>";
}

if ($date < $ci_date)
{
	?><a href="<?php echo base_url().'reservations/cancel_reservation/'.$reservation_id.'/'.$guest_id ?>" onClick="return confirm('Seguro que desea cancelar?')">Cancelar Reservaci�n</a><br /><?php
} 

echo "<br>".'INFORMACI�N CLIENTE'."<br><br>";
foreach ($guest as $row)
{
	echo 'Nombre: '.$row['NAME'].' '.$row['LAST_NAME']."<br>";
	
	if ($row['DISABLE'] == 1)
	{
		echo 'Tel�fono: '.$row['TELEPHONE']."<br>";
		if ($row['EMAIL'] != NULL)
		{
			echo 'Correo: '.$row['EMAIL']."<br>";
		}
		if ($row['ADDRESS'] != NULL)
		{
			echo 'Direcci�n: '.$row['ADDRESS']."<br>";
		}
	}
}

echo "<br>".'INFORMACI�N RESERVACI�N'."<br><br>";
foreach ($reservation as $row)
{
	echo '# Confirmaci�n: ', $row['ID_RESERVATION']."<br>";
	$unix_ci = human_to_unix($row['CHECK_IN']);
	$unix_co = human_to_unix($row['CHECK_OUT']);
	echo 'Check In: ', date ("D  j/m/Y  g:i a" , $unix_ci).'&nbsp;&nbsp;&nbsp;'/*.anchor(base_url().'reservations/modify_check_in/'.$reservation_id,'Cambiar')*/."<br>";
	echo 'Check Out: ', date ("D  j/m/Y  g:i a" , $unix_co).'&nbsp;&nbsp;&nbsp;'/*.anchor(base_url().'reservations/modify_check_out/'.$reservation_id,'Cambiar')*/."<br>";
	echo 'Cant. noches: ', $nights."<br>";
	echo 'Cant. habitaciones: ', $reservation_rooms_count."<br><br>";
	
	echo 'INFORMACI�N HABITACI�N(ES)'."<br><br>";
	
	foreach ($room as $row1)
	{
		echo '# Habitaci�n: ', $row1['NUMBER'].'&nbsp;&nbsp;&nbsp;'/*.anchor(base_url().'reservations/modify_reservation_rooms/'.$reservation_id.'/'.$row1['ID_ROOM'],'Cambiar')*/."<br>";
		
		if ($row1['RNAME'] != NULL)
		{
			echo 'Habitaci�n: ', $row1['RNAME']."<br>";
		}
		echo 'Tipo habitaci�n: ', $row1['ABRV']."<br>";
		
		foreach ($reservation_room_info as $row2)
		{
			if ($row2['FK_ID_ROOM'] == $row1['ID_ROOM'])
			{
				echo 'N�mero de adultos: ', $row2['ADULTS']."<br>";
				if ($row2['CHILDREN'] != NULL)
				{
					echo 'N�mero de ni�os: ', $row2['CHILDREN']."<br><br>";
				}
			}
		}
	}
	
	echo 'Informaci�n de tarifa: ???'."<br>";
	echo 'Politica de cancelacion: ???'."<br><br>";

}


$referer = $_SERVER['HTTP_REFERER'];
echo "<a href='" . $referer . "'> Volver</a><br>";

?>
