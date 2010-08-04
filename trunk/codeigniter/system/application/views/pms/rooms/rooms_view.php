
<?php 

$this->load->view('pms/header'); 

echo anchor(base_url().'rooms/addRoom/','Agregar Nueva Habitación');?><br><?php
echo anchor(base_url().'rooms/viewRoomTypes/','Ver tipos de habitaciones');
?>

<p>
<?php 
echo 'Total habitaciones: ', $roomsCount;?><br><?php
echo 'Total habitaciones en funcionamiento: ', $roomsCountRunning;?><br><?php
echo 'Total habitaciones fuera de servicio: ', $roomsCountOos;
?>
</p>

<table width="332" border="1">
  <tr>
    <td width="61">
    	<?php
        echo form_open(base_url().'rooms/viewRooms');
		echo form_hidden('order', 'number');
		echo 'Número ', form_submit('sumit', '^');
        echo form_close();
		?>   	
   	</td>
    <?php 
	$name = 'No';
	foreach ($rooms as $row) {
	
		if ($row['name'] != NULL) {
		
		    $name = 'Yes';
		}
	}
	if ($name == 'Yes') { 
	?>
        <td width="91">
			<?php 
			echo form_open(base_url().'rooms/viewRooms');
			echo form_hidden('order', 'name');
			echo 'Nombre ', form_submit('sumit', '^');
        	echo form_close();
			?>        
    	</td>
    <?php
	}
	?>
  
    <td width="72">
    	<?php 
		echo form_open(base_url().'rooms/viewRooms');
		echo form_hidden('order', 'rtname');
		echo 'Tipo ', form_submit('sumit', '^');
       	echo form_close();
		?>  	
  	</td>
 	<td width="80">
		<?php 
			echo form_open(base_url().'rooms/viewRooms');
			echo form_hidden('order', 'status');
			echo 'Estado ', form_submit('sumit', '^');
        	echo form_close();
		?> 	
 	</td>
  </tr>
	
<?php
foreach ($rooms as $row) { ?>
  <tr>
    <td><?php echo anchor(base_url().'rooms/infoRoom/'.$row['id_room'],$row['number']);?></td> 
    <?php
	if ($name == 'Yes') { ?>
	<td> 
		<?php 
		if ($row['name'] != NULL) {
			echo $row['name']; 
		} else {
			echo '&nbsp;';
		}
		?>
    </td>
    <?php 
	}
	?>
	
    <td><?php echo $row['rtabrv'];?></td>
    <td><?php echo lang($row['status']);?><br></td>
  </tr><?php
}
?>
</table>

