
<?php
$this->load->view('pms/header'); 
?>

<h3>Informaci�n Reservaci�n</h3>

<?php 
$weekDays = array('Dom', 'Lun','Mar','Mie','Jue','Vie','Sab', 'Dom');

if (isset($message)) {
	
	echo "<strong>".$message."</strong>";
	echo "<br><br>";
}
	
if (isset($reservation)) {

	foreach ($reservation as $row) {
	
		$reservationId = $row['id_reservation'];
		$resDate	   = $row['resDate'];
		$status        = $row['status'];
		$payStatus     = $row['paymentStat'];
		$checkIn       = $row['checkIn'];
		$checkOut      = $row['checkOut'];
		$guestId       = $row['fk_guest'];
		
		$rD_array  = explode (' ',$resDate);
		$rDate     = $rD_array[0];
	
		$reservDate  = date('l', strtotime($rDate));
        $reservDay   = $weekDays[date('N', strtotime($reservDate))];
        $unixResDate = human_to_unix($resDate);
        $reservDate  = date ("j/m/Y" , $unixResDate);
				
		echo 'Reservaci�n #'.$reservationId."<br>";
		echo 'Estado: ', lang($row['status'])."<br>";
		echo 'Fecha Reservaci�n: ', $reservDay.' '.$reservDate."<br><br>";
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
		
			echo 'Tel�fono: '.$row['telephone']."<br>";
	 
			if ($row['email'] != NULL) {
				echo 'Correo: '.$row['email']."<br>";
			}
		
		} else {
		
			echo 'Nombre: '.$row['lastName'].' '.$row['lastName2'].', '.$row['name'].' '.$row['name2']."<br>";
		}
	}
	
	echo "<br>".'INFORMACI�N RESERVACI�N'."<br><br>";
	
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
	
	  	  ?>
        
	  	  <tr>
			<td width="220">
				<?php 
                echo 'Tarifa ', $row['ratename']; 
                ?>
       	 	</td>
        
			<td width="220">
				<?php 
                $checkInDate = date('l', strtotime($ciDate));
                $checkInDay  = $weekDays[date('N', strtotime($checkInDate))];
                $unixInDate  = human_to_unix($row['checkIn']);
                $checkInDate = date ("j/m/Y" , $unixInDate);
                echo 'Llegada: ', $checkInDay.' '.$checkInDate;
                ?>
			</td>
        
			<td width="220">
				<?php 
                echo 'Cant. noches: ', $nights; 
                ?>
        	</td>
        
			<td width="220">
				<?php 
                echo 'Total a pagar: ', $total.' Bs.F.'; 
                ?>
        	</td>
	  	  </tr>
      
		  <tr>
			<td>
				<?php 
                echo 'Plan ', $row['planname']; 
                ?>
        	</td>
        
			<td>
				<?php 
                $checkOutDate = date('l', strtotime($coDate));
                $checkOutDay  = $weekDays[date('N', strtotime($checkOutDate))];
                $unixCoDate   = human_to_unix($row['checkOut']);
                $checkOutDate = date ("j/m/Y" , $unixCoDate);
                echo 'Salida: ', $checkOutDay.' '.$checkOutDate;
                ?>
			</td>
        
			<td>
				<?php 
                echo 'Cant. habitaciones: ', $reservationRoomCount; 
                ?>
        	</td>
        
			<td>
				<?php 
                echo 'Total pagado: ', $paid.' Bs.F.'; 
                ?>
        	</td>
      	  </tr>
	  <?php
	  }
	  ?>
	</table>
	
	<br />
	
	INFORMACI�N HABITACI�N(ES)
    
    <br /><br />
    
	<table width="937" border="0">
    
	  <tr>
		<td width="73">#</td>
        
		<td width="73">Tipo</td>
        
		<td width="73">Adultos</td>
        
		<td width="73">Ni�os</td>
        
		<?php 
		if ($children == 'Yes') {
			?>
            <td width="73">Edad</td>
			<?php
		}
			
		if ($reservationRoomCount > 1) {
			?>
			<td width="229">Cliente</td>
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
			<td height="41">
				<?php 
                echo $row['number'];
                ?>
        	</td>
        
			<td>
				<?php 
                echo $row['abrv'];
                ?>
        	</td>
        
			<td>
				<?php 
                echo $row['adults'];
                ?>
        	</td>
        
			<td>
				<?php 
                echo $row['children'];
                ?>
        	</td>
        
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
                    ?>
            	</td>
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
                    			echo anchor('reservations/modifyRoomReservationOtherGuest/'.$reservationId.'/'.$row1['id_other_guest'],'Cambiar')."<br><br>";
							}
                        }
                    }
                    ?>
				</td>
				<?php
			}
			?>
	 
			<td>
				<?php 
                echo $row['total'];
                ?> 
                Bs.F.
        	</td>
        	
			<?php 
			if (($date <= $ciDate)&& ($status != 'Canceled')) {
				?>
        		<td>
					<?php
                    echo anchor('reservations/modifyReservationRooms/'.$reservationId.'/'.$row['id_room'],'Cambiar Habitaci�n');
                    ?>
            	</td>
				<?php
			} 	
		 
			if (($date <= $coDate)&& ($status != 'Canceled')) {
				?>
            	<td id="modT">
					<?php
                    echo anchor('reservations/modifyRoomReservationTotal/'.$reservationId.'/'.$row['id_room'],'Modificar Monto');
                    ?>
            	</td>
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
	  if ($paid != 0) {
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
	  
	  if ($payStatus != 'Paid') {
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
	  ?>
		<tr>
			<td>
				<?php
				if($amountToPay == 0) {
				
                	echo anchor('reservations/checkOutReservation/'.$reservationId, 'Check Out', array('onClick' => "return confirm('Realizar Check Out?')"));
					
				} else {
					
					echo anchor('reservations/checkOutReservation/'.$reservationId, 'Check Out', array('onClick' => "return confirm('Seguro que desea realizar Check Out? Todav�a no se han registrado todos los Pagos!')"));
				}
                ?>
            </td>
		</tr>
	  <?php
	  }
	  
	  if (($date < $ciDate)&& ($status != 'Canceled')) {
	  ?>
		<tr>
			<td>
				<?php
                echo anchor('reservations/cancelReservation/'.$reservationId.'/'.$guestId, 'Cancelar Reservaci�n', array('onClick' => "return confirm('Seguro que desea cancelar?')"));
                ?>
           </td>
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
	
} else {

	echo 'No existe ese n�mero de reservaci�n';
	echo "<br><br>";
}

echo anchor ('reservations/viewPendingReservations', 'Volver a reservaciones');

?>

