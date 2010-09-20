<?php

$this->load->view('pms/header'); 

echo "<br>".'DISPONIBILIDAD'."<br><br>";

foreach ($reservationRoomInfo as $row) {

	$unixCi = human_to_unix($row['checkIn']);
	$unixCo = human_to_unix($row['checkOut']);
	$checkIn  = date ("D  j/m/Y" , $unixCi);
	$checkOut = date ("D  j/m/Y" , $unixCo);
	
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
<table width="289" border="0">
  <tr>
    <td width="96">Tarifa</td>
    <td width="183"><?php echo $rateName; ?>
    </td>
  </tr>
  <tr>
    <td width="96">Plan</td>
    <td width="183"><?php echo $planName; ?></td>
  </tr>
  <tr>
    <td width="96">Llegada</td>
    <td width="183"><?php echo $checkIn?></td>
  </tr>
  <tr>
    <td>Salida</td>
    <td><?php echo $checkOut?></td>
  </tr>
   <tr>
    <td>Noches</td>
    <td><?php echo $nights?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Habitaciones: </td>
    <td><?php echo $reservationRoomCount ?></td>
  </tr>
  	<?php
	$total = 0;
	foreach ($reservationRoomInfo as $row) {
		$total = $total + $row['total'];
	}
	?>
  <tr>
    <td>Total</td>
    <td><?php echo $total ?> Bs.F.</td>
 </tr>
</table>

<p>&nbsp;</p>
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
    <td><?php echo $row['number']?></td>
    <td><?php echo $row['abrv']?></td>
    <td><?php echo $row['adults']?></td>
    <td><?php echo $row['children']?></td>
    <td><?php echo $row['total']?> Bs.F.</td>
  </tr>
  <?php
  }
  ?>
</table>

<br />
<br />
<a href="<?php echo base_url().'reservations/createReservation2/'.$reservationId?>">Reservar</a>
&nbsp;
<a href="<?php echo base_url().'reservations/createReservation1'?>" onClick="return confirm('Seguro que desea cancelar? Se perderá la información')">Cancelar</a>

