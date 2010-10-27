
<?php 
$this->load->view('pms/header'); 
?>

<h3>Reservaciones</h3>

<?php
foreach ($roomType as $row) {

	$roomTypeId   = $row['id_room_type'];
	$roomTypeName = $row['name'];
}

echo 'Reservaciones habitaciones tipo "'.$roomTypeName.'"';          
echo "<br><br>";

if ($roomTypeReservations) { ?>

	<table width="1088" border="1">
      <tr>
    
		<td width="110">
			<?php
            echo anchor('rooms/roomTypeReservations/'.$roomTypeId.'/id_reservation', '# Confirmación');
            ?>     
 		</td>
        
     	<td width="110">
			<?php
            echo anchor('rooms/roomTypeReservations/'.$roomTypeId.'/number', '# Habitación');
            ?>    
      	</td>
    
  		<td width="115">
			<?php
            echo anchor('rooms/roomTypeReservations/'.$roomTypeId.'/checkIn', 'Fecha Check In');
            ?>    
      	</td>
    
		<td width="115">
			<?php
            echo anchor('rooms/roomTypeReservations/'.$roomTypeId.'/checkOut', 'Fecha Check Out');
            ?>    
        </td>
    
		<td width="200">
			<?php
            echo anchor('rooms/roomTypeReservations/'.$roomTypeId.'/lastName', 'Cliente');
            ?>    
        </td>
    
		<td width="180">
			<?php
            echo anchor('rooms/roomTypeReservations/'.$roomTypeId.'/restatus', 'Estado');
            ?>        
       	</td>
    
    	<td width="60">Adultos</td>
    
    	<td width="60">Niños</td>
    
    	<td width="80">Pago</td>
    
      </tr>
 
 	  <?php 
 	  foreach ($roomTypeReservations as $row) { ?>
  	  
          <tr>
            <td>
                <?php 
                echo anchor('reservations/infoReservation/'.$row['id_reservation'].'/n/', $row['id_reservation']);
                ?>
            </td>
            
            <td>
                <?php 
                echo anchor('rooms/infoRoom/'.$row['id_room'],$row['number']);
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
 
} else {

	echo 'No existen reservaciones en este tipo de habitación!';
}

echo "<br><br>";
echo anchor('rooms/infoRoomType/'.$roomTypeId, 'Volver');
?>
