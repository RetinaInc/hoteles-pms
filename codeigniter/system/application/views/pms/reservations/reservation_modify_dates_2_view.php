
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

$total = 0;

foreach ($reservationRoomInfo as $row) {
	
	$total = $total + $row['total'];
}

$nTotal = 0;

foreach ($quotationRoomInfo as $row) {
	
	$nTotal = $nTotal + $row['total'];
}

$weekDays = array('Dom', 'Lun','Mar','Mie','Jue','Vie','Sab', 'Dom');

foreach ($reservationRoomInfo as $row) {
		
	$ci_array = explode (' ',$row['checkIn']);
	$checkIn  = $ci_array[0];

	$co_array = explode (' ',$row['checkOut']);
	$checkOut = $co_array[0];
	
	$nights = (strtotime($checkOut) - strtotime($checkIn)) / (60 * 60 * 24);
	
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

foreach ($quotationRoomInfo as $row) {
		
	$unixNCi = human_to_unix($row['checkIn']);
	$unixNCo = human_to_unix($row['checkOut']);
	
	$nCheckInDay = date('l', strtotime($row['checkIn']));
    $nCiDay      = $weekDays[date('N', strtotime($nCheckInDay))];
	
	$nCheckOutDay = date('l', strtotime($row['checkOut']));
    $nCoDay      = $weekDays[date('N', strtotime($nCheckOutDay))];
	
	$nCiDate = date ("j/m/Y" , $unixNCi);
	$nCoDate = date ("j/m/Y" , $unixNCo);
	
	break;
}
?>

<table width="666" border="0">

  <tr>
    <td width="50">Tarifa:</td>
  <td width="160">
		<?php
        echo $rateName;
        ?>    </td>
    <td width="60">Llegada:</td>
  	<td width="160">
		<?php 
        echo $ciDay.' '.$ciDate;
        ?>   	</td>
    <td width="60">Noches:</td>
    <td width="150"><?php 
        echo $nights;
        ?></td>
  </tr>
  
  <tr>
    <td width="50">Plan:</td>
  <td width="160">
		<?php
        echo $planName;
        ?>   	</td>
    <td width="60">Salida:</td>
  	<td width="160">
		<?php 
        echo $coDay.' '.$coDate;;
        ?>  	</td>
  	<td width="60">Total:</td>
<td width="150">
		<?php
		echo $total.' Bs.F.';
		?>  	</td>
  </tr>
  </table>

<table width="200" border="0">
  <tr>
   	<td>
		<?php
		echo 'Habitaciones: ', $reservationRoomCount;
        ?>
  	</td>
  </tr>
  
<?php
  foreach ($reservationRoomInfo as $row) {
  	?>
    <tr>
    	<td>
		<?php
		echo '# '.$row['number'].' ('.$row['abrv'].')';
        ?>
        </td>
  	</tr>
    <?php
  }
  ?>
</table>

<br />

<table width="478" border="0">

  <tr>
    <td colspan="4"><strong>Disponibilidad Fechas Nuevas</strong></td>
    </td>
  </tr>
  
  <tr>
    <td width="60">Llegada:</td>
    <td width="150">
		<?php 
        echo $nCiDay.' '.$nCiDate;
        ?>  	
    </td>
    <td width="60">Noches:</td>
    <td width="190">
		<?php 
        echo $nNights;
        ?> 	
   </td>
  </tr>
  
  <tr>
    <td width="60">Salida:</td>
    <td width="150">
		<?php 
        echo $nCoDay.' '.$nCoDate;;
        ?>  	
    </td>
    <td width="60">&nbsp;</td>
    <td width="190">&nbsp;</td>
  </tr>
</table>
  
<br />

<table width="390" border="1">

  <tr>
    <td width="48">&nbsp;</td>
    <td width="48">#</td>
    
    <td width="52">Tipo</td>
    
    <td width="60">Adultos</td>
    
    <td width="56">Niños</td>
    
    <td width="86">Total Hab</td>
  </tr>
  
  <?php
  foreach ($quotationRoomInfo as $row) {
  	  ?>
	  <tr>
	    <td>
			<?php
            echo $row['num'].'.';
            ?>
        </td>
        
		<td>
			<?php 
			echo $row['number'];
			?>		
      	</td>
		
		<td>
			<?php 
			echo $row['abrv'];
			?>		</td>
		
		<td>
			<?php 
			echo $row['adults'];
			?>		</td>
		
		<td>
			<?php 
			echo $row['children'];
			?>		</td>
		
		<td>
			<?php 
			echo $row['total'];
			?> 
			Bs.F.		</td>
	  </tr>
	  <?php
  }
  ?>
</table>

<br />

<?php
echo 'NUEVO TOTAL: ', $nTotal.' Bs.F.'."<br>";
echo anchor('reservations/modifyReservationDates2/'.$reservationId.'/'.$quotationId, 'RESERVAR', array('onClick' => "return confirm('Seguro que desea reservar?')"));
?>

<br /><br />
<strong>Elegir otro(s) tipo(s) de Habitación(es):</strong>
<br /><br />

<?php

echo form_open('reservations/modifyReservationDatesSearchAvail/'.$quotationId.'/'.$reservationId);

$hotel = $this->session->userdata('hotelid');

foreach ($quotationRoomInfo as $row) {
	
	$num      = $row['num'];
	$adults   = $row['adults'];
	$children = $row['children'];
	
	$totalPers = $adults + $children;
	
	$roomTypes = getRoomTypes($hotel, $totalPers);
	
	echo 'Tipo habitación '.$num.' ('.$totalPers.' pers): ';
	
	?>
	<select name="room_type<?php echo $num; ?>" id="room_type<?php echo $num; ?>">
  		<?php
		foreach ($roomTypes as $row1) {
			?>
  			<option value="<?php echo $row1['id_room_type']; ?>" <?php echo set_select('room_type'.$num, $row1['id_room_type']); ?>><?php echo $row1['name']; ?></option>
  			<?php
		}
		?>
	</select>
	<?php	
	echo "<br><br>";
}

$att = array(
	'name'        => 'submit',
    'id'          => 'submit',
    'onClick'     => "return confirm('Seguro que desea guardar?')"
);
echo form_submit($att, 'Buscar Disponibilidad');
echo form_close();

echo "<br>";

echo anchor('reservations/deleteReservationQuotation/'.$quotationId.'/'.$reservationId, 'Cancelar', array('onClick' => "return confirm('Seguro que desea cancelar? Se perderá la información')")); 
?>











