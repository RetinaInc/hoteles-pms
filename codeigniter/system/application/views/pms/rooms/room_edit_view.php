

<?php 

$this->load->view('pms/header'); 

foreach ($room as $row)
{
	$roomId     = $row['id_room'];
	$roomNumber = $row['number'];
}

echo 'EDITAR HABITACIÓN #'.$roomNumber;?><br /><br /><?php

echo validation_errors();

echo form_open(base_url().'rooms/editRoom/'.$roomId.'/'.$roomNumber);

foreach ($room as $row)
{?>
	<p>* Número:
	<input name="room_number" type="text" id="room_number" value="<?php echo $row['number']; ?>" size="5" maxlength="20" />
	</p>
    
    <p> Nombre:
	<input name="room_name" type="text" id="room_name" value="<?php echo $row['name']; ?>" size="30" maxlength="50" />
	</p>
    
    <p>
    <?php
	$options = array(
			   'Running'        => 'Funcionando',
			   'Out of service' => 'Fuera de servicio'
				);
				
	echo '* Estado: ', form_dropdown('room_status', $options, $row['status']);
	?>
	</p>
    
	<p>* Tipo de habitación:
    <select name="room_room_type" id="room_room_type">
    	<?php
		foreach ($roomTypes as $row1) {
		
			if ($row1['id_room_type'] == $row['fk_room_type']) {
			
				?><option value="<?php echo $row1['id_room_type']?>" selected><?php echo $row1['name']; ?></option><?php
				
			} else {
			
				?><option value="<?php echo $row1['id_room_type']?>"><?php echo $row1['name']; ?></option><?php
			}
		}
		?>
	</select>
   </p>

<?php
}

echo form_submit('sumit', 'Enviar');
echo form_close();

?><br /><br />

<a href="<?php echo base_url().'rooms/infoRoom/'.$roomId?>" onClick="return confirm('Seguro que desea cancelar? Se perderá la información')">Cancelar</a>
