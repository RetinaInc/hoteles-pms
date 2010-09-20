

<script type="text/javascript" src="<?php echo base_url() . "assets/js/jquery-1.3.2.min.js" ?>"></script>
<script type="text/javascript" src="<?php echo base_url() . "assets/js/jquery_autocomplete/jquery.autocomplete.js" ?>"></script>
<script type="text/javascript" src="<?php echo base_url() . "assets/js/jquery_autocomplete/lib/jquery.bgiframe.min.js" ?>"></script>
<script type="text/javascript" src="<?php echo base_url() . "assets/js/jquery_autocomplete/lib/jquery.ajaxQueue.js" ?>"></script>
<script type="text/javascript" src="<?php echo base_url() . "assets/js/jquery_autocomplete/lib/thickbox-compressed.js" ?>"></script>
<script type='text/javascript' src="<?php echo base_url() . "assets/js/jquery_autocomplete/demo/localdata.js" ?>"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url() . "assets/js/jquery_autocomplete/jquery.autocomplete.css" ?>"/>

<script type="text/javascript">
$(document).ready(function(){
			var search_names = new Array(); 
			<?php
			for ($i=0; $i<=count($names)-1; $i++)
			{
			echo "search_names[".$i."] = '".$names[$i]."';";
			}
			?>

			$('#search').autocomplete(search_names, {
			matchContains: true,
			minChars: 3,
			autoFill: true
			});
});
</script>


<?php
$hotel = $this->session->userdata('hotelid');
$hotelInfo = getInfo(null, 'HOTEL', 'id_hotel', $hotel,  null, null, null, 1);

foreach ($hotelInfo as $row)
{
	echo 'Hotel: ', $row['id_hotel'].' '.$row['name']." ";
}
?>

| Usuarios |
<a href="<?php echo base_url().'users/userSignOut/'; ?>" onclick="return confirm('Seguro que desea salir?')">Salir</a>

<p> 
<a href="<?php echo base_url().'users/main/'; ?>">Inicio</a> |
<a href="<?php echo base_url().'rooms/viewRooms/'; ?>">Habitaciones</a> |
<a href="<?php echo base_url().'rooms/viewRoomTypes/'; ?>">Tipos de Habitaciones</a> |
<a href="<?php echo base_url().'reservations/viewPendingReservations/'; ?>">Reservaciones</a> |
<a href="<?php echo base_url().'reservations/viewCheckedIn/'; ?>">Estadias</a> |
<a href="<?php echo base_url().'reservations/viewCheckIns/'; ?>">Check-Ins</a> |
<a href="<?php echo base_url().'reservations/viewCheckOuts/'; ?>">Check-Outs</a> |
<a href="<?php echo base_url().'guests/viewGuests/'; ?>">Clientes</a> |
<a href="<?php echo base_url().'seasons/viewSeasons/'; ?>">Temporadas</a> |
<a href="<?php echo base_url().'rates/viewRates/'; ?>">Tarifas</a> |
<a href="<?php echo base_url().'plans/viewPlans/'; ?>">Planes</a> |
<a href="<?php echo base_url().'prices/selectSeasonPrices/'; ?>">Precios</a>
</p>
<br />
