
<?php 
$this->load->view('pms/header'); 
?>

<h3>Información Habitación</h3>

<?php
foreach ($room as $row) {

	$roomId     = $row['id_room'];
	$roomNumber = $row['number'];
}


foreach ($room as $row) {

	echo 'Número: ', $row['number']."<br>";
	
	if ($row['name'] != NULL) {
	
		echo 'Nombre: ', $row['name']."<br>";
	}
	
	echo 'Estado: ', lang($row['status'])."<br>";
	
	echo 'Tipo de habitación: ', $row['rtabrv']."<br>";
	
	if ($row['rtdescription'] != NULL) {
	
		echo 'Detalles tipo de habitación: ',$row['rtdescription']."<br>";
	}
	
	echo "<br>";
	
	if ($row['disable'] == 1) {
	
	    echo anchor('rooms/editRoom/'.$roomId,'Editar Info')."<br>";
		echo anchor('rooms/disableRoom/'.$roomId, 'Deshabilitar Habitación', array('onClick' => "return confirm('Seguro que desea deshabilitar?')"))."<br><br>";
	
	} else if ($row['disable'] == 0){
		
		echo anchor('rooms/enableRoom/'.$roomId, 'Habilitar Habitación', array('onClick' => "return confirm('Seguro que desea habilitar?')"))."<br><br>"; 
	}
}

if ($roomReservations) {

	echo 'RESERVACIONES'."<br><br>";
	?>
	<table width="892" border="1">
   	  <tr>
    	<td width="110">
    		<?php
			echo anchor('rooms/infoRoom/'.$roomId.'/id_reservation', '# Confirmación');
			?>    	</td>
        
   	  <td width="115">
    		<?php
			echo anchor('rooms/infoRoom/'.$roomId.'/checkIn', 'Fecha Check In');
			?>    	</td>
        
  <td width="110">
			<?php
			echo anchor('rooms/infoRoom/'.$roomId.'/checkOut', 'Fecha Check Out');
			?>   	 	</td>
        
  <td width="200">
            <?php
			echo anchor('rooms/infoRoom/'.$roomId.'/lastName', 'Cliente');
			?>        </td>
        
  <td width="105">
            <?php
			echo anchor('rooms/infoRoom/'.$roomId.'/restatus', 'Estado');
			?>        </td>
        
        <td width="60">Adultos</td>
        
        <td width="60">Niños</td>
        
        <td width="80">Pago</td>
  	  </tr>
 
	  <?php 
      foreach ($roomReservations as $row) { ?>
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
			echo anchor('guests/infoGuestReservations/'.$row['fk_guest'], $row['lastName'].', '.$row['name']);
			?>
        </td>
        
        <td>
			<?php 
            echo lang($row['restatus']);
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
        
        <td>&nbsp;</td>
        
      </tr>
      <?php
      }
      ?>
	</table>
    
	<br />
    
	<?php 
    
    echo $this->pagination->create_links();
    echo "<br><br>";

} else {

	echo 'No existen reservaciones en esta habitación!';
	echo "<br><br>";
}

echo anchor ('rooms/viewRooms', 'Volver a habitaciones');

?>


