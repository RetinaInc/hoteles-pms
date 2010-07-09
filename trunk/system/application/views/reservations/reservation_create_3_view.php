
<?php 

$this->load->view('header'); 


echo 'NUEVA RESERVACIÓN';?><br /><br /><?php

echo validation_errors();

echo form_open(base_url().'reservations/create_reservation_3/');?>

<table width="882" border="0">
  <tr>
    <td height="43" colspan="2">INFORMACION HABITACION</td>
    <td>&nbsp;</td>
    <td colspan="2">INFORMACION CLIENTE</td>
  </tr>
  <tr>
    <td width="263" height="39"><?php
	foreach ($room_info as $row)
	{
    	echo form_label('Habitaci&oacute;n # '.$row['NUMBER'], 'room_number');
		echo form_hidden('room_number', $row['ID_ROOM']);
		
	}
	?></td>
    <td width="179">&nbsp;</td>
    <td width="77">&nbsp;</td>
    <td width="100">Nombre</td>
    <td width="241"><input name="guest_name" type="text" id="guest_name" value="<?php echo set_value('guest_name'); ?>" size="30" maxlength="30" /></td>
  </tr>
  <tr>
    <td height="41"><?php
	foreach ($room_type_info as $row)
	{
    	echo form_label('Tipo de habitaci&oacute;n: '.$row['NAME'], 'room_type');
		echo form_hidden('room_type', $row['ID_ROOM_TYPE']);
	}
	?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>Apellido</td>
    <td><input name="guest_last_name" type="text" id="guest_last_name" value="<?php echo set_value('guest_last_name'); ?>" size="30" maxlength="30" /></td>
  </tr>
  <tr>
    <td height="39"><?php
	$unix_ci = human_to_unix($check_in);
	echo form_label('Check In: '.date ("D  j/m/Y  " , $unix_ci), 'check_in');
	echo form_hidden('check_in', $check_in);
	?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>Teléfono</td>
    <td><input name="guest_telephone" type="text" id="guest_telephone" value="<?php echo set_value('guest_telephone'); ?>" size="20" maxlength="20" /></td>
  </tr>
  <tr>
    <td height="45"><?php
	$unix_co = human_to_unix($check_out);
	echo form_label('Check Out: '.date ("D  j/m/Y  " , $unix_co), 'check_out');
	echo form_hidden('check_out', $check_out);
	?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>Correo</td>
    <td><input name="guest_email" type="text" id="guest_email" value="<?php echo set_value('guest_email'); ?>" size="30" maxlength="50" /></td>
  </tr>
  <tr>
    <td><?php
	echo form_label('Cantidad de noches: '.$nights, 'nights')
	?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>Dirección</td>
    <td><textarea name="guest_address" cols="30" rows="2" id="guest_address" value="<?php echo set_value('guest_address'); ?>"></textarea></td>
  </tr>
  <tr>
    <td height="37">Tarifa</td>
    <td><select name="reservation_rate" id="reservation_rate">
        <option value=""></option>
    </select></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td height="40">Cantidad de adultos: </td>
    <td><input name="reservation_adults2" type="text" id="reservation_adults2" value="<?php echo set_value('reservation_adults'); ?>" size="4" maxlength="4" onkeypress="return numbersonly(this, event)" /></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td height="41">Cantidad de ni&ntilde;os: </td>
    <td><input name="reservation_children2" type="text" id="reservation_children2" value="<?php echo set_value('reservation_children'); ?>" size="4" maxlength="4" onkeypress="return numbersonly(this, event)"/></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Detalles: </td>
    <td><textarea name="reservation_details2" rows="2" id="reservation_details2"><?php echo set_value('reservation_details');  ?></textarea></td>
    <td>&nbsp;</td>
    <td>
	<?php
		echo form_submit('sumit', 'Guardar Reservación');
		echo form_close();
	?></td>
    <td>&nbsp;</td>
  </tr>
</table>
    
	
 

<a href="<?php echo base_url().'reservations/create_reservation_1'?>">Volver</a>
