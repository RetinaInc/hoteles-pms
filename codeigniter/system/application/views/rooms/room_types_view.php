
<?php 
$this->load->view('header'); 

echo anchor(base_url().'rooms/add_room_type/','Agregar Nuevo tipo de habitación');?><br><?php
?>

<p>
<?php 
echo 'Total tipos de habitación: ', $room_types_count;?><br><?php
?>
</p>

<table width="496" border="1">
  <tr>
    <td width="90">
		<?php 
			echo form_open(base_url().'rooms/view_room_types');
			echo form_hidden('order', 'name');
			echo form_submit('name', 'Tipo de habitación');
        	echo form_close();
		?>   	</td>
    <td width="84">Abrev</td>
  <td width="90">
		<?php 
			echo form_open(base_url().'rooms/view_room_types');
			echo form_hidden('order', 'beds');
			echo form_submit('beds', 'Camas');
        	echo form_close();
		?>    </td>
<td width="107">
		<?php 
			echo form_open(base_url().'rooms/view_room_types');
			echo form_hidden('order', 'sleeps');
			echo form_submit('sleeps', 'Max Personas');
        	echo form_close();
		?>    </td>
    <td width="91">Ver</td>
  </tr>
	<?php
	
foreach ($room_types as $row)
{	
?>
  <tr>
    <td><?php echo $row['NAME'];?></td>
	<td><?php echo $row['ABRV'];?></td>
    <td><?php echo $row['BEDS'];?> </td>
    <td><?php echo $row['SLEEPS'];?><br></td>
    <td><?php echo anchor(base_url().'rooms/info_room_type/'.$row['ID_ROOM_TYPE'],'Ver');?></td>
  </tr>
 <?php
 }
 ?>
</table>

