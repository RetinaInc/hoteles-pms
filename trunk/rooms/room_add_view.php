
<?php 

$this->load->view('pms/header'); 


echo 'NUEVA HABITACIÓN';?><br /><br /><?php

echo validation_errors();

echo form_open(base_url().'rooms/addRoom/');

foreach ($maxRoomNumber as $row) {

	$nextRoom = $row['number'] + 1;
}
?>

	<p>* Número:
      <input name="room_number" type="text" id="room_number" value="<?php echo $nextRoom; ?>" size="5" maxlength="20" />
    </p>
	
    <p> Nombre: 
  	  <input name="room_name" type="text" id="room_name" value="<?php echo set_value('room_name'); ?>" size="30" maxlength="50"/>
	</p>
    
    <p>* Estado:			
	  <select name="room_status" id="room_status">
    	<option value="Running" <?php echo set_select('room_status', 'Running'); ?> >Funcionando</option>
      	<option value="Out of service" <?php echo set_select('room_status', 'Out of service'); ?> >Fuera de servicio</option>
  	</select>
    </p>
                
	 <p>* Tipo de habitación:
       <select name="room_room_type" id="room_room_type"><?php
	foreach ($roomTypes as $row) { 
	
	    ?><option value="<?php echo $row['id_room_type']; ?>" <?php echo set_select('room_room_type', $row['id_room_type']); ?> ><?php echo $row['name']; ?></option><?php 
		
	}
	?>
	</select>
    </p>
   
<?php
echo form_submit('sumit', 'Enviar');
echo form_close();
?>

<a href="<?php echo base_url().'rooms/viewRooms'?>">Volver</a>
