
<?php 
$this->load->view('pms/header');
?>

<h3>Reservaciones Anteriores</h3>

<?php
$total = count($reservations);
echo 'Total reservaciones anteriores: ', $total;
?>

<br /><br />

<table width="1182" border="1">
  <tr>
	<td width="80">
		<?php
        echo anchor('reservations/viewPreviousReservations/id_reservation', '#');
        ?>    
    </td>
    
    <td width="250">
        <?php
        echo anchor('reservations/viewPreviousReservations/gLname', 'Cliente');
        ?>    
   	</td>
    
	<td width="160">
        <?php
        echo anchor('reservations/viewPreviousReservations/checkIn', 'Fecha Check In');
        ?>    
   	</td>
    
	<td width="160">
        <?php
        echo anchor('reservations/viewPreviousReservations/checkOut', 'Fecha Check Out');
        ?>    
   	</td>
    
	<td width="130">
        <?php
        echo anchor('reservations/viewPreviousReservations/status', 'Estado');
        ?>    
  	</td>
    
    <td width="170">Habitación(nes)</td>
    
    <td width="90">Pago</td>
    
    <td width="90">Por pagar</td>
  </tr>
	
  <?php 
  foreach ($reservations as $row) {
  
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
    
                    echo anchor('guests/infoGuestReservations/'.$row1['id_guest'], $row1['lastName'].', '.$row1['name']);
                
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
  ?>
</table>

<br />

<?php

echo $this->pagination->create_links();

echo "<br><br>";
echo anchor('reservations/viewPendingReservations', 'Volver');

?>
