
<?php
$hotel = $this->session->userdata('hotelid');

if ($hotel) {
	$this->load->view('pms/header'); 
} else {
	$this->load->view('pms/meta'); 
}
?>

<h3>Error en Operación</h3>

<?php 
echo $error;
echo "<br><br>";

if (isset($result)) {

	foreach ($result as $actual) {
		
		echo '# ', $actual . "<br>"; 
	}
}

echo "<br><br>";


if ($type == 'error_room') {
	
	echo anchor('rooms/viewRooms', 'Volver a habitaciones');
}

if ($type == 'error_room_type') {
	
	echo anchor('rooms/viewRoomTypes', 'Volver a tipos de habitaciones');
}

if ($type == 'error_guest') {

	echo anchor('guests/viewGuests', 'Volver a clientes');
}

if ($type == 'error_season') {

	echo anchor('seasons/viewSeasons', 'Volver a temporadas');
}

if ($type == 'error_priv') {
	
	echo anchor('users/main', 'Inicio');
}

?>