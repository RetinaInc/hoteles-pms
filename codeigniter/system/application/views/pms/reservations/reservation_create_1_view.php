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

$this->load->view('pms/header'); 


echo 'NUEVA RESERVACIÓN - CHEQUEAR DISPONIBILIDAD'."<br><br>";

echo validation_errors();

if ($error != 1) {

	echo $error;
}

$attributes = array('name' => 'form1', 'id' => 'form1');

echo form_open(base_url().'reservations/createReservation1/', $attributes);?>

	<p>Tipo de habitación:
    <select name="reservation_room_type" id="reservation_room_type"><?php
		foreach ($roomTypes as $row) {?>
        
            <option value="<?php echo $row['id_room_type']; ?>" <?php echo set_select('reservation_room_type', $row['id_room_type']); ?> ><?php echo $row['name']; ?></option><?php 
		}?>
	</select>
    </p>
    
    <p>Fecha de llegada:			
	<input name="reservation_check_in" type="text" id="dateArrival" value="<?php echo set_value('reservation_check_in'); ?>" onClick="popUpCalendar(this, form1.dateArrival, 'dd-mm-yyyy');" size="10" maxlength="10">
    </p>
    
	<p>Fecha de salida:
    <input name="reservation_check_out" type="text" id="dateDeparture" onClick="popUpCalendar(this, form1.dateDeparture, 'dd-mm-yyyy');" value="<?php echo set_value('reservation_check_out'); ?>" size="10" maxlength="10">			
</p>
                
	 
   
<?php
echo form_submit('sumit', 'Buscar Habitación');
echo form_close();
?>

<a href="<?php echo base_url().'reservations/viewPendingReservations'?>">Volver</a>
