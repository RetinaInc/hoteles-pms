

<?php 

$this->load->view('header'); 

foreach ($room_type as $row)
{
	$room_type_id = $row['ID_ROOM_TYPE'];
	$room_type_name = $row['NAME'];
}

echo 'INFO HABITACIÓN "'.$room_type_name.'"'."<br><br>";

foreach ($room_type as $row)
{
	echo 'Nombre: ', $row['NAME']."<br>";
	
	if ($row['ABRV'] != NULL)
	{
		echo 'Abrv: ', $row['ABRV']."<br>";
	}
	
	echo 'Camas: ', $row['BEDS']."<br>";
	
	echo 'Max. Personas: ', $row['SLEEPS']."<br>";
	
	if ($row['DETAILS'] != NULL)
	{
		echo "<br>".'Detalles: ', $row['DETAILS']."<br>";
	}
	
	?>
    <a href="<?php echo base_url().'rooms/edit_room_type/'.$room_type_id ?>">Editar Info</a><br />
    <a href="<?php echo base_url().'rooms/delete_room_type/'.$room_type_id ?>" onClick="return confirm('Seguro que desea eliminar?')">Eliminar tipo de habitación</a><br />
	<?php
}

?>
<p>
<?php 
echo 'Total habitaciones '.$room_type_name.': ', $room_type_count."<br>";
echo 'Total habitaciones en funcionamiento: ', $room_type_count_running."<br>";
echo 'Total habitaciones fuera de servicio: ', $room_type_count_oos."<br><br>";
echo 'RESERVACIONES';
?>
</p>

<?php if ($room_type_reservations)
{
?>
<table width="831" border="1">
  <tr>
    <td width="102">
    	<?php
		echo '# Confirmación';
        echo form_open(base_url().'rooms/info_room_type/'.$room_type_id);
		echo form_hidden('order', 'RE.ID_RESERVATION');
		echo form_submit('sumit', '^');
        echo form_close();
		?>    </td>
     <td width="85">
    	<?php
		echo '# Habitación';
        echo form_open(base_url().'rooms/info_room_type/'.$room_type_id);
		echo form_hidden('order', 'RO.NUMBER');
		echo form_submit('sumit', '^');
        echo form_close();
		?>    </td>
    <td width="98">
    	<?php
		echo 'Check-In';
        echo form_open(base_url().'rooms/info_room_type/'.$room_type_id);
		echo form_hidden('order', 'RE.CHECK_IN DESC');
		echo form_submit('sumit', '^');
        echo form_close();
		?>    </td>
    <td width="101">
    	<?php
		echo 'Check-Out';
        echo form_open(base_url().'rooms/info_room_type/'.$room_type_id);
		echo form_hidden('order', 'RE.CHECK_OUT DESC');
		echo form_submit('sumit', '^');
        echo form_close();
		?>    </td>
    <td width="167">
    	<?php
		echo 'Nombre Cliente';
        echo form_open(base_url().'rooms/info_room_type/'.$room_type_id);
		echo form_hidden('order', 'G.LAST_NAME');
		echo form_submit('sumit', '^');
        echo form_close();
		?>    </td>
    <td width="89">
    	<?php
		echo 'Estado';
        echo form_open(base_url().'rooms/info_room_type/'.$room_type_id);
		echo form_hidden('order', 'RE.STATUS');
		echo form_submit('sumit', '^');
        echo form_close();
		?>    </td>
    <td width="54">Adultos</td>
    <td width="41">Niños</td>
    <td width="36">Pago</td>
  </tr>
 
 <?php 
 foreach ($room_type_reservations as $row)
 {
 ?>
  <tr>
    <td><?php echo anchor(base_url().'reservations/info_reservation/'.$row['ID_RESERVATION'],$row['ID_RESERVATION']);?></td>
    <td><?php echo anchor(base_url().'rooms/info_room/'.$row['ID_ROOM'],$row['NUMBER']);?></td>
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
	?>
    </td>
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
	?>
    </td>
    <td><?php foreach ($guest as $row1)
		{
			if ($row1['ID_GUEST'] == $row['FK_ID_GUEST'])
			{
				echo anchor(base_url().'guests/info_guest_reservations/'.$row1['ID_GUEST'],$row1['LAST_NAME'].', '.$row1['NAME']);
			}
		}
		?>    </td>
    <td><?php echo lang($row['STATUS']);?></td>
    <td><?php echo $row['ADULTS'];?></td>
    <td><?php echo $row['CHILDREN'];?></td>
    <td>&nbsp;</td>
  </tr>
  <?php
  }
  ?>
</table>
<?php 
}
else
{
	echo 'No existen reservaciones en este tipo de habitación!';
}?>

<br /><br /><a href="<?php echo base_url().'rooms/view_room_types/'?>">Volver</a>