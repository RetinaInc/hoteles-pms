<html>
<head>

<SCRIPT TYPE="text/javascript">
<!--
// copyright 1999 Idocs, Inc. http://www.idocs.com
// Distribute this script freely but keep this notice in place
function numbersonly(myfield, e, dec)
{
var key;
var keychar;

if (window.event)
   key = window.event.keyCode;
else if (e)
   key = e.which;
else
   return true;
keychar = String.fromCharCode(key);

// control keys
if ((key==null) || (key==0) || (key==8) || 
    (key==9) || (key==13) || (key==27) )
   return true;

// numbers
else if ((("0123456789").indexOf(keychar) > -1))
   return true;

// decimal point jump
else if (dec && (keychar == "."))
   {
   myfield.form.elements[dec].focus();
   return false;
   }
else
   return false;
}

//-->
</SCRIPT>

<style type="text/css">
<!--
.Estilo1 {color: #FF0000}
-->
</style>

</head>

<body>

<?php 

$this->load->view('pms/header'); 


echo 'NUEVA RESERVACIÓN'."<br><br>";

echo validation_errors();

if ($error != 1) {
	?><span class="Estilo1"><?php echo $error; ?></span><?php
}

$attributes = array('name' => 'reservation', 'id' => 'reservation');
echo form_open(base_url().'reservations/createReservation3/'.$reservationId, $attributes);?>

<?php

foreach ($reservationRoomInfo as $row) {

	$unixCi   = human_to_unix($row['checkIn']);
	$unixCo   = human_to_unix($row['checkOut']);
	$checkIn  = date ("D  j/m/Y" , $unixCi);
	$checkOut = date ("D  j/m/Y" , $unixCo);
	break;
}

?>
<table width="482" border="0">
  <tr>
    <td width="62">Llegada:</td>
    <td width="159"><?php echo $checkIn?></td>
    <td width="87">Habitaciones: </td>
    <td width="156"><?php echo $reservationRoomCount ?></td>
  </tr>
    <?php
	$total = 0;
	foreach ($reservationRoomInfo as $row) {
		$total = $total + $row['total'];
	}
	?>
  <tr>
    <td>Salida:</td>
    <td><?php echo $checkOut?></td>
    <td>Total: </td>
    <td><?php echo $total ?> Bs.F.</td>
  </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
  <tr>
    <td colspan="2">Detalles de la reservaci&oacute;n:</td>
    <td colspan="2"><textarea name="reservation_details" id="reservation_details" cols="25" rows="2"> <?php echo set_value('reservation_details'); ?></textarea></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
  </tr>
</table>

<table width="682" border="0">
  <tr>
    <td colspan="4">INFORMACION CLIENTE CONTACTO</td>
  </tr>
  <tr>
    <td width="100" height="39">* CI</td>
    <td width="269">V-
      <input name="guest_ci" type="text" id="guest_ci" value="<?php echo set_value('guest_ci'); ?>" size="8" maxlength="8" onKeyPress="return numbersonly(this, event)"/></td>
    <td width="92">&nbsp;</td>
    <td width="203">&nbsp;</td>
  </tr>
  <tr>
    <td height="41">* Nombre</td>
    <td><input name="guest_name" type="text" id="guest_name" value="<?php echo set_value('guest_name'); ?>" size="30" maxlength="30" /></td>
    <td>Seg. Nombre</td>
    <td><input name="guest_2name" type="text" id="guest_2name" value="<?php echo set_value('guest_2name'); ?>" size="30" maxlength="30" /></td>
  </tr>
  <tr>
    <td height="39">* Apellido</td>
    <td><input name="guest_last_name" type="text" id="guest_last_name" value="<?php echo set_value('guest_last_name'); ?>" size="30" maxlength="30" /></td>
    <td>Seg. Apellido</td>
    <td><input name="guest_2last_name" type="text" id="guest_2last_name" value="<?php echo set_value('guest_2last_name'); ?>" size="30" maxlength="30" /></td>
  </tr>
  <tr>
    <td height="37">* Tel&eacute;fono</td>
    <td><input name="guest_telephone" type="text" id="guest_telephone" value="<?php echo set_value('guest_telephone'); ?>" size="20" maxlength="20" onKeyPress="return numbersonly(this, event)"/></td>
    <td>* Correo</td>
    <td><input name="guest_email" type="text" id="guest_email" value="<?php echo set_value('guest_email'); ?>" size="30" maxlength="50" /></td>
  </tr>
  <tr>
    <td height="40">Direcci&oacute;n</td>
    <td><textarea name="guest_address" cols="25" rows="2" id="guest_address"> <?php echo set_value('guest_address'); ?></textarea></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<p>&nbsp;</p>
<?php 
if ($reservationRoomCount > 1) {
	
	foreach ($reservationRoomInfo as $row) {
		?>
		<table width="311" border="0">
	  	  <tr>
    		<td colspan="4">CLIENTE HABITACIÓN <?php echo $row['number'].' - '.$row['abrv']?></td>
   		  </tr>
          <tr>
    		<td width="106">* CI</td>
    		<td width="195">V - <input name="guest_ci<?php echo $row['number']?>" type="text" id="guest_ci<?php echo $row['number']?>" value="<?php echo set_value('guest_ci'.$row['number']); ?>" size="8" maxlength="8" onKeyPress="return numbersonly(this, event)"/></td>
          </tr>
  		  <tr>
    		<td width="106">* Nombres</td>
    		<td width="195"><input name="guest_name<?php echo $row['number']?>" type="text" id="guest_name<?php echo $row['number']?>" value="<?php echo set_value('guest_name'.$row['number']); ?>" size="30" maxlength="30" /></td>
  		  </tr>
           <tr>
    		<td width="106">* Apellidos</td>
    		<td width="195"><input name="guest_last_name<?php echo $row['number']?>" type="text" id="guest_last_name<?php echo $row['number']?>" value="<?php echo set_value('guest_last_name'.$row['number']); ?>" size="30" maxlength="30" /></td>
          </tr>
          <?php 
		  if (($row['children'] != 0) && ($row['children'] != NULL)) {
		  ?>
		  <tr>
            <td width="106">* Edad Niños</td>
   			<td width="195">
            <?php
			for ($i=1; $i<=$row['children']; $i++) {
			?>
            <select name="children_age<?php echo $row['number'].'_'.$i?>" id="children_age<?php echo $row['number'].'_'.$i?>">
              <option value="1" <?php echo set_select('children_age'.$row['number'].$i, '1'); ?> selected>1</option>
              <option value="2" <?php echo set_select('children_age'.$row['number'].$i, '2'); ?> >2</option>
              <option value="3" <?php echo set_select('children_age'.$row['number'].$i, '3'); ?> >3</option>
              <option value="4" <?php echo set_select('children_age'.$row['number'].$i, '4'); ?> >4</option>
              <option value="5" <?php echo set_select('children_age'.$row['number'].$i, '5'); ?> >5</option>
              <option value="6" <?php echo set_select('children_age'.$row['number'].$i, '6'); ?> >6</option>
              <option value="7" <?php echo set_select('children_age'.$row['number'].$i, '7'); ?> >7</option>
              <option value="8" <?php echo set_select('children_age'.$row['number'].$i, '8'); ?> >8</option>
              <option value="9" <?php echo set_select('children_age'.$row['number'].$i, '9'); ?> >9</option>
              <option value="10" <?php echo set_select('children_age'.$row['number'].$i, '10'); ?> >10</option>
              <option value="11" <?php echo set_select('children_age'.$row['number'].$i, '11'); ?> >11</option>
              <option value="12" <?php echo set_select('children_age'.$row['number'].$i, '12'); ?> >12</option>
              <option value="13" <?php echo set_select('children_age'.$row['number'].$i, '13'); ?> >13</option>
              <option value="14" <?php echo set_select('children_age'.$row['number'].$i, '14'); ?> >14</option>
              <option value="15" <?php echo set_select('children_age'.$row['number'].$i, '15'); ?> >15</option>
              <option value="16" <?php echo set_select('children_age'.$row['number'].$i, '16'); ?> >16</option>
              <option value="17" <?php echo set_select('children_age'.$row['number'].$i, '17'); ?> >17</option>
            </select>
            <?php
			}
			?>
            </td>
       	  </tr>
		<?php
		  }
		  ?>
		</table>
<br><br>
		<?php
	}
}

echo form_submit('sumit', 'Guardar');
echo form_close();
?>

<br>
<a href="<?php echo base_url().'reservations/createReservation1'?>" onClick="return confirm('Seguro que desea volver? Se perderá la información')">Volver</a>

</body>
</html>