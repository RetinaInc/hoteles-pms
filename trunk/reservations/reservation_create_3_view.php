

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

</head>

<body>

<?php 

$this->load->view('pms/header'); 


echo 'NUEVA RESERVACIÓN';?><br /><br /><?php

echo validation_errors();

$attributes = array('name' => 'reservation', 'id' => 'reservation');

echo form_open(base_url().'reservations/createReservation3/', $attributes);?>

<table width="882" border="0">
  <tr>
    <td height="43" colspan="2">INFORMACION HABITACIÓN</td>
    <td>&nbsp;</td>
    <td colspan="2">INFORMACION CLIENTE</td>
  </tr>
  <tr>
    <td width="263" height="39"><?php
	foreach ($roomInfo as $row) {
	
    	echo form_label('Habitaci&oacute;n # '.$row['number'], 'room_number');
		echo form_hidden('room_number', $row['id_room']);	
	}
	?></td>
    <td width="179">&nbsp;</td>
    <td width="77">&nbsp;</td>
    <td width="100">Nombre</td>
    <td width="241"><input name="guest_name" type="text" id="guest_name" value="<?php echo set_value('guest_name'); ?>" size="30" maxlength="30" /></td>
  </tr>
  <tr>
    <td height="41"><?php
	foreach ($roomTypeInfo as $row) {
	
    	echo form_label('Tipo de habitaci&oacute;n: '.$row['name'], 'room_type');
		echo form_hidden('room_type', $row['id_room_type']);
	}
	?>
    </td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>Apellido</td>
    <td><input name="guest_last_name" type="text" id="guest_last_name" value="<?php echo set_value('guest_last_name'); ?>" size="30" maxlength="30" /></td>
  </tr>
  <tr>
    <td height="39">
	<?php
	$unixCi = human_to_unix($checkIn);
	echo form_label('Check In: '.date ("D  j/m/Y  " , $unixCi), 'check_in');
	echo form_hidden('check_in', $checkIn);
	?>
    </td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>Teléfono</td>
    <td><input name="guest_telephone" type="text" id="guest_telephone" value="<?php echo set_value('guest_telephone'); ?>" size="20" maxlength="20" /></td>
  </tr>
  <tr>
    <td height="45">
	<?php
	$unixCo = human_to_unix($checkOut);
	echo form_label('Check Out: '.date ("D  j/m/Y  " , $unixCo), 'check_out');
	echo form_hidden('check_out', $checkOut);
	?>
    </td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>Correo</td>
    <td><input name="guest_email" type="text" id="guest_email" value="<?php echo set_value('guest_email'); ?>" size="30" maxlength="50" /></td>
  </tr>
  <tr>
    <td>
	<?php
	echo form_label('Cantidad de noches: '.$nights, 'nights')
	?>
    </td>
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
    <td>
    	<?php 
		foreach ($roomTypeInfo as $row) {
		
			$maxPers = $row['paxMax'];
		}
		?>
		<select name="reservation_adults" id="reservation_adults" onChange="redirect(this.options.selectedIndex)">
        <?php 
		for ($i = 1; $i <= $maxPers; $i++) {
			    
		    ?><option value="<?php echo $i; ?>" <?php echo set_select('reservation_adults', $i); ?> ><?php echo $i?></option><?php
		}
		?>
  		</select>
				
    <!-- <input name="reservation_adults2" type="text" id="reservation_adults2" value="<?php echo set_value('reservation_adults'); ?>" size="4" maxlength="4" onkeypress="return numbersonly(this, event)" />-->
    </td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td height="41">Cantidad de ni&ntilde;os: </td>
    <td>
    <!--<select name="reservation_children" id="reservation_children">
    	<option value='' selected>''</option>
	</select>   -->
     <input name="reservation_children2" type="text" id="reservation_children2" value="<?php echo set_value('reservation_children'); ?>" size="4" maxlength="4" onKeyPress="return numbersonly(this, event)"/>
    </td>
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
    
	
 

<a href="<?php echo base_url().'reservations/createReservation1'?>">Volver</a>




<script>
var groups=document.reservation.reservation_adults.options.length
var group=new Array(groups)
for (i=0; i<groups; i++)
group[i]=new Array()

group[0][0]=new Option("0","0")

group[1][0]=new Option("5","5")
group[1][1]=new Option("4","4")
group[1][2]=new Option("3","3")
group[1][3]=new Option("2","2")
group[1][4]=new Option("1","1")
group[1][5]=new Option("0","0")

group[2][0]=new Option("4","4")
group[2][1]=new Option("3","3")
group[2][2]=new Option("2","2")
group[2][3] new Option("1","1")
group[2][4] new Option("0","0")

group[3][0]=new Option("3","3")
group[3][1]=new Option("2","2")
group[3][2]=new Option("1","1")
group[3][3]=new Option("0","0")

group[4][0]=new Option("2","2")
group[4][1]=new Option("1","1")
group[4][2]=new Option("0","0")

group[5][0]=new Option("1","1")
group[5][1]=new Option("0","0")

group[6][0]=new Option("0","0")


var temp=document.reservation.reservation_children

function redirect(x){
for (m=temp.options.length-1;m>0;m--)
temp.options[m]=null
for (i=0;i<group[x].length;i++){
temp.options[i]=new Option(group[x][i].text,group[x][i].value)
}
temp.options[0].selected=true
}

</script>
</body>