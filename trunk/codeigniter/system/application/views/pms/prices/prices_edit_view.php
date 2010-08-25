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

echo 'EDITAR PRECIOS'."<br><br>";

foreach ($season as $row) {
	
	$seasonId   = $row['id_season'];
	$seasonName = $row['name'];
	$dateStart  = $row['dateStart'];
	$dateEnd    = $row['dateEnd'];
	
	$dS_array = explode ('-',$dateStart);
	$year     = $dS_array[0];
	$month    = $dS_array[1];
	$day      = $dS_array[2];
	$dateS    = $day.'-'.$month.'-'.$year;
	
	$dE_array = explode ('-',$dateEnd);
	$year     = $dE_array[0];
	$month    = $dE_array[1];
	$day      = $dE_array[2];
	$dateE    = $day.'-'.$month.'-'.$year;	
	
	echo $seasonName.' ('.$dateS.' al '.$dateE.') <br>';
}

foreach ($rate as $row) {
	
	$rateId = $row['id_rate'];
	echo 'Tarifa ', $row['name']."<br>";
}

foreach ($plan as $row) {
	
	$planId = $row['id_plan'];
	echo 'Plan ', $row['name']."<br>";
}

foreach ($prices as $row) {

	$unPrice = $row['pricePerNight'];
}

echo form_open(base_url().'prices/editPrices2/'.$seasonId.'/'.$rateId.'/'.$planId);

?>
<p>Precio unico:
	<input name="un_price" type="text" id="un_price" onKeyPress="return numbersonly(this, event)" value="<?php echo $unPrice;?>" size="12" maxlength="12"/> 
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
		foreach ($prices as $row1) {
			$roomTypeId = $row['id_room_type'];
			if ($row1['fk_room_type'] == $row['id_room_type']) {
				$price = $row1['monPrice'];
				if ($price == $unPrice) {
					$price = NULL;
				} else {
					$price = $row1['monPrice'];
				}
	?>
	<td>
    <input name="mon_price<?php echo $roomTypeId?>" type="text" id="mon_price<?php echo $roomTypeId?>" onKeyPress="return numbersonly(this, event)" maxlength="12" value="<?php echo $price; ?>" />
    </td>
    <?php
			}
		}
	}
	?>
  	<td>Bs.F.</td>
  </tr>
  <tr>
    <td>Martes</td>
    <?php 
	foreach ($roomTypes as $row) {
		foreach ($prices as $row1) {
			$roomTypeId = $row['id_room_type'];
			if ($row1['fk_room_type'] == $row['id_room_type']) {
				$price = $row1['tuePrice'];
				if ($price == $unPrice) {
					$price = NULL;
				} else {
					$price = $row1['tuePrice'];
				}
	?>
	<td>
    <input name="tue_price<?php echo $roomTypeId?>" type="text" id="tue_price<?php echo $roomTypeId?>" onKeyPress="return numbersonly(this, event)" maxlength="12" value="<?php echo $price; ?>"/>
    </td>
    <?php
			}
		}
	}
	?>
    <td>Bs.F.</td>
  </tr>
  <tr>
    <td>Miércoles</td>
    <?php 
	foreach ($roomTypes as $row) {
		foreach ($prices as $row1) {
			$roomTypeId = $row['id_room_type'];
			if ($row1['fk_room_type'] == $row['id_room_type']) {
				$price = $row1['wedPrice'];
				if ($price == $unPrice) {
					$price = NULL;
				} else {
					$price = $row1['wedPrice'];
				}
	?>
	<td>
    <input name="wed_price<?php echo $roomTypeId?>" type="text" id="wed_price<?php echo $roomTypeId?>" onKeyPress="return numbersonly(this, event)" maxlength="12" value="<?php echo $price; ?>"/>
    </td>
    <?php
			}
		}
	}
	?>
    <td>Bs.F.</td>
  </tr>
  <tr>
    <td>Jueves</td>
    <?php 
	foreach ($roomTypes as $row) {
		foreach ($prices as $row1) {
			$roomTypeId = $row['id_room_type'];
			if ($row1['fk_room_type'] == $row['id_room_type']) {
				$price = $row1['thuPrice'];
				if ($price == $unPrice) {
					$price = NULL;
				} else {
					$price = $row1['thuPrice'];
				}
	?>
	<td>
    <input name="thu_price<?php echo $roomTypeId?>" type="text" id="thu_price<?php echo $roomTypeId?>" onKeyPress="return numbersonly(this, event)" maxlength="12" value="<?php echo $price; ?>"/>
    </td>
    <?php
			}
		}
	}
	?>
    <td>Bs.F.</td>
  </tr>
  <tr>
    <td>Viernes</td>
    <?php 
	foreach ($roomTypes as $row) {
		foreach ($prices as $row1) {
			$roomTypeId = $row['id_room_type'];
			if ($row1['fk_room_type'] == $row['id_room_type']) {
				$price = $row1['friPrice'];
				if ($price == $unPrice) {
					$price = NULL;
				} else {
					$price = $row1['friPrice'];
				}
	?>
	<td>
    <input name="fri_price<?php echo $roomTypeId?>" type="text" id="fri_price<?php echo $roomTypeId?>" onKeyPress="return numbersonly(this, event)" maxlength="12" value="<?php echo $price; ?>"/>
    </td>
    <?php
			}
		}
	}
	?>
    <td>Bs.F.</td>
  </tr>
  <tr>
    <td>Sábado</td>
    <?php 
	foreach ($roomTypes as $row) {
		foreach ($prices as $row1) {
			$roomTypeId = $row['id_room_type'];
			if ($row1['fk_room_type'] == $row['id_room_type']) {
				$price = $row1['satPrice'];
				if ($price == $unPrice) {
					$price = NULL;
				} else {
					$price = $row1['satPrice'];
				}
	?>
	<td>
    <input name="sat_price<?php echo $roomTypeId?>" type="text" id="sat_price<?php echo $roomTypeId?>" onKeyPress="return numbersonly(this, event)" maxlength="12" value="<?php echo $price; ?>"/>
    </td>
    <?php
			}
		}
	}
	?>
    <td>Bs.F.</td>
  </tr>
  <tr>
    <td>Domingo</td>
    <?php 
	foreach ($roomTypes as $row) {
		foreach ($prices as $row1) {
			$roomTypeId = $row['id_room_type'];
			if ($row1['fk_room_type'] == $row['id_room_type']) {
				$price = $row1['sunPrice'];
				if ($price == $unPrice) {
					$price = NULL;
				} else {
					$price = $row1['sunPrice'];
				}
	?>
	<td>
    <input name="sun_price<?php echo $roomTypeId?>" type="text" id="sun_price<?php echo $roomTypeId?>" onKeyPress="return numbersonly(this, event)" maxlength="12" value="<?php echo $price; ?>"/>
    </td>
    <?php
			}
		}
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

<a href="<?php echo base_url().'prices/checkPrices/'.$seasonId.'/'.$rateId.'/'.$planId?>" onClick="return confirm('Seguro que desea cancelar? Se perderá la información')">Cancelar</a>
