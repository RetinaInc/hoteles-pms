
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

<table width="332" border="1">
  <tr>
    <td width="61">
    	<?php
        echo form_open(base_url().'rooms/view_rooms');
		echo form_hidden('order', 'NUMBER');
		echo 'Número ', form_submit('sumit', '^');
        echo form_close();
		?>   	</td>
<?php 
	foreach ($rooms as $row)
	{
		if ($row['NAME'] != NULL)
		{$name = 'Yes';?>
        <td width="91">
			<?php 
			echo form_open(base_url().'rooms/view_rooms');
			echo form_hidden('order', 'NAME');
			echo 'Nombre ', form_submit('sumit', '^');
        	echo form_close();
			?>        </td>
    <?php 
		}
		else
		{
			$name = 'No';
		}
	}?>
    <td width="72">
    	<?php 
			echo form_open(base_url().'rooms/view_rooms');
			echo form_hidden('order', 'RTNAME');
			echo 'Tipo ', form_submit('sumit', '^');
        	echo form_close();
		?>  	</td>
  <td width="80">
		<?php 
			echo form_open(base_url().'rooms/view_rooms');
			echo form_hidden('order', 'STATUS');
			echo 'Estado ', form_submit('sumit', '^');
        	echo form_close();
		?> 	</td>
  </tr>
	<?php
	
foreach ($rooms as $row)
{	
?>
  <tr>
    <td><?php echo anchor(base_url().'rooms/info_room/'.$row['ID_ROOM'],$row['NUMBER']);?></td>
<?php if ($name == 'Yes')
{?>
	<td> <?php {echo $row['NAME'];} ?></td><?php 
}?>
    <td> <?php echo $row['RTNAME'];?></td>
    <td><?php echo lang($row['STATUS']);?><br></td>
  </tr>
 <?php
 }
 ?>
</table>

