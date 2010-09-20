
<script type="text/javascript" src="<?php echo base_url()."assets/js/jquery-1.3.2.min.js" ?>"></script>

<?php 

$this->load->view('pms/header'); 

if ($reservation) {

	foreach ($reservation as $row) {
	
		$reservationId = $row['id_reservation'];
		$status        = $row['status'];
		$payStatus     = $row['paymentStat'];
		$checkIn       = $row['checkIn'];
		$checkOut      = $row['checkOut'];
		$guestId       = $row['fk_guest'];
	
		echo 'CHECK OUT - RESERVACIÓN #'.$reservationId."<br>";
	}
	
	$datestring = "%Y-%m-%d";
	$time       = time();
	$date       = mdate($datestring, $time);
	
	$checkIn_array = explode (' ',$checkIn);
	$ciDate        = $checkIn_array[0];
	
	$checkOut_array = explode (' ',$checkOut);
	$coDate         = $checkOut_array[0];
		
	echo "<br>".'INFORMACIÓN CLIENTE'."<br><br>";
	
	foreach ($guest as $row) {
		
		$guestName = $row['lastName'].' '.$row['lastName2'].', '.$row['name'].' '.$row['name2'];
		
		if ($row['disable'] == 1) {
		
			echo anchor(base_url().'guests/infoGuestReservations/'.$row['id_guest'],$row['lastName'].' '.$row['lastName2'].', '.$row['name'].' '.$row['name2'])."<br>";
		
			echo 'Teléfono: '.$row['telephone']."<br>";
	 
			if ($row['email'] != NULL) {
				echo 'Correo: '.$row['email']."<br>";
			}
		
		} else {
		
			echo 'Nombre: '.$row['lastName'].' '.$row['lastName2'].', '.$row['name'].' '.$row['name2']."<br>";
		}
	}
	
	echo "<br>".'INFORMACIÓN RESERVACIÓN'."<br><br>";
	
	$total = 0;
	$paid = 0;
	$children = 'No';
	
	foreach ($reservationRoomInfo as $row) {
		$total = $total + $row['total'];
		
		if ($row['children'] != 0) {
			$children = 'Yes';
		}
	}
	
	foreach ($payments as $row) {
		$paid = $paid + $row['amount'];
	}
	
	$amountToPay = $total - $paid;
	
	?>
	<table width="898" border="0">
	<?php
	foreach ($reservation as $row) {
	
		$weekDays = array('Dom', 'Lun','Mar','Mie','Jue','Vie','Sab');
		
		?>
	  <tr>
		<td width="220"><?php echo 'Tarifa ', $row['ratename']; ?></td>
		<td width="220">
		<?php 
		$checkInDate = date('l', strtotime($ciDate));
		$checkInDay  = $weekDays[date('N', strtotime($checkInDate))];
		$unixInDate  = human_to_unix($row['checkIn']);
		$checkInDate = date ("j/m/Y" , $unixInDate);
		echo 'Llegada: ', $checkInDay.' '.$checkInDate;
		?>
		</td>
		<td width="220"><?php echo 'Cant. noches: ', $nights; ?></td>
		<td width="220"><?php echo 'Total a pagar: ', $total.' Bs.F.'; ?></td>
	  </tr>
	  <tr>
		<td><?php echo 'Plan ', $row['planname']; ?></td>
		<td>
		<?php 
		$checkOutDate = date('l', strtotime($coDate));
		$checkOutDay  = $weekDays[date('N', strtotime($checkOutDate))];
		$unixCoDate   = human_to_unix($row['checkOut']);
		$checkOutDate = date ("j/m/Y" , $unixCoDate);
		echo 'Salida: ', $checkOutDay.' '.$checkOutDate;
		?>
		</td>
		<td><?php echo 'Cant. habitaciones: ', $reservationRoomsCount; ?></td>
		<td><?php echo 'Total pagado: ', $paid.' Bs.F.'; ?></td>
	  </tr>
	</table>
	<?php
	}
	?>
	
	<br />
	
	INFORMACIÓN HABITACIÓN(ES)<br /><br />
	<table width="769" border="0">
	  <tr>
		<td width="61">#</td>
		<td width="67">Tipo</td>
		<td width="75">Adultos</td>
		<td width="71">Niños</td>
		<?php 
		if ($children == 'Yes') {
			?><td width="66">Edad</td>
		<?php
		}
		if ($reservationRoomCount > 1) {
		?>
			<td width="235">Cliente</td>
		<?php
		}
		?>
		<td width="80">Total Hab</td>
		<td width="80"></td>
	  </tr>
	  <?php
	  foreach ($reservationRoomInfo as $row) {
	  ?>
	  <tr>
		<td height="41"><?php echo $row['number']?></td>
		<td><?php echo $row['abrv']?></td>
		<td><?php echo $row['adults']?></td>
		<td><?php echo $row['children'];?></td>
		<?php
		if ($children == 'Yes') {
			?><td><?php
			foreach ($otherGuest as $row1) {
				if (($row1['fk_room'] == $row['id_room']) && ($row1['age'] != NULL)) {
					echo $row1['age']."&nbsp;&nbsp;";
				}
			}
			?></td><?php
		}
		
		if ($reservationRoomCount > 1) {
		?>
			<td>
			<?php 
			foreach ($otherGuest as $row1) {
				if ($row1['fk_room'] == $row['id_room']) {
					echo $row1['name'].' '. $row1['lastName']."<br>";
					echo $row1['ci'];
				}
			}
			?>
			</td>
		<?php
		}
		?>
	 
		<td><?php echo $row['total']?> Bs.F.</td>
		<td>
		<?php 
			if (($date < $ciDate)&& ($status != 'Canceled')) {
				
				echo anchor(base_url().'reservations/modifyReservationRooms/'.$reservationId.'/'.$row['id_room'],'Cambiar');
			} 	
		?>
		</td>
	  </tr>
	  <?php
	  }
	  ?>
	</table>
	
	<br />
	
	<table width="200" border="1">
	  <tr>
		<td>Opciones</td>
	  </tr>
	  <?php
		if ($paid != 0) {
	  ?>
	  <tr>
		<td><?php echo anchor(base_url().'reservations/viewReservationPayments/'.$reservationId, 'Ver Pagos')?></td>
	  </tr>
	  <?php
	  }
	  
	  if ($payStatus != 'Paid') {
	  ?>
	  <tr>
		<td><?php echo anchor(base_url().'reservations/payReservation/'.$reservationId, 'Registrar Pago')?></td>
	  </tr>
	<?php
	  }
	  
	  if (($date == $ciDate) && ($status != 'Canceled')) {
	  ?>
		<tr>
			<td><?php echo anchor(base_url().'reservations/checkInReservation/'.$reservationId,'Check-In')?></td>
		</tr>
	  <?php
	  }
	  
	  if (($date < $ciDate)&& ($status != 'Canceled')) {
	  ?>
		<tr>
			<td><a href="<?php echo base_url().'reservations/cancelReservation/'.$reservationId.'/'.$guestId ?>" onClick="return confirm('Seguro que desea cancelar?')">Cancelar Reservación</a></td>
		</tr>
	  <?php
	  }
	 
	  if (($date <= $ciDate)&& ($status != 'Canceled')) {
	  ?>
		<tr>
			<td><?php echo anchor(base_url().'reservations/modifyReservationDates/'.$reservationId, 'Cambiar fechas')?></td>
		</tr>
	  <?php
	  }
	  ?>
	</table>
	
	<br />
	
	<?php
	$referer = $_SERVER['HTTP_REFERER'];
	echo "<a href='" . $referer . "'> Volver</a><br>";
	
} else {

	echo 'No existe ese número de reservación'."<br><br>";
	
	echo anchor ('reservations/viewPendingReservations', 'Volver');
}

?>

