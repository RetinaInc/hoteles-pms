
<?php 

$this->load->view('header'); 


echo 'NUEVA HABITACIÓN';?><br /><br /><?php

echo validation_errors();

echo form_open(base_url().'rooms/add_room/');

foreach ($max_room_number as $row)
{
	$next_room = $row['NUMBER'] + 1;
}
?>

	<p>Número:
    <input name="room_number" type="text" id="room_number" value="<?php echo $next_room; ?>" size="5" maxlength="20" />
    </p>
	
    <p>Estado:			
	<select name="room_status" id="room_status">
    	<option value="Running" <?php echo set_select('room_status', 'Running'); ?> >Funcionando</option>
      	<option value="Out of service" <?php echo set_select('room_status', 'Out of service'); ?> >Fuera de servicio</option>
  	</select>
    </p>
                
	 <p>Tipo de habitación:
    <select name="room_room_type" id="room_room_type"><?php
		foreach ($room_types as $row)
		{?>
            <option value="<?php echo $row['ID_ROOM_TYPE']; ?>" <?php echo set_select('room_room_type', $row['ID_ROOM_TYPE']); ?> ><?php echo $row['NAME']; ?></option><?php 
		}?>
	</select>
    </p>
   
<?php
echo form_submit('sumit', 'Enviar');
echo form_close();
?>

<a href="<?php echo base_url().'rooms/view_rooms'?>">Volver</a>
