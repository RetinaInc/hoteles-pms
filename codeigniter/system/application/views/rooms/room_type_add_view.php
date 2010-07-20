

<?php 

$this->load->view('pms/header'); 

echo 'CREAR TIPO DE HABITACIÓN';?><br /><br /><?php

echo validation_errors();

echo form_open(base_url().'rooms/add_room_type/');?>

	<p>Nombre: 
  	<input name="room_type_name" type="text" id="room_type_name" value="<?php echo set_value('room_type_name'); ?>" size="30" maxlength="50"/>
	</p>
    
    
    <p>Abrev.: 
	<input name="room_type_abrv" type="text" id="room_type_abrv" value="<?php echo set_value('room_type_abrv'); ?>" size="5" maxlength="5"/>
    </p>
   
    <p>Cantidad de camas: 
	<input name="room_type_beds" type="text" id="room_type_beds" value="<?php echo set_value('room_type_beds'); ?>" size="5" maxlength="5"/>
    </p>
    
    <p>Max. personas: 
	<input name="room_type_sleeps" type="text" id="room_type_sleeps" value="<?php echo set_value('room_type_sleeps'); ?>" size="5" maxlength="5"/>
    </p>
    
	<p>Detalles:</p>
	<p>
  	<textarea name="room_type_details" rows="3" id="room_type_details"><?php echo set_value('room_type_details');  ?></textarea>
	</p>

<?php 
echo form_submit('sumit', 'Enviar');
echo form_close();
?>
<br /><br />


<a href="<?php echo base_url().'rooms/view_room_types/'; ?>">Volver</a>
