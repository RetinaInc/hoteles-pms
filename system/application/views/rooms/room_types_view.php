
<?php 
$this->load->view('header'); 

echo anchor(base_url().'rooms/add_room_type/','Agregar Nuevo tipo de habitación');?><br><?php
?>

<p>
<?php 
echo 'Total tipos de habitación: ', $room_types_count;?><br><?php
?>
</p>

<table width="411" border="1">
  <tr>
    <td width="105">
		<?php 
			echo form_open(base_url().'rooms/view_room_types');
			echo form_hidden('order', 'NAME');
			echo 'Nombre ', form_submit('sumit', '^');
        	echo form_close();
		?>   	</td>
    <td width="64">Abrev</td>
<td width="80">
		<?php 
			echo form_open(base_url().'rooms/view_room_types');
			echo form_hidden('order', 'BEDS');
			echo 'Camas ', form_submit('sumit', '^');
        	echo form_close();
		?>    </td>
<td width="134">
		<?php 
			echo form_open(base_url().'rooms/view_room_types');
			echo form_hidden('order', 'SLEEPS');
			echo 'Max. Personas ', form_submit('sumit', '^');
        	echo form_close();
		?>    </td>
  </tr>
	<?php
	
foreach ($room_types as $row)
{	
?>
  <tr>
    <td><?php echo anchor(base_url().'rooms/info_room_type/'.$row['ID_ROOM_TYPE'],$row['NAME']);?></td>
	<td><?php echo $row['ABRV'];?></td>
    <td><?php echo $row['BEDS'];?> </td>
    <td><?php echo $row['SLEEPS'];?><br></td>
  </tr>
 <?php
 }
 ?>
</table>

<p><a href="<?php echo base_url().'rooms/view_rooms/'?>">Volver</a></p>

