
<?php
$this->load->view('pms/header'); 
?>

<h3>Disponibilidad</h3>

<?php

if (isset($error)) {
	
	echo "<span class='Estilo1'>".$error."</span>";
	echo "<br><br>";
}

if (isset($errorPrice)) {
	
	echo "<span class='Estilo1'>".$errorPrice."</span>";
	echo "<br><br>";
}

if (isset($errorRoom)) {
	
	echo "<span class='Estilo1'>".$errorRoom."</span>";
	echo "<br><br>";
}

$weekDays = array('Dom', 'Lun','Mar','Mie','Jue','Vie','Sab', 'Dom');

foreach ($reservationRoomInfo as $row) {
		
	$unixCi = human_to_unix($row['checkIn']);
	$unixCo = human_to_unix($row['checkOut']);
	
	$checkInDay = date('l', strtotime($row['checkIn']));
    $ciDay      = $weekDays[date('N', strtotime($checkInDay))];
	
	$checkOutDay = date('l', strtotime($row['checkOut']));
    $coDay      = $weekDays[date('N', strtotime($checkOutDay))];
	
	$ciDate  = date ("j/m/Y" , $unixCi);
	$coDate = date ("j/m/Y" , $unixCo);
	
	foreach ($rates as $row1) {
	
		if ($row1['id_rate'] == $row['fk_rate']) {
		
			$rateName = $row1['name'];
		}
	} 
	
	foreach ($plans as $row1) {
	
		if ($row1['id_plan'] == $row['fk_plan']) {
		
			$planName = $row1['name'];
		}
	} 
	
	break;
}

?>
<table width="702" border="0">

  <tr>
    <td width="50">Tarifa:</td>
    <td width="148">
		<?php 
        echo $rateName; 
        ?>   	</td>
    <td width="60">Llegada:</td>
  <td width="136">
		<?php 
        echo $ciDay.' '.$ciDate;
        ?>   	</td>
    <td width="90">Noches:</td>
    <td width="192">
	  <?php 
        echo $nights;
        ?>  	</td>
  </tr>
  
  <tr>
    <td width="50">Plan:</td>
    <td width="148">
		<?php 
        echo $planName; 
        ?>   	</td>
    <td width="60">Salida:</td>
  <td width="136">
		<?php 
        echo $coDay.' '.$coDate;;
        ?>   	</td>
    <td width="90">Habitaciones: </td>
    <td width="192">
	  <?php 
        echo $reservationRoomCount;
        ?>  	</td>
  </tr>
  
  <?php
  $total = 0;
  foreach ($reservationRoomInfo as $row) {
		
		$total = $total + $row['total'];
  }
  ?>
</table>

<br />
<strong>Mejor Oferta:</strong>
<br />

<?php
echo anchor('reservations/createReservation2/'.$reservationId, 'Reservar')."&nbsp;";
?>

<br /><br />

<table width="336" border="1">

  <tr>
    <td width="48">#</td>
    
    <td width="52">Tipo</td>
    
    <td width="60">Adultos</td>
    
    <td width="56">Niños</td>
    
    <td width="86">Total Hab</td>
  </tr>
  
  <?php
  foreach ($reservationRoomInfo as $row) {
  	  ?>
	  <tr>
		<td>
			<?php 
			echo $row['number'];
			?>
		</td>
		
		<td>
			<?php 
			echo $row['abrv'];
			?>
		</td>
		
		<td>
			<?php 
			echo $row['adults'];
			?>
		</td>
		
		<td>
			<?php 
			echo $row['children'];
			?>
		</td>
		
		<td>
			<?php 
			echo $row['total'];
			?> 
			Bs.F.
		</td>
	  </tr>
	  <?php
  }
  ?>
</table>

<br />

<?php
echo 'TOTAL: ', $total.' Bs.F.';
?>

<br /><br />
<strong>Elegir otro(s) tipo(s) de Habitación(es):</strong>
<br /><br />

<?php

echo form_open('reservations/createReservationSearchAvail/'.$reservationId);

$hotel = $this->session->userdata('hotelid');

$i = 1;

foreach ($reservationRoomInfo as $row) {
	
	$adults   = $row['adults'];
	$children = $row['children'];
	$tempRoom = $row['fk_room'];
	
	$totalPers = $adults + $children;
	
	$roomTypes = getRoomTypes($hotel, $totalPers);
	
	echo 'Tipo habitación '.$i.' ('.$totalPers.' pers): ';
	
	?>
	<select name="room_type<?php echo $tempRoom; ?>" id="room_type<?php echo $tempRoom; ?>">
  		<?php
		foreach ($roomTypes as $row1) {
			?>
  			<option value="<?php echo $row1['id_room_type']; ?>" <?php echo set_select('room_type'.$tempRoom, $row1['id_room_type']); ?>><?php echo $row1['name']; ?></option>
  			<?php
		}
		?>
	</select>
	<?php
	$i++;	
	echo "<br><br>";
}

echo form_submit($att, 'Buscar Disponibilidad');
echo form_close();

echo anchor('reservations/deleteReservation/'.$reservationId, 'Cancelar', array('onClick' => "return confirm('Seguro que desea cancelar? Se perderá la información')")); 
?>











