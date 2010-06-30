
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

<table width="483" border="1">
  <tr>
    <td width="70">
    	<?php
        echo form_open(base_url().'rooms/view_rooms');
		echo form_hidden('order', 'NUMBER');
		echo 'Número ', form_submit('sumit', '^');
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
			echo form_hidden('order', 'NAME');
			echo 'Nombre ', form_submit('sumit', '^');
        	echo form_close();
			?>
        </td><?php 
		}
		else
		{
			$name = 'No';
		}
	}?>
    <td width="120">
		<?php 
			echo form_open(base_url().'rooms/view_rooms');
			echo form_hidden('order', 'STATUS');
			echo 'Estado ', form_submit('sumit', '^');
        	echo form_close();
		?>    </td>
  <td width="130">
		<?php 
			echo form_open(base_url().'rooms/view_rooms');
			echo form_hidden('order', 'RTNAME');
			echo 'Tipo de habitación ', form_submit('sumit', '^');
        	echo form_close();
		?>    </td>
    <td width="39">Ver</td>
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

