
<?php
$this->load->view('pms/header');
?>

<h3>Modificar Fechas</h3>

<?php
foreach ($reservationRooms as $row) {

	$reservationId = $row['id_reservation'];
	$roomType      = $row['id_room_type'];
	$fullCheckIn   = $row['checkIn'];
	$fullCheckOut  = $row['checkOut'];
}	

$weekDays = array('Dom', 'Lun','Mar','Mie','Jue','Vie','Sab', 'Dom');

$checkIn_array = explode (' ', $fullCheckIn);
$checkInDateSt = $checkIn_array[0];

$checkInDay = date('l', strtotime($checkInDateSt));
$ciDay      = $weekDays[date('N', strtotime($checkInDay))];

$unixCiDate = human_to_unix($fullCheckIn);
$ciDate     = date ("j/m/Y" , $unixCiDate);


$checkOut_array = explode (' ', $fullCheckOut);
$checkOutDateSt = $checkOut_array[0];

$checkOutDay = date('l', strtotime($checkOutDateSt));
$coDay       = $weekDays[date('N', strtotime($checkOutDay))];

$unixCoDate  = human_to_unix($fullCheckOut);
$coDate      = date ("j/m/Y" , $unixCoDate);

$cid_array = explode ('-', $checkInDateSt);
$year      = $cid_array[0];
$month     = $cid_array[1];
$day       = $cid_array[2];
$ciFormat  = $day.'-'.$month.'-'.$year;

$cod_array = explode ('-', $checkOutDateSt);
$year      = $cod_array[0];
$month     = $cod_array[1];
$day       = $cod_array[2];
$coFormat  = $day.'-'.$month.'-'.$year;

	
echo 'RESERVACION # ', $reservationId."<br><br>";
echo 'Check-In: ', $ciDay.' '.$ciDate."<br>";
echo 'Check-Out: ', $coDay.' '.$coDate."<br><br>";
	
foreach ($reservationRooms as $row) {
	
	echo 'Habitación # '.$row['number'].' ('.$row['abrv'].')'."<br>";
}
?>

<br />

<span class="Estilo2">
	(*)Campos obligatorios
</span>

<span class="Estilo1">
	<?php
	echo validation_errors();
	?>
</span>

<?php
if (isset($error)) {

	if ($error != 1) {
	
		echo "<br><br>";
		echo "<span class='Estilo1'>".$error."</span>";
	}
}

$attributes = array('name' => 'form1', 'id' => 'form1');
echo form_open('reservations/modifyReservationDates/'.$reservationId, $attributes);?>

    <p>* Fecha de llegada:			
        <input name="new_check_in" type="text" id="dateArrival" onClick="popUpCalendar(this, form1.dateArrival, 'dd-mm-yyyy');" 
        value="<?php echo $ciFormat; ?>" size="10" maxlength="10">
    </p>
    
	<p>* Fecha de salida:
    	<input name="new_check_out" type="text" id="dateDeparture" value="<?php echo $coFormat; ?>" 
        onClick="popUpCalendar(this, form1.dateDeparture, 'dd-mm-yyyy');" size="10">			
	</p>
                
	 
<?php
echo "<br>";
echo form_submit('sumit', 'Buscar Disponibilidad');
echo form_close();

echo "<br><br>";
echo anchor('reservations/infoReservation/'.$reservationId.'/n/', 'Volver');
?>




