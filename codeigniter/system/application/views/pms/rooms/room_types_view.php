
<?php 
$this->load->view('pms/header'); 

echo anchor(base_url().'rooms/addRoomType/','Agregar Nuevo tipo de habitación');?><br><?php
?>

<p>
<?php 
echo 'Total tipos de habitación: ', $roomTypesCount;?><br><?php
?>
</p>

<table width="499" border="1">
  <tr>
    <td width="135">
		<?php 
			echo form_open(base_url().'rooms/viewRoomTypes');
			echo form_hidden('order', 'name');
			echo 'Nombre ', form_submit('sumit', '^');
        	echo form_close();
		?>   	</td>
    <td width="60">Abrev</td>
  <td width="90">
		<?php 
			echo form_open(base_url().'rooms/viewRoomTypes');
			echo form_hidden('order', 'paxStd');
			echo 'Pax estándar ', form_submit('sumit', '^');
        	echo form_close();
		?>    </td>
  <td width="90">
		<?php 
			echo form_open(base_url().'rooms/viewRoomTypes');
			echo form_hidden('order', 'paxMax');
			echo 'Pax máximo ', form_submit('sumit', '^');
        	echo form_close();
		?>    </td>
  <td width="90">
		<?php 
			echo form_open(base_url().'rooms/viewRoomTypes');
			echo form_hidden('order', 'beds');
			echo 'Camas ', form_submit('sumit', '^');
        	echo form_close();
		?>    </td>
  </tr>

<?php
foreach ($roomTypes as $row) {	?>

  <tr>
    <td><?php echo anchor(base_url().'rooms/infoRoomType/'.$row['id_room_type'],$row['name']);?></td>
	<td><?php echo $row['abrv'];?></td>
    <td><?php echo $row['paxStd'];?><br></td>
    <td><?php echo $row['paxMax'];?><br></td>
    <td><?php echo $row['beds'];?> </td>
  </tr><?php
}
?>
</table>

<p><a href="<?php echo base_url().'rooms/viewRooms/'?>">Volver</a></p>

