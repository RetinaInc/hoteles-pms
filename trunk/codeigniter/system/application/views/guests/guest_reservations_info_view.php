
<?php 

$this->load->view('pms/header'); 

echo 'INFO CLIENTE'."<br>";

foreach ($guest as $row)
{
	$guest_id = $row['ID_GUEST'];
	
	echo anchor(base_url().'guests/editGuest/'.$row['ID_GUEST'],'Editar')."<br><br>"; 
	
	echo 'Nombre: ', $row['NAME'].', '.$row['LAST_NAME']."<br>";
	echo 'Teléfono: ', $row['TELEPHONE']."<br>";
	
	if ($row['EMAIL'] != NULL)
	{
		echo 'Correo electrónico: ', $row['EMAIL']."<br>";
	}
	
	if ($row['ADDRESS'] != NULL)
	{
		echo 'Dirección: ', $row['ADDRESS']."<br><br>";
	}
}


echo 'RESERVACIONES CLIENTE'."<br><br>";

?>

<table width="800" border="1">
  <tr>
    <td width="123">
    	<?php
		echo '# Confirmación';
        echo form_open(base_url().'guests/infoGuestReservations/'.$guest_id);
		echo form_hidden('order', 'ID_RESERVATION');
		echo form_submit('sumit', '^');
        echo form_close();
		?>    </td>
  <td width="135">
    	<?php
		echo 'Fecha Check-In';
        echo form_open(base_url().'guests/infoGuestReservations/'.$guest_id);
		echo form_hidden('order', 'CHECK_IN DESC');
		echo form_submit('sumit', '^');
        echo form_close();
		?>    </td>
  <td width="135">
   	 	<?php
		echo 'Fecha Check-Out';
        echo form_open(base_url().'guests/infoGuestReservations/'.$guest_id);
		echo form_hidden('order', 'CHECK_OUT DESC');
		echo form_submit('sumit', '^');
        echo form_close();
		?>    </td>
  <td width="203">
   	 	<?php
		echo 'Estado';
        echo form_open(base_url().'guests/infoGuestReservations/'.$guest_id);
		echo form_hidden('order', 'STATUS');
		echo form_submit('sumit', '^');
        echo form_close();
		?>    </td>
    <td width="68">Cant. Hab</td>
    <td width="43">Pago</td>
    <td width="47">Debe</td>
  </tr>
 
 <?php 
 foreach ($reservations as $row)
 {$reservation_rooms = get_count('ROOM_RESERVATION', 'FK_ID_RESERVATION', $row['ID_RESERVATION'], null, null);
 ?>
  <tr>
    <td><?php echo anchor(base_url().'reservations/infoReservation/'.$row['ID_RESERVATION'],$row['ID_RESERVATION']);?></td>
    <td>
	<?php 
		$check_in = $row['CHECK_IN'];
		$check_in_array = explode (' ',$check_in);
		$date = $check_in_array[0];
		$date_array = explode ('-',$date);
		$year = $date_array[0];
		$month = $date_array[1];
		$day = $date_array[2];
		echo $day.'-'.$month.'-'.$year;
	?>    </td>
    <td>
	<?php 
		$check_out = $row['CHECK_OUT'];
		$check_out_array = explode (' ',$check_out);
		$date = $check_out_array[0];
		$date_array = explode ('-',$date);
		$year = $date_array[0];
		$month = $date_array[1];
		$day = $date_array[2];
		echo $day.'-'.$month.'-'.$year;
	?>    </td>
    <td><?php echo $row['STATUS'];?></td>
    <td><?php echo $reservation_rooms;?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <?php
  }
  ?>
</table>

<p><a href="<?php echo base_url().'guests/viewGuests/'?>">Volver a Clientes</a></p>
<p><a href="<?php echo base_url().'reservations/viewPendingReservations/'?>">Volver a Reservaciones</a></p>
<p><a href="<?php echo base_url().'rooms/viewRooms/'?>">Volver a Habitaciones</a></p>
<p><a href="<?php echo base_url().'rooms/viewRoomTypes/'?>">Volver a Tipos de habitaciones</a></p>