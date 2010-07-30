<head>
<script language='javascript' src="<?php echo base_url() . "assets/calendario/"?>popcalendar.js"></script>
<script language='javascript' src="<?php echo base_url() . "assets/calendario/images"?>"></script>
</head>

<?php 

$this->load->view('pms/header'); 

	foreach ($reservationRooms as $row) {
	
		$fullCheckIn   = $row['checkIn'];
		$checkIn_array = explode (' ', $fullCheckIn);
		$checkIn       = $checkIn_array [0];
		$ci_array      = explode ('-',$checkIn);
		$year          = $ci_array[0];
		$month         = $ci_array[1];
		$day           = $ci_array[2];
		$ci            = $day.'-'.$month.'-'.$year;
	
		$fullCheckOut   = $row['checkOut'];
		$checkOut_array = explode (' ', $fullCheckOut);
		$checkOut       = $checkOut_array [0];
		$co_array       = explode ('-',$checkOut);
		$year           = $co_array[0];
		$month          = $co_array[1];
		$day            = $co_array[2];
		$co             = $day.'-'.$month.'-'.$year;
		
		echo 'RESERVACION # ', $row['id_reservation']."<br><br>";
		echo 'Check-In: ', $ci."<br>";
		echo 'Check-Out: ', $co."<br>";
		echo 'Habitación # '.$row['number'].' ('.$row['abrv'].')'."<br><br>";
		$reservationId = $row['id_reservation'];
		$roomType = $row['id_room_type'];
	}	


$attributes = array('name' => 'form1', 'id' => 'form1');

echo form_open(base_url().'reservations/modifyReservationDates/'.$reservationId, $attributes);?>

    <p>Fecha de llegada:			
	<input name="reservation_check_in" type="text" id="dateArrival" onClick="popUpCalendar(this, form1.dateArrival, 'dd-mm-yyyy');" value="<?php echo $ci; ?>" size="10" maxlength="10">
    </p>
    
	<p>Fecha de salida:
    <input name="reservation_check_out" type="text" id="dateDeparture" value="<?php echo $co; ?>" onClick="popUpCalendar(this, form1.dateDeparture, 'dd-mm-yyyy');" size="10">			
</p>
                
	 
<?php
echo "<br>".form_submit('sumit', 'Buscar Disponibilidad');
echo form_close();
?>


<p><br /><a href="<?php echo base_url().'reservations/infoReservation/'.$reservationId?>">Volver</a></p>




