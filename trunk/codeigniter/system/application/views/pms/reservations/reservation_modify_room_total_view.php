
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
else if ((("0123456789,").indexOf(keychar) > -1))
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
</head>

<?php 
$this->load->view('pms/header'); 

echo 'MODICAR MONTO HABITACIÓN';

foreach ($roomReservationInfo as $row) {
	
	$reservationId = $row['id_reservation'];
	
	if ($row['id_room'] == $roomId) {
	?>
    
    <br><br>
	<table width="318" border="0">
      <tr>
        <td width="120">Reservación</td>
        <td width="188"># <?php echo $row['id_reservation']?></td>
      </tr>
      <tr>
        <td>Habitación</td>
        <td><?php echo $row['number']?></td>
      </tr>
      <tr>
        <td>Tipo habitación</td>
        <td><?php echo $row['abrv']?></td>
      </tr>
      <tr>
        <td>Adultos</td>
        <td><?php echo $row['adults']?></td>
      </tr>
      <tr>
        <td>Ni&ntilde;os</td>
        <td><?php echo $row['children'];?></td>
      </tr>
      <tr>
        <td>Total Habitación</td>
        <td><?php echo $row['total']?> Bs.F.</td>
      </tr>
    </table>
    
    <?php
	}
}

echo form_open('reservations/modifyRoomReservationTotal/'.$reservationId.'/'.$roomId);
?>

<table width="454" border="0">
  <tr>
    <td width="122">Nuevo Monto</td>
    <td width="127"><input type="text" name="new_total" id="new_total" value="<?php echo set_value('new_total')?>" maxlength="10" size="10" onKeyPress="return numbersonly(this, event)"/> Bs.F. </td>
    <td width="191"><?php echo form_submit('sumit', 'Modificar');?></td>
  </tr>
</table>

<?php
echo form_close();
?>

</html>