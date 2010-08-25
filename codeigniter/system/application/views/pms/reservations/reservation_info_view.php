

<?php 

$this->load->view('pms/header'); 

foreach ($reservation as $row) {

	$reservationId = $row['id_reservation'];
	$status        = $row['status'];
	$checkIn       = $row['checkIn'];
	$guestId       = $row['fk_guest'];

	echo 'RESERVACIÓN #'.$reservationId."<br>";
	echo 'Estado: ', lang($row['status'])."<br>"; 
}

$datestring = "%Y-%m-%d";
$time       = time();
$date       = mdate($datestring, $time);

$checkIn_array = explode (' ',$checkIn);
$ciDate        = $checkIn_array[0];

if (($date == $ciDate) && ($status != 'Canceled')) {

	echo anchor(base_url().'reservations/checkInReservation/'.$reservationId,'Check-In')."<br>";
}

if (($date < $ciDate)&& ($status != 'Canceled')) {

	?><a href="<?php echo base_url().'reservations/cancelReservation/'.$reservationId.'/'.$guestId ?>" onClick="return confirm('Seguro que desea cancelar?')">Cancelar Reservación</a><br /><?php
} 

echo "<br>".'INFORMACIÓN CLIENTE'."<br><br>";

foreach ($guest as $row) {

	echo 'Nombre: '.$row['name'].' '.$row['lastName']."<br>";
	
	if ($row['disable'] == 1) {
	
		echo 'Teléfono: '.$row['telephone']."<br>";
 
 		if ($row['email'] != NULL) {
			echo 'Correo: '.$row['email']."<br>";
		}
		if ($row['address'] != NULL) {
			echo 'Dirección: '.$row['address']."<br>";
		}
	}
}

echo "<br>".'INFORMACIÓN RESERVACIÓN'."<br>";
if (($date < $ciDate)&& ($status != 'Canceled')) {

	echo anchor(base_url().'reservations/modifyReservationDates/'.$reservationId, 'Cambiar fechas')."<br><br>";
} 

foreach ($reservation as $row) {

	echo '# Confirmación: ', $row['id_reservation']."<br>";
	$unixCi = human_to_unix($row['checkIn']);
	$unixCo = human_to_unix($row['checkOut']);
	echo 'Llegada: ', date ("D  j/m/Y  g:i a" , $unixCi)."<br>";
	echo 'Salida: ', date ("D  j/m/Y  g:i a" , $unixCo)."<br>";
	echo 'Cant. noches: ', $nights."<br>";
	echo 'Cant. habitaciones: ', $reservationRoomsCount."<br><br>";
	
	echo 'INFORMACIÓN HABITACIÓN(ES)'."<br><br>";
	
	foreach ($room as $row1) {
	
		echo '# Habitación: ', $row1['number']."&nbsp;&nbsp;";
		
		if (($date < $ciDate)&& ($status != 'Canceled')) {
			
	        echo anchor(base_url().'reservations/modifyReservationRooms/'.$reservationId.'/'.$row1['id_room'],'Cambiar');
		} 

		if ($row1['rname'] != NULL) {
		
	        echo "<br>".'Habitación: ', $row1['rname']."<br>";
		}
		
		echo "<br>".'Tipo habitación: ', $row1['abrv']."<br>";
		
		foreach ($reservationRoomInfo as $row2) {
		
			if ($row2['fk_room'] == $row1['id_room']) {
			
				echo 'Número de adultos: ', $row2['adults']."<br>";
				
				if ($row2['children'] != NULL) {
				
					echo 'Número de niños: ', $row2['children']."<br><br>";
				}
			}
		}
	}
	
	echo 'Información de tarifa: '."<br>";
	echo 'Politica de cancelacion: '."<br><br>";

}


$referer = $_SERVER['HTTP_REFERER'];
echo "<a href='" . $referer . "'> Volver</a><br>";

?>
