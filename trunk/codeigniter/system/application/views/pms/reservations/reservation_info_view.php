
<?php
$this->load->view('pms/header'); 
?>

<h3>Información Reservación</h3>

<?php 
$weekDays = array('Dom', 'Lun','Mar','Mie','Jue','Vie','Sab', 'Dom');

if (isset($message)) {
	
	echo "<strong>".$message."</strong>";
	echo "<br><br>";
}

if (isset($error)) {

	echo "<br><br>";
	echo "<span class='Estilo1'>".$error."</span>";
}
	
if (isset($reservation)) {

	foreach ($reservation as $row) {
	
		$reservationId = $row['id_reservation'];
		$resDate	   = $row['resDate'];
		$status        = $row['status'];
		$checkIn       = $row['checkIn'];
		$checkOut      = $row['checkOut'];
		$details       = $row['details'];
		$payStatus     = $row['paymentStat'];
		$totalFee      = $row['totalFee'];
		$guestId       = $row['fk_guest'];
		
		$rD_array  = explode (' ',$resDate);
		$rDate     = $rD_array[0];
		$rTime     = $rD_array[1];
	
		$reservDay   = date('l', strtotime($rDate));
        $reservSDay  = $weekDays[date('N', strtotime($reservDay))];
		
        $unixResDate = human_to_unix($resDate);
        $reservDate  = date ("j/m/Y h:i a" , $unixResDate);
		
		/*
		$time  = strtotime($rTime);
		$sTime = strtotime("4:30:00");
		$resTime = ($time - $sTime);
		$reservTime  = date ("H:i:s" , $resTime);
		*/
		
		echo 'Reservación #'.$reservationId."<br>";
		echo 'Estado: ', lang($row['status'])."<br>";
		echo 'Fecha Reservación: ', $reservSDay.' '.$reservDate."<br>";
		
		if ($status == 'Canceled') {
			
			$cancelDate = $row['cancelDate'];
			
			$cD_array  = explode (' ',$cancelDate);
			$cDate     = $cD_array[0];
			$cTime     = $cD_array[1];
		
			$canDay  = date('l', strtotime($cDate));
			$canSDay = $weekDays[date('N', strtotime($canDay))];
			
			$unixCanDate = human_to_unix($cancelDate);
			$canDate  = date ("j/m/Y h:i a" , $unixCanDate);
			
			echo 'Fecha Cancelación: ', $canSDay.' '.$canDate."<br>";
		}
		
		echo "<br>";
	}
	
	$datestring = "%Y-%m-%d";
	$time       = time();
	$date       = mdate($datestring, $time);
	
	$checkIn_array = explode (' ',$checkIn);
	$ciDate        = $checkIn_array[0];
	
	$checkOut_array = explode (' ',$checkOut);
	$coDate         = $checkOut_array[0];
	
	foreach ($guest as $row) {
		
		$guestName = $row['lastName'].' '.$row['lastName2'].', '.$row['name'].' '.$row['name2'];
		
		if ($row['disable'] == 1) {
		
			echo 'Cliente: ';
			echo anchor('guests/infoGuestReservations/'.$row['id_guest'], $row['lastName'].' '.$row['lastName2'].', '.$row['name'].' '.$row['name2'])."<br>";
		
			echo 'Teléfono: '.$row['telephone']."<br>";
	 
			if ($row['email'] != NULL) {
				echo 'Correo: '.$row['email']."<br>";
			}
		
		} else {
		
			echo 'Nombre: '.$row['lastName'].' '.$row['lastName2'].', '.$row['name'].' '.$row['name2']."<br>";
		}
	}
	
	echo "<br>".'INFORMACIÓN RESERVACIÓN'."<br><br>";
	
	$total    = 0;
	$paid     = 0;
	$children = 'No';
	
	if (($status == 'Canceled') || ($status == 'No Show')) {
		
		$total = $totalFee;
		
	} else {
	
		foreach ($reservationRoomInfo as $row) {
		
			$total = $total + $row['total'];
			
			if ($row['children'] != 0) {
			
				$children = 'Yes';
			}
		}
	}
	
	foreach ($payments as $row) {
	
		$paid = $paid + $row['amount'];
	}
	
	$amountToPay = $total - $paid;
	
	?>
    
	<table width="1118" border="0">
    
	  <?php
	  foreach ($reservation as $row) {
	
	  	  ?>
        
  		  <tr>
			<td width="220">
				<?php 
                echo 'Tarifa ', $row['ratename']; 
                ?>       	 	</td>
        
			<td width="260">
				<?php 
                $checkInDate = date('l', strtotime($ciDate));
                $checkInDay  = $weekDays[date('N', strtotime($checkInDate))];
                $unixInDate  = human_to_unix($row['checkIn']);
				
				if (($status == 'Checked In') || ($status == 'Checked Out')) {
					
                	$checkInDate = date ("j/m/Y H:s a" , $unixInDate);
					
				} else {	
					
					$checkInDate = date ("j/m/Y" , $unixInDate);
				}
				
                echo 'Llegada: ', $checkInDay.' '.$checkInDate;
                ?>			</td>
        
		  <td width="220">
				<?php 
                echo 'Cant. noches: ', $nights; 
                ?>        	</td>
        
	  <td colspan="2">
				<?php 
                echo 'Total a pagar: ';
				
				if (($status == 'Canceled') && ($total != 0)) {
					
					echo "<span class='Estilo3'>".$total.' Bs.F. '."</span>";
					echo "<span class='Estilo1'>".' (Recargo por cancelación tardía)'."</span><br>";
					echo anchor('reservations/modifyReservationFee/'.$reservationId, 'Modificar Monto');
					
				} else if (($status == 'No Show') && ($total != 0)) {
					
					echo "<span class='Estilo3'>".$total.' Bs.F. '."</span>";
					echo "<span class='Estilo1'>".' (Recargo por falta de presencia)'."</span><br>";
					echo anchor('reservations/modifyReservationFee/'.$reservationId, 'Modificar Monto');
					
				} else {
					
					echo $total.' Bs.F.'; 
				}
                ?>            	</td>
  	  	  </tr>
      
		  <tr>
			<td>
				<?php 
                echo 'Plan ', $row['planname']; 
                ?>          	</td>
        
			<td>
				<?php 
                $checkOutDate = date('l', strtotime($coDate));
                $checkOutDay  = $weekDays[date('N', strtotime($checkOutDate))];
                $unixCoDate   = human_to_unix($row['checkOut']);
				
				if ($status == 'Checked Out') {
					
                	$checkOutDate = date ("j/m/Y H:s a" , $unixCoDate);
					
				} else {	
					
					$checkOutDate = date ("j/m/Y" , $unixCoDate);
				}
				
                echo 'Salida: ', $checkOutDay.' '.$checkOutDate;
                ?>           	</td>
        
			<td>
				<?php 
                echo 'Cant. habitaciones: ', $reservationRoomCount; 
                ?>           	</td>
        
			<td colspan="2">
				<?php 
				if ($total != 0) {
				
                	echo 'Total pagado: ', $paid.' Bs.F.';
				} 
                ?>           	</td>
      	  </tr>
          
          <tr>
		  	<td colspan="5">&nbsp;</td>
      	   </tr>
            
          <?php
		  if ($details != NULL) {
			
			?> 
		  	<tr>
		   	 	<td colspan="5"><strong>Detalles reservación:</strong></td>
      	 	</tr>
            
		  	<tr>
		  	 	<td colspan="4">
					<?php
                    echo $details;
                    ?>           		</td>
  	  		    <td width="151">&nbsp;</td>
		  	</tr>
            <?php
		  }
			
		  ?>
          <tr>
		  	  <td colspan="5">
              	<?php
		  		echo anchor('reservations/modifyReservationDetails/'.$reservationId,'Modificar/Agregar Detalles');
		  		?>
              </td>
	  	  </tr>
          <?php	  
	  }
	  ?>
	</table>
	
<br />
	
	INFORMACIÓN HABITACIÓN(ES)
    
    <br /><br />
    
	<table width="1015" border="0">
    
	  <tr>
	    <td width="45">&nbsp;</td>
		<td width="101">#</td>
        
		<td width="73">Tipo</td>
        
		<td width="73">Adultos</td>
        
		<td width="73">Niños</td>
        
		<?php 
		if ($children == 'Yes') {
			?>
            <td width="73">Edad</td>
			<?php
		}
			
		if ($reservationRoomCount > 1) {
			?>
			<td width="230">Cliente</td>
			<?php
		}
		?>
        
		<td width="85">Total Hab</td>
        
		<td width="110"></td>
        
        <td width="110"></td>
	  </tr>
      
	  <?php
	  foreach ($reservationRoomInfo as $row) {
	  ?>
	  	<tr>
	  	  <td>
			  <?php
			  echo $row['num'].'.';
              ?>
          </td>
          
			<td height="41">
				<?php 
                echo $row['number'];
                ?>        	
           	</td>
        
			<td>
				<?php 
                echo $row['abrv'];
                ?>        	</td>
        
			<td>
				<?php 
                echo $row['adults'];
                ?>        	</td>
        
			<td>
				<?php 
                echo $row['children'];
                ?>        	</td>
        
	  		<?php
			if ($children == 'Yes') {
				?>
        		<td>
					<?php
                    foreach ($otherGuest as $row1) {
					
                        if (($row1['fk_room'] == $row['id_room']) && ($row1['age'] != NULL)) {
						
                            echo $row1['age']."&nbsp;&nbsp;";
                        }
                    }
                    ?>            	</td>
	  		<?php
     		}
		
			if ($reservationRoomCount > 1) {
			?>
				<td>
					<?php 
                    foreach ($otherGuest as $row1) {
					
                        if ($row1['fk_room'] == $row['id_room']) {
						
							if ($row1['name'] != NULL) {
								
								echo $row1['name'].' '. $row1['lastName']."<br>";
                            	echo $row1['idType'].' - '.$row1['idNum']."<br>";
								
								if ($status == 'Reserved') {
                    			
									echo anchor('reservations/modifyRoomReservationOtherGuest/'.$reservationId.'/'.$row1['id_other_guest'],'Cambiar')."<br><br>";
								}
							}
                        }
                    }
                    ?>				</td>
				<?php
			}
			?>
	 
			<td>
				<?php 
                echo $row['total'];
                ?> 
                Bs.F.        	</td>
        	
			<?php 
			if (($date <= $ciDate)&& ($status != 'Canceled')) {
				?>
        		<td>
					<?php
                    echo anchor('reservations/modifyReservationRooms/'.$reservationId.'/'.$row['id_room'],'Cambiar Habitación');
                    ?>            	</td>
				<?php
			} 	
		 
			if (($date <= $coDate)&& ($status != 'Canceled')) {
				?>
            	<td id="modT">
					<?php
                    echo anchor('reservations/modifyRoomReservationTotal/'.$reservationId.'/'.$row['id_room'],'Modificar Monto');
                    ?>            	</td>
			<?php
			} 	
			?>
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
	  
	  $opciones = 'No';
	  
	  if ($paid != 0) {
	  	
		$opciones = 'Yes';
	  	?>
	  	<tr>
			<td>
				<?php 
                echo anchor('reservations/viewReservationPayments/'.$reservationId, 'Ver Pagos');
                ?>
        	</td>
	  	</tr>
	  <?php
	  }
	  
	  if (($payStatus != 'Paid') && ($total != 0)) {
	  	
		$opciones = 'Yes';
	  	?>
	  	<tr>
			<td>
				<?php 
                echo anchor('reservations/payReservation/'.$reservationId, 'Registrar Pago');
                ?>
        	</td>
	  	</tr>
	  <?php
	  }
	  
	  if (($date == $ciDate) && ($status != 'Canceled') && ($status != 'Checked In')) {
	  	
		$opciones = 'Yes';
	  	?>
		<tr>
			<td>
				<?php
                echo anchor('reservations/checkInReservation/'.$reservationId, 'Check In', array('onClick' => "return confirm('Realizar Check In?')"));
                ?>
            </td>
		</tr>
	  <?php
	  }
	  
	  if ($status == 'Checked In') {
	  	
		$opciones = 'Yes';
	  	?>
		<tr>
			<td>
				<?php
				if($amountToPay == 0) {
				
                	echo anchor('reservations/checkOutReservation/'.$reservationId, 'Check Out', array('onClick' => "return confirm('Realizar Check Out?')"));
					
				} else {
					
					echo anchor('reservations/checkOutReservation/'.$reservationId, 'Check Out', array('onClick' => "return confirm('Seguro que desea realizar Check Out? Todavía no se han registrado todos los Pagos!')"));
				}
                ?>
            </td>
		</tr>
	  <?php
	  }
	  
	  //if (($date < $ciDate)&& ($status != 'Canceled')) {
	  if ($status == 'Reserved') {
	  	
		$opciones = 'Yes';
	  	?>
		<tr>
			<td>
				<?php
                echo anchor('reservations/cancelReservation/'.$reservationId.'/'.$guestId, 'Cancelar Reservación', array('onClick' => "return confirm('Seguro que desea cancelar?')"));
                ?>
           </td>
		</tr>
	  <?php
	  }
	 
	  if (($date <= $ciDate)&& ($status != 'Canceled')) {
	  	
		$opciones = 'Yes';
	  	?>
		<tr>
			<td><?php echo anchor(base_url().'reservations/modifyReservationDates/'.$reservationId, 'Cambiar fechas')?></td>
		</tr>
	  <?php
	  }
	  
	  if ($opciones == 'No') {
	  	
		?>
        <tr>
			<td><?php echo 'No hay opciones!';?></td>
		</tr>
        <?php
	  }
	  ?>
	</table>
	
	<br />
    
	<?php
	
} else {

	echo 'No existe ese número de reservación';
	echo "<br><br>";
}

echo anchor ('reservations/viewPendingReservations', 'Volver a reservaciones');

?>

