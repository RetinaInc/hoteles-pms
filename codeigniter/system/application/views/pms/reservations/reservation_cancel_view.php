

<?php 

$this->load->view('pms/header'); 


foreach ($guest as $row) {

	echo 'Cliente: '.$row['name'].' '.$row['lastName']."<br>";	
}

foreach ($reservation as $row) {

	echo 'Reservaci�n #: ', $row['id_reservation']."<br>";
	echo 'Estado: ', lang($row['status'])."<br>"; 
	$unixCi = human_to_unix($row['checkIn']);
	$unixCo = human_to_unix($row['checkOut']);
	echo 'Check In: ', date ("D  j/m/Y  g:i a" , $unixCi)."<br>";
	echo 'Check Out: ', date ("D  j/m/Y  g:i a" , $unixCo)."<br>";
	
	foreach ($room as $row1) {
	
		echo '# Habitaci�n: ', $row1['number']."<br>";
		
		if ($row1['rname'] != NULL) {
		
			echo 'Habitaci�n: ', $row1['rname']."<br>";
		}
		
		echo 'Tipo habitaci�n: ', $row1['abrv']."<br>";
		
		foreach ($reservationRoomInfo as $row2) {
		
			if ($row2['fk_room'] == $row1['id_room']) {
			
				echo 'N�mero de adultos: ', $row2['adults']."<br>";
				
				if ($row2['children'] != NULL) {
				
					echo 'N�mero de ni�os: ', $row2['children']."<br><br>";
				}
			}
		}
	}
}
   
echo anchor(base_url().'reservations/cancelReservation/'.$reservationId,'Cancelar Reservaci�n')."<br>";

$referer = $_SERVER['HTTP_REFERER'];
echo "<a href='" . $referer . "'> Volver</a><br>";

?>
