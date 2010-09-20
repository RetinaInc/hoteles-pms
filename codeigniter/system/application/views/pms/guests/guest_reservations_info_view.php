
<?php 

$this->load->view('pms/header'); 

echo 'INFO CLIENTE'."<br>";

foreach ($guest as $row) {

	$guestId = $row['id_guest'];
	
	if ($row['disable'] == 1) {
	
	    echo anchor(base_url().'guests/editGuest/'.$row['id_guest'],'Editar')."<br>"; 
		?>
        <a href="<?php echo base_url().'guests/disableGuest/'.$guestId ?>" onclick="return confirm('Seguro que desea deshabilitar?')">Deshabilitar</a><br /><br />
		<?php
		
	} else if ($row['disable'] == 0){
		
		 echo anchor(base_url().'guests/enableGuest/'.$row['id_guest'],'Habilitar')."<br><br>"; 
	}
	
	echo 'Nombre: ',   $row['name'].' '.$row['lastName']."<br>";
	
	if (($row['ci'] != NULL) || ($row['ci'] != 0)) {
		echo 'CI: V-', $row['ci']."<br>";
	}
	echo 'Teléfono: ', $row['telephone']."<br>";
	
	if ($row['email'] != NULL) {
		echo 'Correo electrónico: ', $row['email']."<br>";
	}
	
	if ($row['address'] != NULL) {
		echo 'Dirección: ', $row['address']."<br>";
	}
}


echo "<br>".'RESERVACIONES CLIENTE'."<br><br>";

?>

<table width="942" border="1">
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
    <td width="100">Cant. Hab</td>
    <td width="100">Pago</td>
    <td width="100">Por pagar</td>
  </tr>
 
 <?php 
 $hotel = $this->session->userdata('hotelid');
 
 foreach ($reservations as $row) {
 
	 $reservationRoomsCount = getRRCount($hotel, 'RR.fk_reservation', $row['id_reservation'], null, null);
	 $reservationRoomInfo   = getRRInfo($hotel, 'RR.fk_reservation', $row['id_reservation']);
     $payments = getPaymentInfo($hotel, null, null, $row['id_reservation']);
		  
		  $total = 0;
		  foreach ($reservationRoomInfo as $row1) {
			$total = $total + $row1['total'];
		  }
		
		  $paid = 0;
		  foreach ($payments as $row1) {
			$paid = $paid + $row1['amount'];
		  }
		
		  $toPay = $total - $paid;
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
    <td><?php echo lang($row['status']);?></td>
    <td>
	<?php 
	echo $reservationRoomsCount;
	foreach ($reservationRoomInfo as $row1) {
		if ($row1['fk_reservation'] == $row['id_reservation']) {
			echo '('.$row1['number'].')';
		}
	}
	?>
    </td>
    <td><?php echo $paid; ?> Bs.F.</td>
    <td><?php echo $toPay; ?> Bs.F.</td>
  </tr>
  <?php
  }
  ?>
</table>

<br />
<a href="<?php echo base_url().'guests/viewGuests/'?>">Volver a Clientes</a><br />
<a href="<?php echo base_url().'reservations/viewPendingReservations/'?>">Volver a Reservaciones</a><br />
<a href="<?php echo base_url().'rooms/viewRooms/'?>">Volver a Habitaciones</a><br />
<a href="<?php echo base_url().'rooms/viewRoomTypes/'?>">Volver a Tipos de habitaciones</a><br />