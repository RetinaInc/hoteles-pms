

<?php 

$this->load->view('pms/header'); 

foreach ($roomType as $row) {

	$roomTypeId   = $row['id_room_type'];
	$roomTypeName = $row['name'];
}

echo 'INFO HABITACIONES TIPO "'.$roomTypeName.'"'."<br><br>";

foreach ($roomType as $row) {

	echo 'Nombre: ', $row['name']."<br>";
	
	if ($row['abrv'] != NULL) {
	
		echo 'Abrv: ', $row['abrv']."<br>";
	}

	echo 'Pax estándar: ', $row['paxStd']."<br>";
	
	echo 'Pax máximo: ', $row['paxMax']."<br>";
	
	echo 'Camas: ', $row['beds']."<br>";
	
	if ($row['description'] != NULL) {
	
		echo 'Descripción: ', $row['description']."<br>";
	}
	
	if ($row['disable'] == 1) {
	?>
    	<a href="<?php echo base_url().'rooms/editRoomType/'.$roomTypeId ?>">Editar Info</a><br />
    	<a href="<?php echo base_url().'rooms/disableRoomType/'.$roomTypeId ?>" onClick="return confirm('Seguro que desea deshabilitar?')">Deshabilitar tipo de habitación</a><br />
	<?php
	
	} else if ($row['disable'] == 0) {
	?>	
		<a href="<?php echo base_url().'rooms/enableRoomType/'.$roomTypeId ?>" onClick="return confirm('Seguro que desea habilitar?')">Habilitar tipo de habitación</a><br />
    <?php
	}
}

?>
<p>
<?php 
echo 'Total habitaciones tipo '.$roomTypeName.': ', $roomTypeRoomCount."<br>";
echo 'Total habitaciones en funcionamiento: ', $roomTypeRoomCountRunning."<br>";
echo 'Total habitaciones fuera de servicio: ', $roomTypeRoomCountOos."<br><br>";
echo 'RESERVACIONES';
?>
</p>

<?php 
if ($roomTypeReservations) { ?>

  <table width="831" border="1">
    <tr>
      <td width="102">
    	<?php
		echo '# Confirmación';
        echo form_open(base_url().'rooms/infoRoomType/'.$roomTypeId);
		echo form_hidden('order', 'RE.id_reservation');
		echo form_submit('sumit', '^');
        echo form_close();
		?>    </td>
     <td width="85">
    	<?php
		echo '# Habitación';
        echo form_open(base_url().'rooms/infoRoomType/'.$roomTypeId);
		echo form_hidden('order', 'RO.number');
		echo form_submit('sumit', '^');
        echo form_close();
		?>    </td>
    <td width="98">
    	<?php
		echo 'Check-In';
        echo form_open(base_url().'rooms/infoRoomType/'.$roomTypeId);
		echo form_hidden('order', 'RE.checkIn DESC');
		echo form_submit('sumit', '^');
        echo form_close();
		?>    </td>
    <td width="101">
    	<?php
		echo 'Check-Out';
        echo form_open(base_url().'rooms/infoRoomType/'.$roomTypeId);
		echo form_hidden('order', 'RE.checkOut DESC');
		echo form_submit('sumit', '^');
        echo form_close();
		?>    </td>
    <td width="167">
    	<?php
		echo 'Nombre Cliente';
        echo form_open(base_url().'rooms/infoRoomType/'.$roomTypeId);
		echo form_hidden('order', 'G.lastName');
		echo form_submit('sumit', '^');
        echo form_close();
		?>    </td>
    <td width="89">
    	<?php
		echo 'Estado';
        echo form_open(base_url().'rooms/infoRoomType/'.$roomTypeId);
		echo form_hidden('order', 'RE.status');
		echo form_submit('sumit', '^');
        echo form_close();
		?>    </td>
    <td width="54">Adultos</td>
    <td width="41">Niños</td>
    <td width="36">Pago</td>
  </tr>
 
 <?php 
 foreach ($roomTypeReservations as $row) { ?>
  <tr>
    <td><?php echo anchor(base_url().'reservations/infoReservation/'.$row['id_reservation'],$row['id_reservation']);?></td>
    <td><?php echo anchor(base_url().'rooms/infoRoom/'.$row['id_room'],$row['number']);?></td>
    <td>
	<?php 
		$checkIn       = $row['checkIn'];
		$checkIn_array = explode (' ',$checkIn);
		$date          = $checkIn_array[0];
		$date_array    = explode ('-',$date);
		$year          = $date_array[0];
		$month         = $date_array[1];
		$day           = $date_array[2];
		echo $day.'-'.$month.'-'.$year;
	?>
    </td>
    <td>
	<?php 
		$checkOut       = $row['checkOut'];
		$checkOut_array = explode (' ',$checkOut);
		$date           = $checkOut_array[0];
		$date_array     = explode ('-',$date);
		$year           = $date_array[0];
		$month          = $date_array[1];
		$day            = $date_array[2];
		echo $day.'-'.$month.'-'.$year;
	?>
    </td>
    <td>
	<?php echo anchor(base_url().'guests/infoGuestReservations/'.$row['fk_guest'],$row['lastName'].', '.$row['name']);
	?>    
    </td>
    <td><?php echo lang($row['restatus']);?></td>
    <td><?php echo $row['adults'];?></td>
    <td><?php echo $row['children'];?></td>
    <td>&nbsp;</td>
  </tr>
  <?php
  }
  ?>
</table>
<?php
 
} else {

	echo 'No existen reservaciones en este tipo de habitación!';
}
?>

<br /><br /><a href="<?php echo base_url().'rooms/viewRoomTypes/'?>">Volver</a>