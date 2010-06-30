

<?php 

$this->load->view('header'); 

foreach ($room_type as $row)
{
	$room_type_id = $row['ID_ROOM_TYPE'];
	$room_type_name = $row['NAME'];
}

echo 'INFO HABITACIÓN "'.$room_type_name.'"';?><br /><br /><?php

foreach ($room_type as $row)
{
	echo 'Nombre: ', $row['NAME'];?><br /><br /><?php
	
	if ($row['ABRV'] != NULL)
	{
		echo 'Abrv: ', $row['ABRV'];?><br /><br /><?php
	}
	
	echo 'Camas: ', $row['BEDS'];?><br /><br /><?php
	
	echo 'Max. Personas: ', $row['SLEEPS'];?><br /><br /><?php
	
	if ($row['DETAILS'] != NULL)
	{
		echo 'Detalles: ', $row['DETAILS'];?><br /><br /><?php
	}
	
	?>
    <a href="<?php echo base_url().'rooms/edit_room_type/'.$room_type_id ?>">Editar Info</a><br />
    <a href="<?php echo base_url().'rooms/delete_room_type/'.$room_type_id ?>" onClick="return confirm('Seguro que desea eliminar?')">Eliminar tipo de habitación</a><br /><br />
	<?php
}

?>
<p>
<?php 
echo 'Total habitaciones '.$room_type_name.': ', $room_type_count;?><br><?php
echo 'Total habitaciones en funcionamiento: ', $room_type_count_running;?><br><?php
echo 'Total habitaciones fuera de servicio: ', $room_type_count_oos;
?>
</p>



<a href="<?php echo base_url().'rooms/view_room_types/'?>">Volver</a>