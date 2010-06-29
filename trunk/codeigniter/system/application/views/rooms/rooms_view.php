
<?php 

$this->load->view('header'); 

echo anchor(base_url().'rooms/add_room/','Agregar Nueva Habitación');?><br><?php
echo anchor(base_url().'rooms/view_room_types/','Ver tipos de habitaciones');
?>

<p>
<?php 
echo 'Total habitaciones: ', $rooms_count;?><br><?php
echo 'Total habitaciones en funcionamiento: ', $rooms_count_running;?><br><?php
echo 'Total habitaciones fuera de servicio: ', $rooms_count_oos;
?>
</p>

<table width="530" border="1">
  <tr>
    <td width="70">
		<?php 
			echo form_open(base_url().'rooms/view_rooms');
			echo form_hidden('order', 'number');
			echo form_submit('number', 'Número');
        	echo form_close();
		?>
   	</td>
   	<?php 
	foreach ($rooms as $row)
	{
		if ($row['NAME'] != NULL)
		{$name = 'Yes';?>
        <td width="90">
		<?php 
			echo form_open(base_url().'rooms/view_rooms');
			echo form_hidden('order', 'name');
			echo form_submit('name', 'Nombre');
        	echo form_close();
		?>
        </td><?php 
		}
		else
		{
			$name = 'No';
		}
	}?>
    <td width="150">
		<?php 
			echo form_open(base_url().'rooms/view_rooms');
			echo form_hidden('order', 'status');
			echo form_submit('status', 'Estado');
        	echo form_close();
		?>    </td>
    <td width="140">
		<?php 
			echo form_open(base_url().'rooms/view_rooms');
			echo form_hidden('order', 'rtname');
			echo form_submit('room_type', 'Tipo de habitación');
        	echo form_close();
		?>    </td>
    <td width="46">Ver</td>
  </tr>
	<?php
	
foreach ($rooms as $row)
{	
?>
  <tr>
    <td><?php echo $row['NUMBER'];?></td>
<?php if ($name == 'Yes')
{?>
	<td> <?php {echo $row['NAME'];} ?></td><?php 
}?>
    <td><?php echo lang($row['STATUS']);?> </td>
    <td><?php echo $row['RTNAME'];?><br></td>
    <td><?php echo anchor(base_url().'rooms/info_room/'.$row['ID_ROOM'],'Ver');?></td>
  </tr>
 <?php
 }
 ?>
</table>

