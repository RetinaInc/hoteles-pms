
<?php
$hotel = $this->session->userdata('hotelid');

if ($hotel) {
	$this->load->view('pms/header'); 
} else {
	$this->load->view('pms/meta'); 
}
?>

<h3>Operación Exitosa</h3>

<?php 
echo $message;
echo "<br><br>";

if ($type == 'hotels') {
	
	echo anchor('users/userSignIn', 'Iniciar Sesión');
}

if ($type == 'users') {
	
	echo anchor('users/viewUsers', 'Volver a usuarios');
}

if ($type == 'session_user') {
	
	echo anchor('users/infoUser/'.$userId, 'Volver a usuario');
}

if ($type == 'rooms') {
	
	echo anchor('rooms/viewRooms', 'Volver a habitaciones');
}

if ($type == 'room types') {
	
	echo anchor('rooms/viewRoomTypes', 'Volver a tipos de habitaciones');
}

if ($type == 'room_type_image') {
	
	echo anchor('rooms/infoRoomType/'.$roomTypeId, 'Volver a tipo de habitaci&oacute;n');
}

if ($type == 'reservations') {
	
	echo anchor('reservations/viewPendingReservations', 'Volver a reservaciones');
}

if ($type == 'guests') {
	
	echo anchor('guests/viewGuests', 'Volver a clientes');
}

if ($type == 'seasons') {
	
	echo anchor('seasons/viewSeasons', 'Volver a temporadas');
}

if ($type == 'plans') {
	
	echo anchor('plans/viewPlans', 'Volver a planes');
}

if ($type == 'rates') {
	
	echo anchor('rates/viewRates', 'Volver a tarifas');
}

if ($type == 'cancelHotelAccount') {
	
	echo anchor('users/userSignIn', 'Ir Página Principal');
}

?>