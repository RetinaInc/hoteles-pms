
<?php 

$this->load->view('pms/header'); 

echo 'INFO CLIENTE'."<br>";

foreach ($guest as $row) {

	$guestId = $row['id_guest'];
	
	echo anchor(base_url().'guests/editGuest/'.$row['id_guest'],'Editar')."<br><br>"; 
	
	echo 'Nombre: ',   $row['name'].', '.$row['lastName']."<br>";
	echo 'Teléfono: ', $row['telephone']."<br>";
	
	if ($row['email'] != NULL) {
		echo 'Correo electrónico: ', $row['email']."<br>";
	}
	
	if ($row['address'] != NULL) {
		echo 'Dirección: ', $row['address']."<br><br>";
	}
}


echo 'RESERVACIONES CLIENTE'."<br><br>";

?>

<table width="800" border="1">
  <tr>
    <td width="123">
    	<?php
		echo '# Confirmación';
        echo form_open(base_url().'guests/infoGuestReservations/'.$guestId);
		echo form_hidden('order', 'id_reservation');
		echo form_submit('sumit', '^');
        echo form_close();
		?>    </td>
  	<td width="135">
    	<?php
		echo 'Fecha Check-In';
        echo form_open(base_url().'guests/infoGuestReservations/'.$guestId);
		echo form_hidden('order', 'checkIn DESC');
		echo form_submit('sumit', '^');
        echo form_close();
		?>    </td>
  	<td width="135">
   	 	<?php
		echo 'Fecha Check-Out';
        echo form_open(base_url().'guests/infoGuestReservations/'.$guestId);
		echo form_hidden('order', 'checkOut DESC');
		echo form_submit('sumit', '^');
        echo form_close();
		?>    </td>
  	<td width="203">
   	 	<?php
		echo 'Estado';
        echo form_open(base_url().'guests/infoGuestReservations/'.$guestId);
		echo form_hidden('order', 'status');
		echo form_submit('sumit', '^');
        echo form_close();
		?>    </td>
    <td width="68">Cant. Hab</td>
    <td width="43">Pago</td>
    <td width="47">Debe</td>
  </tr>
 
 <?php 
 foreach ($reservations as $row) {
 
     $reservationRooms = getCount('ROOM_RESERVATION', 'fk_reservation', $row['id_reservation'], null, null, null);
  ?>
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
	?>    </td>
    <td><?php echo $row['status'];?></td>
    <td><?php echo $reservationRooms;?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <?php
  }
  ?>
</table>

<p><a href="<?php echo base_url().'guests/viewGuests/'?>">Volver a Clientes</a></p>
<p><a href="<?php echo base_url().'reservations/viewPendingReservations/'?>">Volver a Reservaciones</a></p>
<p><a href="<?php echo base_url().'rooms/viewRooms/'?>">Volver a Habitaciones</a></p>
<p><a href="<?php echo base_url().'rooms/viewRoomTypes/'?>">Volver a Tipos de habitaciones</a></p>