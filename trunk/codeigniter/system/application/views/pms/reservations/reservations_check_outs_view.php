
<?php 
$this->load->view('pms/header');
?>

<h3>Check Outs Pendientes del Día</h3>

<?php

if (isset($error)) {
	
	echo "<span class='Estilo1'>".$error."</span>";
	echo "<br><br>";
}

$weekDays = array('Domingo', 'Lunes','Martes','Miercoles','Jueves','Viernes','Sabado', 'Domingo');
$dateDay  = $weekDays[date('N', strtotime($checkOutDate))];

$unixDate = human_to_unix($checkOutDate.' 00:00:00');
$date     = date ("j/m/Y" , $unixDate);
?>

<table width="538" border="0">

  <tr>
    <td width="169">
		<?php 
        echo $dateDay.' '.$date; 
        ?>
    </td>
    
    <td width="94">
    Buscar Fecha
    <span class="Estilo2">(dd - mm - yyyy)</span> 
    </td>
    
    <?php 
	$attributes = array('id' => 'checkOutDate');
	echo form_open('reservations/viewCheckOuts/date', $attributes); 
	?>
    
    <td width="88">
        <input name="check_out_date" type="text" id="check_out_date" onClick="popUpCalendar(this, checkOutDate.check_out_date, 'dd-mm-yyyy');" onKeyPress="return rifnumbers(this, event)" value="<?php echo set_value('check_out_date'); ?>" size="10" maxlength="10" />
    </td>
    
    <td width="159">
		<?php 
        echo form_submit('sumit', 'Buscar');
        ?>
    </td>
    
    <?php 
	echo form_close(); 
	?>
    
  </tr>
</table>

<br />

<?php
if ($resIds) {

	$total = count($resIds);
	echo 'Total check ins: ', $total;
	?>
    
    <br /><br />
    
	<table width="1182" border="1">
    
  	  <tr>
		<td width="80">
        	<?php
            echo anchor('reservations/viewCheckOuts/'.$checkOutDate.'/id_reservation', '#');
          	?>
		</td>
        
		<td width="250">
        	<?php
            echo anchor('reservations/viewCheckOuts/'.$checkOutDate.'/gLname', 'Cliente');
          	?>        
		</td>
        
	  	<td width="160">
    		<?php
            echo anchor('reservations/viewCheckOuts/'.$checkOutDate.'/checkIn', 'Fecha Check In');
          	?>        
  		</td>
        
		<td width="160">Fecha Check Out</td>
        
		<td width="130">Estado </td>
        
    	<td width="170">Habitación(nes)</td>
        
    	<td width="90">Pago</td>
        
    	<td width="90">Por pagar</td>
	  </tr>
	
  	  <?php 
	foreach ($resIds as $row) {
  
  		$hotel = $this->session->userdata('hotelid');
		
  		$reservationInfo = $this->REM->getReservationInfo($hotel, 'id_reservation', $row['id_reservation'], null, null, null, 1);
		
		foreach ($reservationInfo as $row1) {
			  
			$reservationRoomsCount = getRRCount($hotel, 'RR.fk_reservation', $row1['id_reservation'], null, null);
			$reservationRoomInfo   = getRRInfo($hotel, 'RR.fk_reservation', $row1['id_reservation']);
			$payments              = getPaymentInfo($hotel, null, null, $row1['id_reservation']);
		  
			$total = 0;
			foreach ($reservationRoomInfo as $row2) {
		  
				$total = $total + $row2['total'];
			}
		
			 $paid = 0;
			 foreach ($payments as $row2) {
		  
				$paid = $paid + $row2['amount'];
			}
		
			$toPay = $total - $paid;
			?>
	  
		  <tr>
			<td>
				<?php 
				echo anchor('reservations/infoReservation/'.$row1['id_reservation'].'/n/', $row1['id_reservation']);
				?>
			</td>
		
			<td>
				<?php 
				foreach ($guests as $row2) { 
			
					if ($row2['id_guest'] == $row1['fk_guest']) {
				
						if ($row2['disable'] == 1) {
					
							echo anchor('guests/infoGuestReservations/'.$row2['id_guest'], $row2['lastName'].' '.$row2['lastName2'].', '.$row2['name'].' '.$row2['name2']);
						
						} else {
					
							echo $row2['lastName'].', '.$row2['name'];
						}
					}
				}
				?>   	
			</td>
		
			<td>
				<?php
				$checkIn       = $row1['checkIn'];
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
				$checkOut       = $row1['checkOut'];
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
				echo lang($row1['status']);
				?>
			</td>
	
			<td>
				<?php 
				echo $reservationRoomsCount;
				foreach ($reservationRoomInfo as $row2) {
				
					if ($row2['fk_reservation'] == $row1['id_reservation']) {
					
						echo '('.$row2['number'].')';
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
	
	<br>
    
	<?php
	
	echo $this->pagination->create_links();
	
} else {

	echo "<br><br>";
	echo 'No existen check outs pendientes!';
}

?>
