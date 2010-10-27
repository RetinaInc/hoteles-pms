
<?php 
$this->load->view('pms/header'); 
?>

<h3>Información Cliente</h3>

<?php
foreach ($guest as $row) {

	$guestId = $row['id_guest'];
	
	if ($row['disable'] == 1) {
	
	    echo anchor('guests/editGuest/'.$row['id_guest'],'Editar')."<br>";
		echo anchor('guests/disableGuest/'.$guestId, 'Deshabilitar', array('onClick' => "return confirm('Seguro que desea deshabilitar?')"));  
		echo "<br><br>";
		
	} else if ($row['disable'] == 0){
		
		 echo anchor('guests/enableGuest/'.$row['id_guest'],'Habilitar', array('onClick' => "return confirm('Seguro que desea habilitar?')")); 
		 echo "<br><br>";
	}
	
	echo 'Nombre: ',   $row['name'].' '.$row['name2'].' '.$row['lastName'].' '.$row['lastName2']."<br>";
	
	if (($row['idNum'] != NULL) || ($row['idNum'] != 0)) {
	
		echo 'Id: ', $row['idType'].'-'.$row['idNum']."<br>";
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

<table width="956" border="1">
  <tr>
  
    <td width="110">
    	<?php
		echo anchor('guests/infoGuestReservations/'.$guestId.'/id_reservation', '# Reservación');
        ?>  
  	</td>
        
  	<td width="160">
    	<?php
		echo anchor('guests/infoGuestReservations/'.$guestId.'/checkIn', 'Fecha Check In');
        ?> 
	</td>
	
    <td width="160">
   	 	<?php
		echo anchor('guests/infoGuestReservations/'.$guestId.'/checkOut', 'Fecha Check Out');
        ?>    
 	</td>

	<td width="130">
   	 	<?php
		echo anchor('guests/infoGuestReservations/'.$guestId.'/status', 'Estado');
        ?>	
   	</td>
    
    <td width="170">Cant. Hab</td>
    
    <td width="90">Pago</td>
    
    <td width="90">Por pagar</td>
    
  </tr>
 
  <?php 
  $hotel = $this->session->userdata('hotelid');
 
  foreach ($reservations as $row) {
  	
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
            foreach ($reservationRoomInfo as $row1) {
			
                if ($row1['fk_reservation'] == $row['id_reservation']) {
				
                    echo '('.$row1['number'].')';
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
echo anchor('guests/viewGuests/', 'Volver a Clientes');
?>







