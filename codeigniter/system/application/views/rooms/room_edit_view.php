

<?php 

$this->load->view('header'); 

foreach ($room as $row)
{
	$room_id = $row['ID_ROOM'];
	$room_number = $row['NUMBER'];
}

echo 'EDITAR HABITACIÓN #'.$room_number;?><br /><br /><?php

echo validation_errors();

echo form_open(base_url().'rooms/edit_room/'.$room_id.'/'.$room_number);

foreach ($room as $row)
{?>
	<p>Número:
	<input name="room_number" type="text" id="room_number" value="<?php echo $row['NUMBER']; ?>" size="5" maxlength="20" />
	</p>
    
    <?php
	if ($row['NAME'] != NULL)
	{
		echo 'Nombre: '.form_input('room_name', $row['NAME']);?><br /><br /><?php
	}
	
	$options = array(
				'Running' => 'Funcionando',
				'Out of service' => 'Fuera de servicio'
				);
				
	echo 'Estado: ', form_dropdown('room_status', $options, $row['STATUS']);?><br /><br />
	
	<p>Tipo de habitación:
    <select name="room_room_type" id="room_room_type">
    	<?php
		foreach ($room_types as $row1)
		{
			if ($row1['ID_ROOM_TYPE'] == $row['FK_ID_ROOM_TYPE'])
			{
				?><option value="<?php echo $row1['ID_ROOM_TYPE']?>" selected><?php echo $row1['NAME']; ?></option><?php
			}
			else
			{
				?><option value="<?php echo $row1['ID_ROOM_TYPE']?>"><?php echo $row1['NAME']; ?></option><?php
			}
		}
		?>
	</select>
   </p>
    <?php
}

echo form_submit('sumit', 'Enviar');?><br /><br /><?php

?>

<a href="<?php echo base_url().'rooms/info_room/'.$room_id?>">Volver</a>
