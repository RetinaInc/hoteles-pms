
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
</head>

<?php 

$this->load->view('pms/header'); 

foreach ($roomType as $row) {

	$roomTypeId   = $row['id_room_type'];
	$roomTypeName = $row['name'];
}

echo 'EDITAR HABITACIÓN TIPO "'.$roomTypeName.'"';?><br /><br /><?php

echo validation_errors();

echo form_open(base_url().'rooms/editRoomType/'.$roomTypeId.'/'.$roomTypeName);

foreach ($roomType as $row) {?>
	<p>* Nombre: 
	<input name="room_type_name" type="text" id="room_type_name" value="<?php echo $row['name']; ?>" size="30" maxlength="50"/>
    </p>
    
    <p> Abrev.: 
	<input name="room_type_abrv" type="text" id="room_type_abrv" value="<?php echo $row['abrv']; ?>" size="5" maxlength="5"/>
    </p>
   
    <p>* Pax estandar: 
	<input name="room_type_paxStd" type="text" id="room_type_paxStd" value="<?php echo $row['paxStd']; ?>" size="5" maxlength="3" onKeyPress="return numbersonly(this, event)"/>
    </p>
    
    <p>* Pax máximo: 
	<input name="room_type_paxMax" type="text" id="room_type_paxMax" value="<?php echo $row['paxMax']; ?>" size="5" maxlength="3" onKeyPress="return numbersonly(this, event)"/>
    </p>
    
     <p>* Cantidad de camas: 
	<input name="room_type_beds" type="text" id="room_type_beds" value="<?php echo $row['beds']; ?>" size="5" maxlength="3" onKeyPress="return numbersonly(this, event)"/>
    </p>
    
    <p> Descripción: </p>
	<p><textarea name="room_type_description" rows="3" id="room_type_description"><?php echo $row['description'];  ?></textarea></p>
   
<?php
}

echo form_submit('sumit', 'Enviar');
echo form_close();
?>
<br /><br />

<a href="<?php echo base_url().'rooms/infoRoomType/'.$roomTypeId?>">Volver</a>
