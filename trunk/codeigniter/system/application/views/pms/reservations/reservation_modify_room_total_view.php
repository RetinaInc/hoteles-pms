
<?php
$this->load->view('pms/header');
?>

<h3>Modificar Monto Habitación</h3>

<?php  
foreach ($roomReservationInfo as $row) {
	
	$reservationId = $row['id_reservation'];
	
	if ($row['id_room'] == $roomId) {
	?>
        <table width="318" border="0">
        
          <tr>
            <td width="120">Reservación</td>
            <td width="188"># 
				<?php 
                echo $row['id_reservation'];
                ?>            </td>
          </tr>
          
          <?php
          $checkIn_array = explode (' ', $row['checkIn']);
		  $ciDate        = $checkIn_array[0];
		
		  $checkOut_array = explode (' ', $row['checkOut']);
		  $coDate         = $checkOut_array[0];
		  
		  $nights = (strtotime($coDate) - strtotime($ciDate)) / (60 * 60 * 24);
		  
		  $weekDays = array('Dom', 'Lun','Mar','Mie','Jue','Vie','Sab', 'Dom');
		  
		  $checkInDate = date('l', strtotime($ciDate));
		  $checkInDay  = $weekDays[date('N', strtotime($checkInDate))];
		  $unixInDate  = human_to_unix($row['checkIn']);
		  $checkInDate = date ("j/m/Y" , $unixInDate);
		
		  $checkOutDate = date('l', strtotime($coDate));
		  $checkOutDay  = $weekDays[date('N', strtotime($checkOutDate))];
		  $unixCoDate   = human_to_unix($row['checkOut']);
		  $checkOutDate = date ("j/m/Y" , $unixCoDate);
    	  ?>
          
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>Fecha llegada:</td>
            <td>
            	<?php 
                echo $checkInDay.' '.$checkInDate;;
				?>          	</td>
          </tr>
          <tr>
            <td>Fecha salida: </td>
            <td>
            	<?php 
                echo $checkOutDay.' '.$checkOutDate;
				?>           	</td>
          </tr>
          <tr>
            <td>Noches: </td>
            <td>
				<?php
                echo $nights;
                ?>            </td>
          </tr>
          <tr>
            <td>Habitación:</td>
            <td>
				<?php 
                echo $row['number'];
				?>           	</td>
          </tr>
          
          <tr>
            <td>Tipo habitación:</td>
            <td>
				<?php 
                echo $row['abrv'];
                ?>           	</td>
          </tr>
          <tr>
            <td>Adultos:</td>
            <td>
				<?php 
                echo $row['adults'];
                ?>            </td>
          </tr>
          
          <tr>
            <td>Ni&ntilde;os:</td>
            <td>
				<?php 
                echo $row['children'];
                ?>            </td>
          </tr>
          
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>Total Habitación</td>
            <td>
				<?php 
                echo $row['total'];
                ?> 
                Bs.F.            </td>
          </tr>
        </table>
    
    	<br />
<?php
	}
}

echo form_open('reservations/modifyRoomReservationTotal/'.$reservationId.'/'.$roomId);
?>

<table width="454" border="0">
  <tr>
    <td width="122">Nuevo Monto</td>
    
    <td width="127">
        <input type="text" name="new_total" id="new_total" value="<?php echo set_value('new_total')?>" maxlength="10" size="10" 
        onKeyPress="return numbersonly(this, event)"/> Bs.F. 
    </td>
    
    <td width="191">
		<?php 
		$att = array(
			'name'        => 'submit',
    		'id'          => 'submit',
    		'onClick'     => "return confirm('Seguro que desea guardar?')"
			);
		echo form_submit($att, 'Guardar');
        ?>
    </td>
  </tr>
</table>

<?php
echo form_close();
?>
