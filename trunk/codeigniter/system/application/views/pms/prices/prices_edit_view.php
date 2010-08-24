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

echo 'AGREGAR PRECIOS'."<br><br>";

foreach ($season as $row) {
	
	$seasonId = $row['id_season'];
	echo 'TEMPORADA: ', $row['name']."<br>";
	echo 'Fecha Inicio: ', $row['dateStart']."<br>";
	echo 'Fecha Fin: ', $row['dateEnd']."<br>";
}

foreach ($rate as $row) {
	
	$rateId = $row['id_rate'];
	echo 'TARIFA: ', $row['name']."<br>";
}

foreach ($plan as $row) {
	
	$planId = $row['id_plan'];
	echo 'PLAN: ', $row['name']."<br>";
}

echo form_open(base_url().'prices/editPrices2/'.$seasonId.'/'.$rateId.'/'.$planId);
?>
<p>Precio unico:
	<input type="text" name="un_price" id="un_price" onKeyPress="return numbersonly(this, event)"/> 
	Bs.F.
</p>
 
  <p>Precio por día (Si se deja alguno en blanco se tomará el precio unico para ese día):</p>
<table width="400" border="1">
  <tr>
    <td width="69">&nbsp;</td>
    <?php 
	foreach ($roomTypes as $row) {
	?>
    <td width="315"><?php echo $row['name']; ?></td>
    <?php
	}
	?>
  </tr>
  <tr>
    <td>Lunes</td>
    <?php 
	foreach ($roomTypes as $row) {
	$roomTypeId = $row['id_room_type'];
	?>
	<td>
    <input type="text" name="mon_price<?php echo $roomTypeId?>" id="mon_price<?php echo $roomTypeId?>" onKeyPress="return numbersonly(this, event)" />
    </td>
    <?php
	}
	?>
  	<td>Bs.F.</td>
  </tr>
  <tr>
    <td>Martes</td>
    <?php 
	foreach ($roomTypes as $row) {
	$roomTypeId = $row['id_room_type'];
	?>
	<td>
    <input type="text" name="tue_price<?php echo $roomTypeId?>" id="tue_price<?php echo $roomTypeId?>" onKeyPress="return numbersonly(this, event)"/>
    </td>
    <?php
	}
	?>
    <td>Bs.F.</td>
  </tr>
  <tr>
    <td>Miércoles</td>
    <?php 
	foreach ($roomTypes as $row) {
	$roomTypeId = $row['id_room_type'];
	?>
	<td>
    <input type="text" name="wed_price<?php echo $roomTypeId?>" id="wed_price<?php echo $roomTypeId?>" onKeyPress="return numbersonly(this, event)"/>
    </td>
    <?php
	}
	?>
    <td>Bs.F.</td>
  </tr>
  <tr>
    <td>Jueves</td>
    <?php 
	foreach ($roomTypes as $row) {
	$roomTypeId = $row['id_room_type'];
	?>
	<td>
    <input type="text" name="thu_price<?php echo $roomTypeId?>" id="thu_price<?php echo $roomTypeId?>" onKeyPress="return numbersonly(this, event)"/>
    </td>
    <?php
	}
	?>
    <td>Bs.F.</td>
  </tr>
  <tr>
    <td>Viernes</td>
    <?php 
	foreach ($roomTypes as $row) {
	$roomTypeId = $row['id_room_type'];
	?>
	<td>
    <input type="text" name="fri_price<?php echo $roomTypeId?>" id="fri_price<?php echo $roomTypeId?>" onKeyPress="return numbersonly(this, event)"/>
    </td>
    <?php
	}
	?>
    <td>Bs.F.</td>
  </tr>
  <tr>
    <td>Sábado</td>
    <?php 
	foreach ($roomTypes as $row) {
	$roomTypeId = $row['id_room_type'];
	?>
	<td>
    <input type="text" name="sat_price<?php echo $roomTypeId?>" id="sat_price<?php echo $roomTypeId?>" onKeyPress="return numbersonly(this, event)"/>
    </td>
    <?php
	}
	?>
    <td>Bs.F.</td>
  </tr>
  <tr>
    <td>Domingo</td>
    <?php 
	foreach ($roomTypes as $row) {
	$roomTypeId = $row['id_room_type'];
	?>
	<td>
    <input type="text" name="sun_price<?php echo $roomTypeId?>" id="sun_price<?php echo $roomTypeId?>" onKeyPress="return numbersonly(this, event)"/>
    </td>
    <?php
	}
	?>
    <td>Bs.F.</td>
  </tr>
</table>
<br />
<?php
echo form_submit('sumit', 'Enviar');
echo form_close();
?>
