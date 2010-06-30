

<?php 

$this->load->view('header'); 

foreach ($room_type as $row)
{
	$room_type_id = $row['ID_ROOM_TYPE'];
	$room_type_name = $row['NAME'];
}

echo 'EDITAR HABITACIÓN TIPO "'.$room_type_name.'"';?><br /><br /><?php

echo validation_errors();

echo form_open(base_url().'rooms/edit_room_type/'.$room_type_id.'/'.$room_type_name);

foreach ($room_type as $row)
{?>
	<p>* Nombre: 
	<input name="room_type_name" type="text" id="room_type_name" value="<?php echo $row['NAME']; ?>" size="30" maxlength="50"/>
    </p>
    
    <p>Abrev.: 
	<input name="room_type_abrv" type="text" id="room_type_abrv" value="<?php echo $row['ABRV']; ?>" size="5" maxlength="5"/>
    </p>
   
    <p>* Cantidad de camas: 
	<input name="room_type_beds" type="text" id="room_type_beds" value="<?php echo $row['BEDS']; ?>" size="5" maxlength="5"/>
    </p>
    
    <p>* Max. personas: 
	<input name="room_type_sleeps" type="text" id="room_type_sleeps" value="<?php echo $row['SLEEPS']; ?>" size="5" maxlength="5"/>
    </p>
    
    <p>Detalles: </p>
	<p><textarea name="room_type_details" rows="3" id="room_type_details"><?php echo $row['DETAILS'];  ?></textarea></p>
    
    
<?php
}

echo form_submit('sumit', 'Enviar');
echo form_close();
?>
<br /><br />

<a href="<?php echo base_url().'rooms/info_room_type/'.$room_type_id?>">Volver</a>
