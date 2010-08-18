
<?php 
$this->load->view('pms/header');
?>

<h3>Reservaciones Pendientes</h3>

<?php
if ($exRooms) {

	echo anchor(base_url().'reservations/createReservation1/','Crear Nueva Reservación')."<br><br>";
}

if ($allReservations) {

	echo anchor(base_url().'reservations/viewAllReservations/','Ver Todas')."<br><br>";
	?>

	<table width="852" border="1">
  	  <tr>
		<td width="101">
    	<?php
		echo '# Confirmación';
        echo form_open(base_url().'reservations/viewPendingReservations');
		echo form_hidden('order', 'id_reservation');
		echo form_submit('sumit', '^');
        echo form_close();
		?>  	
    </td>
        
		<td width="187">
        <?php
		echo 'Nombre Cliente ';
        echo form_open(base_url().'reservations/viewPendingReservations');
		echo form_hidden('order', 'gLname');
		echo form_submit('sumit', '^');
        echo form_close();
		?>   	
    </td>
        
		<td width="110">
    	<?php
		echo 'Fecha Check-In';
        echo form_open(base_url().'reservations/viewPendingReservations');
		echo form_hidden('order', 'checkIn');
		echo form_submit('sumit', '^');
        echo form_close();
		?>  	
    </td>
        
		<td width="119">
    	<?php
		echo 'Fecha Check-Out';
        echo form_open(base_url().'reservations/viewPendingReservations');
		echo form_hidden('order', 'checkOut');
		echo form_submit('sumit', '^');
        echo form_close();
		?> 	
    </td>
        
		<td width="150">
    	<?php
		echo 'Estado';
        echo form_open(base_url().'reservations/viewPendingReservations');
		echo form_hidden('order', 'status');
		echo form_submit('sumit', '^');
        echo form_close();
		?>   	
    </td>
        
    	<td width="59">Habitación(nes)</td>
    	<td width="37">Pago</td>
    	<td width="37">Debe</td>
	  </tr>
	
  	  <?php 
  	  foreach ($reservations as $row) {
  
  	  $hotel = $this->session->userdata('hotelid');
  	  $reservationRoomsCount = getRRCount($hotel, 'RR.fk_reservation', $row['id_reservation'], null, null);
  	  ?>
  <tr>
   	<td><?php echo anchor(base_url().'reservations/infoReservation/'.$row['id_reservation'],$row['id_reservation']);?></td>
    	
        <td>
    	<?php 
		foreach ($guests as $row1) { 
	
	    	if ($row1['id_guest'] == $row['fk_guest']) {
		
		   		if ($row1['disable'] == 1) {
			
			    	echo anchor(base_url().'guests/infoGuestReservations/'.$row1['id_guest'],$row1['lastName'].', '.$row1['name']);
				
				} else {
			
			    	echo $row1['lastName'].', '.$row1['name'];
		   		}
	    	}
   		}
		?>
   	</td>
        
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
    
    	<td><?php echo lang($row['status']);?></td>
    
    	<td>
    	<?php 
		echo $reservationRoomsCount;
	
    	foreach($rooms as $row1) {
	
			if ($row1['id_reservation'] == $row['id_reservation']) {
		
				echo ' ('.$row1 ['number'].')';
			}
		}
		?>
	</td>
        
    	<td>&nbsp;</td>
    	<td>&nbsp;</td>
  	  </tr>
  	  <?php
  	  }
  	  ?>
</table>

<?php
} else {

	echo "<br><br>".'No existen reservaciones!';
}
?>
