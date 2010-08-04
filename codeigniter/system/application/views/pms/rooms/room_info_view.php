

<?php 

$this->load->view('pms/header'); 

foreach ($room as $row) {

	$roomId     = $row['id_room'];
	$roomNumber = $row['number'];
}

echo 'INFO HABITACIÓN #'.$roomNumber;?><br /><br /><?php

foreach ($room as $row) {

	echo 'Número: ', $row['number'];?><br /><?php
	
	if ($row['name'] != NULL) {
	
		echo 'Nombre: ', $row['name'];?><br /><?php
	}
	
	echo 'Estado: ', lang($row['status']);?><br /><?php
	
	echo 'Tipo de habitación: ', $row['rtabrv'];?><br /><?php
	
	if ($row['rtdescription'] != NULL) {
	
		echo 'Detalles tipo de habitación: ',$row['rtdescription'];?><br /><br /><?php
	}
}
	
	?><a href="<?php echo base_url().'rooms/editRoom/'.$roomId?>">Editar Info</a><br /><?php
	?><a href="<?php echo base_url().'rooms/deleteRoom/'.$roomId ?>" onClick="return confirm('Seguro que desea eliminar?')">Eliminar Habitación</a><br /><br />


<?php
echo 'RESERVACIONES'."<br><br>";
if ($roomReservations) {?>
<table width="900" border="1">
  <tr>
    <td width="106">
    	<?php
		echo '# Confirmación';
        echo form_open(base_url().'rooms/infoRoom/'.$roomId);
		echo form_hidden('order', 'RE.id_reservation');
		echo form_submit('sumit', '^');
        echo form_close();
		?>    
    </td>
    <td width="117">
    	<?php
		echo 'Fecha Check-In';
        echo form_open(base_url().'rooms/infoRoom/'.$roomId);
		echo form_hidden('order', 'RE.checkIn DESC');
		echo form_submit('sumit', '^');
        echo form_close();
		?>    
    </td>
    <td width="117">
    	<?php
		echo 'Fecha Check-Out';
        echo form_open(base_url().'rooms/infoRoom/'.$roomId);
		echo form_hidden('order', 'RE.checkOut DESC');
		echo form_submit('sumit', '^');
        echo form_close();
		?>    
    </td>
    <td width="194">
    	<?php
		echo 'Nombre Cliente';
        echo form_open(base_url().'rooms/infoRoom/'.$roomId);
		echo form_hidden('order', 'G.lastName');
		echo form_submit('sumit', '^');
        echo form_close();
		?>    
    </td>
    <td width="103">
    	<?php
		echo 'Estado';
        echo form_open(base_url().'rooms/infoRoom/'.$roomId);
		echo form_hidden('order', 'RE.status');
		echo form_submit('sumit', '^');
        echo form_close();
		?>    
    </td>
    <td width="60">Adultos</td>
    <td width="63">Niños</td>
    <td width="88">Pago</td>
  </tr>
 
 <?php 
 foreach ($roomReservations as $row) { ?>
  <tr>
    <td><?php echo anchor(base_url().'reservations/infoReservation/'.$row['id_reservation'],$row['id_reservation']);?></td>
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
    <td><?php echo anchor(base_url().'guests/infoGuestReservations/'.$row['fk_guest'],$row['lastName'].', '.$row['name']);?></td>
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

	echo 'No existen reservaciones en esta habitación!';
}
?>



<p><a href="<?php echo base_url().'rooms/viewRooms/'?>">Volver</a></p>