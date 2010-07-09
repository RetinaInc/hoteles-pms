

<?php 

$this->load->view('header'); 

if ($available)	
{
	foreach ($room_type_info as $row)
	{	
		$room_type_name = $row['NAME'];
	}
	
	echo 'HABITACIONES DISPONIBLES';?><br /><br /><?php
	echo 'Tipo: ', $room_type_name; ?><br /><?php
	echo 'Fecha check-in: ', $reservation_check_in; ?><br /><?php
	echo 'Fecha check-out: ', $reservation_check_out; ?><br /><br /><?php
	$rooms = count($available);
	echo 'Habitaciones disponibles: ',$rooms; ?><br /><br /><?php
	
	foreach ($available as $row)
	{
		echo form_open(base_url().'reservations/create_reservation_2/'.$row['ID_ROOM']);
		echo form_hidden('room_type', $reservation_room_type);
		echo form_hidden('check_in', $reservation_check_in);
		echo form_hidden('check_out', $reservation_check_out);
		echo form_submit('sumit', $row['NUMBER']);
		echo form_close();
	}
	
}
else
	{
		echo 'NO HAY HABITACIONES DISPONIBLES'."<br><br>";
	}

?>

<a href="<?php echo base_url().'reservations/create_reservation_1'?>">Volver</a>

