
<?php 

$this->load->view('pms/header');

echo 'RESERVACIONES';

?>
<br /><br />

<table width="995" border="1">
  <tr>
    <td width="45">
    	<?php
		echo '#';
        echo form_open(base_url().'reservations/viewAllReservations');
		echo form_hidden('order', 'RE.id_reservation');
		echo form_submit('sumit', '^');
        echo form_close();
		?>  	</td>
<td width="226">
        <?php
		echo 'Nombre Cliente ';
        echo form_open(base_url().'reservations/viewAllReservations');
		echo form_hidden('order', 'G.lastName');
		echo form_submit('sumit', '^');
        echo form_close();
		?>   	</td>
<td width="104">
    	<?php
		echo 'Fecha Check-In';
        echo form_open(base_url().'reservations/viewAllReservations');
		echo form_hidden('order', 'RE.checkIn DESC');
		echo form_submit('sumit', '^');
        echo form_close();
		?>  	</td>
  <td width="112">
    	<?php
		echo 'Fecha Check-Out';
        echo form_open(base_url().'reservations/viewAllReservations');
		echo form_hidden('order', 'RE.checkOut DESC');
		echo form_submit('sumit', '^');
        echo form_close();
		?> 	</td>
  <td width="141">
    	<?php
		echo 'Estado';
        echo form_open(base_url().'reservations/viewAllReservations');
		echo form_hidden('order', 'RE.status');
		echo form_submit('sumit', '^');
        echo form_close();
		?>   	</td>
    <td width="115">Habitación(nes)</td>
    <td width="100">Pago</td>
    <td width="100">Por pagar</td>
  </tr>
	
  <?php 
  foreach ($reservations as $row) {
  
	  $hotel = $this->session->userdata('hotelid');
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
	foreach ($guests as $row1) {
		
	    if ($row1['id_guest'] == $row['fk_guest']) {
		
		    if ($row1['disable'] == 1) {

			    echo anchor(base_url().'guests/infoGuestReservations/'.$row1['id_guest'],$row1['lastName'].', '.$row1['name']);
			
			} else {
					
					echo $row1['lastName'].', '.$row1['name'];
			}
		}
	}?>
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
    <td><?php echo $paid; ?> Bs.F.</td>
    <td><?php echo $toPay;?> Bs.F.</td>
  </tr>
  <?php
  }
  ?>
</table>

<p><a href="<?php echo base_url().'reservations/viewPendingReservations'?>">Volver</a></p>
