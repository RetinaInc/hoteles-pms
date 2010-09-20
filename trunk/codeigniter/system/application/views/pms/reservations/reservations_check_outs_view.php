
<html>
<head>

<script language='javascript' src="<?php echo base_url() . "assets/calendario/"?>popcalendar.js"></script>

</head>

<?php 
$this->load->view('pms/header');
?>

<h3>Check Outs</h3>

<?php

$weekDays = array('Domingo', 'Lunes','Martes','Miercoles','Jueves','Viernes','Sabado');
$dateDay = $weekDays[date('N', strtotime($checkOutDate))];

$unixDate = human_to_unix($checkOutDate.' 00:00:00');
$date = date ("j/m/Y" , $unixDate);

?>

<table width="538" border="0">
  <tr>
    <td width="169"><?php echo $dateDay.' '.$date; ?></td>
    <td width="94">Buscar Fecha</td>
    <?php 
	$attributes = array('id' => 'checkOutDate');
	echo form_open('reservations/viewCheckOuts', $attributes); 
	?>
    <td width="88">
    <input name="check_out_date" type="text" id="check_out_date" onClick="popUpCalendar(this, checkOutDate.check_out_date, 'dd-mm-yyyy');" value="<?php echo set_value('check_out_date'); ?>" size="10" maxlength="10" />
    </td>
    <td width="159"><?php  echo form_submit('sumit', 'Buscar'); ?></td>
    <?php echo form_close(); ?>
  </tr>
</table>
<br />
<?php
if ($dateCheckOuts) {
?>
	<table width="1203" border="1">
  	  <tr>
		<td width="80">
    	<?php
		echo '#';
        echo form_open('reservations/viewCheckOuts');
		echo form_hidden('order', 'id_reservation');
		echo form_submit('sumit', '^');
        echo form_close();
		?>    </td>
        
		<td width="336">
        <?php
		echo 'Nombre Cliente ';
        echo form_open('reservations/viewCheckOuts');
		echo form_hidden('order', 'gLname');
		echo form_submit('sumit', '^');
        echo form_close();
		?>    </td>
        
		<td width="130">
    	<?php
		echo 'Fecha Check-In';
        echo form_open('reservations/viewCheckOuts');
		echo form_hidden('order', 'checkIn');
		echo form_submit('sumit', '^');
        echo form_close();
		?>    </td>
        
		<td width="130">
    	<?php
		echo 'Fecha Check-Out';
        echo form_open('reservations/viewCheckOuts');
		echo form_hidden('order', 'checkOut');
		echo form_submit('sumit', '^');
        echo form_close();
		?>    </td>
        
		<td width="104">
    	<?php
		echo 'Estado';
        echo form_open('reservations/viewCheckOuts');
		echo form_hidden('order', 'status');
		echo form_submit('sumit', '^');
        echo form_close();
		?>    </td>
        
    	<td width="110">Habitación(nes)</td>
    	<td width="90">Pago</td>
    	<td width="90">Por pagar</td>
        <td width="75">Check Out</td>
	  </tr>
	
  	  <?php 
  	  foreach ($dateCheckOuts as $row) {
  
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
			
			    	echo anchor(base_url().'guests/infoGuestReservations/'.$row1['id_guest'],$row1['lastName'].' '.$row1['lastName2'].', '.$row1['name'].' '.$row1['name2']);
				
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
		foreach ($reservationRoomInfo as $row1) {
			if ($row1['fk_reservation'] == $row['id_reservation']) {
				echo '('.$row1['number'].')';
			}
		}
		?>
	</td>
        
    	<td><?php echo $paid; ?> Bs.F.</td>
    	<td><?php echo $toPay; ?> Bs.F.</td>
        <td><?php echo anchor ('reservations/checkOutReservation/'.$row['id_reservation'], 'Check Out'); ?></td>
  	  </tr>
  	  <?php
  	  }
  	  ?>
</table>

<?php
} else {

	echo "<br><br>".'No existen check Outs!'."<br>";
}
?>

</html>