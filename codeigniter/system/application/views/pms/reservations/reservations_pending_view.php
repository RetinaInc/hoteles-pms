
<?php 
$this->load->view('pms/header');
?>

<h3>Reservaciones Pendientes</h3>

<?php

$attributes = array('id' => 'form_search');
echo form_open('reservations/searchReservation', $attributes);

$data = array(
       'name' => 'search',
       'id'   => 'search',
	   'onKeyPress'   => "return numbersonly(this, event)"
       );
echo form_input($data);

echo form_submit('sumit', 'Buscar Reservación');
echo form_close();

$create = 'No';

if (($exRooms) && ($exSeasons) &&($exRates) && ($exPlans)) {

	$create = 'Yes';
	
} else {

	echo 'Deden existir habitaciones, tamporadas, tarifas y planes para poder hacer una reservación!';
	echo "<br>";
}

?>
<table width="1272" border="0">
  <tr>
  
  	<?php
	if ($create == 'Yes') {

		?>
        <td width="250">
	        <?php
			echo anchor('reservations/createReservation1/','Crear Nueva Reservación');
			?>       	</td>
<?php
	}
	
	if ($prevReservations) {

		?>
        <td width="250">
	        <?php
			echo anchor('reservations/viewPreviousReservations/','Ver Reservaciones Anteriores');
			?>       	</td>
<?php
	}
	
	if ($canReservations) {

		?>
        <td width="250">
	        <?php
			echo anchor('reservations/viewCanceledReservations/','Ver Reservaciones Canceladas');
			?>       	</td>
<?php
	}
	
	if ($noShows) {

		?>
        <td width="250">
	        <?php
			echo anchor('reservations/viewNoShows/','Ver Reservaciones Olvidadas');
			?>      	</td>
<?php
	}
	
	if (($prevReservations) || ($canReservations) || ($noShows)) {

		?>
        <td width="250">
	        <?php
			echo anchor('reservations/viewAllReservations/','Ver Todas');
			?>      	</td>
   	<?php
	}
	?>
  </tr>
</table>

<?php
/*
foreach ($penReservations as $row) {
  
  	$pen = 'No';
	
	if (($row['status'] != 'Checked In') && ($row['status'] != 'Canceled')) {
		
		$pen = 'Yes';
	}
}
*/

$total = count($penReservations);
echo "<br>";
echo 'Total reservaciones pendientes: ', $total;

if ($penReservations) {
?>
	<br /><br />
    
	<table width="1182" border="1">
    
  	  <tr>
		<td width="80">
			<?php
			echo anchor('reservations/viewPendingReservations/id_reservation', '#');
            ?>        
		</td>
        
  		<td width="250">
        	<?php
			echo anchor('reservations/viewPendingReservations/gLname', 'Cliente');
            ?>        
     	</td>
        
	  	<td width="160">
			<?php
			echo anchor('reservations/viewPendingReservations/checkIn', 'Fecha Check In');
            ?>        
       	</td>
        
  		<td width="160">
			<?php
			echo anchor('reservations/viewPendingReservations/checkOut', 'Fecha Check Out');
            ?>      
       	</td>
        
		<td width="130">
			<?php
			echo anchor('reservations/viewPendingReservations/status', 'Estado');
            ?>        
       	</td>
        
    	<td width="170">Habitación(nes)</td>
        
    	<td width="90">Pago</td>
        
    	<td width="90">Por pagar</td>
	  </tr>
	
  	  <?php 
  	  foreach ($penReservations as $row) {
  
  	  	  if (($row['status'] != 'Checked In') && ($row['status'] != 'Canceled')) {
		  
			  $hotel = $this->session->userdata('hotelid');
			  
			  $reservationRoomsCount = getRRCount($hotel, 'RR.fk_reservation', $row['id_reservation'], null, null);
			  $reservationRoomInfo   = getRRInfo($hotel, 'RR.fk_reservation', $row['id_reservation']);
			  $payments              = getPaymentInfo($hotel, null, null, $row['id_reservation']);
			  
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
   		<td>
			<?php 
            echo anchor('reservations/infoReservation/'.$row['id_reservation'].'/n/', $row['id_reservation']);
            ?>
        </td>
    	
        <td>
    		<?php 
			foreach ($guests as $row1) { 
		
				if ($row1['id_guest'] == $row['fk_guest']) {
			
					if ($row1['disable'] == 1) {
				
						echo anchor('guests/infoGuestReservations/'.$row1['id_guest'], $row1['lastName'].' '.$row1['lastName2'].', '.$row1['name'].' '.$row1['name2']);
					
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
    
    	<td>
			<?php 
            echo lang($row['status']);
            ?>
        </td>
    
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
        
    	<td>
			<?php 
            echo $paid; 
            ?> 
            Bs.F.
        </td>
        
    	<td>
			<?php 
            echo $toPay; 
            ?> 
            Bs.F.
        </td>
        
  	  </tr>
  	  <?php
  	  	}
	  }
  	  ?>
	</table>

<br />

<?php

echo $this->pagination->create_links();

} else {

	echo "<br><br>";
	echo 'No existen reservaciones pendientes!'."<br>";
}
?>
