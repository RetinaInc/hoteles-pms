

<?php 

$this->load->view('pms/header'); 

if ($available)	{

	foreach ($roomTypeInfo as $row) {
		
		$roomTypeName = $row['name'];
	}
	
	echo 'HABITACIONES DISPONIBLES';?><br /><br /><?php
	echo 'Tipo: ', $roomTypeName; ?><br /><?php
	echo 'Fecha check-in: ', $reservationCheckIn; ?><br /><?php
	echo 'Fecha check-out: ', $reservationCheckOut; ?><br /><br /><?php
	$rooms = count($available);
	echo 'Habitaciones disponibles: ',$rooms; ?><br /><br /><?php
	
	foreach ($available as $row) {
	
		echo form_open(base_url().'reservations/createReservation2/'.$row['id_room']);
		echo form_hidden('room_type', $reservationRoomType);
		echo form_hidden('check_in', $reservationCheckIn);
		echo form_hidden('check_out', $reservationCheckOut);
		echo form_submit('sumit', $row['number']);
		echo form_close();
	}
	
} else {

      echo 'NO HAY HABITACIONES DISPONIBLES'."<br><br>";
}

?>

<a href="<?php echo base_url().'reservations/createReservation1'?>">Volver</a>

