<head>
<script language='javascript' src="<?php echo base_url() . "assets/calendario/"?>popcalendar.js"></script>
<script language='javascript' src="<?php echo base_url() . "assets/calendario/images"?>"></script>
</head>

<?php 

$this->load->view('pms/header'); 

	foreach ($reservation_rooms as $row)
	{
		$full_check_in = $row['CHECK_IN'];
		$array_check_in = explode (' ', $full_check_in);
		$check_in = $array_check_in [0];
		$ci_array = explode ('-',$check_in);
		$year = $ci_array[0];
		$month = $ci_array[1];
		$day = $ci_array[2];
		$ci = $day.'-'.$month.'-'.$year;
	
		$full_check_out = $row['CHECK_OUT'];
		$array_check_out = explode (' ', $full_check_out);
		$check_out = $array_check_out [0];
		$co_array = explode ('-',$check_out);
		$year = $co_array[0];
		$month = $co_array[1];
		$day = $co_array[2];
		$co = $day.'-'.$month.'-'.$year;
		
		echo 'RESERVACION # ', $row['ID_RESERVATION']."<br><br>";
		echo 'Check-In: ', $ci."<br>";
		echo 'Check-Out: ', $co."<br>";
		echo 'Habitación # '.$row['NUMBER'].' ('.$row['ABRV'].')'."<br><br>";
		$reservation_id = $row['ID_RESERVATION'];
		$room_type = $row['ID_ROOM_TYPE'];
	}	


$attributes = array('name' => 'form1', 'id' => 'form1');

echo form_open(base_url().'reservations/modifyReservationDates/'.$reservation_id, $attributes);?>

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


<p><br /><a href="<?php echo base_url().'reservations/infoReservation/'.$reservation_id?>">Volver</a></p>




