<head>
<script language='javascript' src="<?php echo base_url() . "assets/calendario/"?>popcalendar.js"></script>
<script language='javascript' src="<?php echo base_url() . "assets/calendario/images"?>"></script>

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

$this->load->view('header'); 


echo 'NUEVA RESERVACI�N - CHEQUEAR DISPONIBILIDAD';?>
<br /><br /><?php

echo validation_errors();

$attributes = array('name' => 'form1', 'id' => 'form1');

echo form_open(base_url().'reservations/create_reservation_1/', $attributes);?>

	<p>Tipo de habitaci�n:
    <select name="reservation_room_type" id="reservation_room_type"><?php
		foreach ($room_types as $row)
		{?>
            <option value="<?php echo $row['ID_ROOM_TYPE']; ?>" <?php echo set_select('reservation_room_type', $row['ID_ROOM_TYPE']); ?> ><?php echo $row['NAME']; ?></option><?php 
		}?>
	</select>
    </p>
    
    <p>Fecha de llegada:			
	<input name="reservation_check_in" type="text" id="dateArrival" onClick="popUpCalendar(this, form1.dateArrival, 'dd-mm-yyyy');" size="10">
    </p>
    
	<p>Fecha de salida:
    <input name="reservation_check_out" type="text" id="dateDeparture" onClick="popUpCalendar(this, form1.dateDeparture, 'dd-mm-yyyy');" size="10">			
</p>
                
	 
   
<?php
echo form_submit('sumit', 'Buscar Habitaci�n');
echo form_close();
?>

<a href="<?php echo base_url().'reservations/view_pending_reservations'?>">Volver</a>