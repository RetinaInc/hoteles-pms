
<?php
$hotel = $this->session->userdata('hotelid');
$hotelInfo = getInfo(null, 'HOTEL', 'id_hotel', $hotel,  null, null, null, 1);

foreach ($hotelInfo as $row)
{
	echo 'Hotel: ', $row['id_hotel'].' '.$row['name']."<br><br>";
}
?>

<p>
<!-- <a href="">Calendario</a> |  -->
<a href="<?php echo base_url().'rooms/viewRooms/'; ?>">Habitaciones</a> |
<a href="<?php echo base_url().'rooms/viewRoomTypes/'; ?>">Tipos de Habitaciones</a> |
<a href="<?php echo base_url().'reservations/viewPendingReservations/'; ?>">Reservaciones</a> |
<!-- <a href="">Check - Ins</a> |
<a href="">Check - Outs</a> | -->
<a href="<?php echo base_url().'guests/viewGuests/'; ?>">Clientes</a> |
<a href="<?php echo base_url().'seasons/viewSeasons/'; ?>">Temporadas</a> |
<a href="<?php echo base_url().'rates/viewRates/'; ?>">Tarifas</a> |
<a href="<?php echo base_url().'plans/viewPlans/'; ?>">Planes</a> |
<a href="<?php echo base_url().'users/userSignOut/'; ?>" onclick="return confirm('Seguro que desea salir?')">Salir</a>
</p>
<br />
