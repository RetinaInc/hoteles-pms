<html>

<head>

<script type="text/javascript" src="<?php echo base_url()."assets/js/jquery-1.3.2.min.js" ?>"></script>

<script type="text/javascript">

	$(function(){
		
		<?php 
		if ($type == 'hasWeekdays') {
			?>
				$('#noWeekdays').hide();
				$('#hasWeekdays').show();
			<?php
		}
		else {
		?>
			$('#hasWeekdays').hide();
			$('#noWeekdays').show();

		<?php
		}
		?>
		
		$('#noWeekdays a').click(function(){
				$('#noWeekdays').hide();
				$('#hasWeekdays').show();
		});
		
		$('#hasWeekdays a').click(function(){
				$('#hasWeekdays').hide();
				$('#noWeekdays').show();
		});
	});

</script>

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

<style type="text/css">
<!--
.Estilo1 {color: #FF0000}
-->
</style>

</head>

<?php 

$this->load->view('pms/header'); 

echo 'EDITAR PRECIOS'."<br><br>";


if ($error != 1) {
	?><span class="Estilo1"><?php echo $error."<br><br>"; ?></span><?php
}

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
?>

<div id="noWeekdays">
<?php
$attributesPN = array('id' => 'perNight');
echo form_open(base_url().'prices/editPricesPerNight/'.$seasonId.'/'.$rateId.'/'.$planId, $attributesPN);
?>
<br />
Precio por noche:
<br />
 <table width="303" border="1">
  <tr>
    <td width="163">Tipo de Hab</td>
    <td width="72">Precio</td>
    <td width="46">&nbsp;</td>
  </tr>
   <?php 
	foreach ($roomTypes as $row) {
	$roomTypeId = $row['id_room_type'];
	?>
    <tr>
    	<td width="163"><?php echo '* '.$row['name']; ?></td>
        <?php 
		foreach ($prices as $row1) {
			if ($row1['fk_room_type'] == $row['id_room_type']) {
				$pricePerNight = $row1['pricePerNight'];
			}
		}
		?>
    	<td>
        <input name="pricepn<?php echo $roomTypeId?>" type="text" id="pricepn<?php echo $roomTypeId?>" onKeyPress="return numbersonly(this, event)" 
        value="<?php 
			if ($pricePerNight == NULL) {
				echo set_value('pricepn'.$roomTypeId);
			} else {
				echo $pricePerNight; 
			}
			?>" 
        size="12" maxlength="12"/>  
        </td>
   	    <td>Bs.F.</td>
    </tr>
    <?php
	}
	
	?>
    <tr>
    	<td width="163"><strong>Niños</strong></td>
		<?php
		foreach ($prices as $row) {
			if ($row['persType'] == 'Children') {
				$priceChildren = $row['pricePerNight'];
			}
		}
		?>
    	<td width="72">
		<input name="pricepn_children" type="text" id="pricepn_children" onkeypress="return numbersonly(this, event)" 
        value="<?php 
			if ($priceChildren == NULL) {
				echo set_value('pricepn_children');
			} else {
				echo $priceChildren; 
			}
			?>" 
        size="12" maxlength="12"/>
        </td>
    	<td width="46">Bs.F.</td>
  	</tr>
    <tr>
    	<td width="163"><strong>3era edad</strong></td>
  		<?php
		foreach ($prices as $row) {
			if ($row['persType'] == 'Seniors') {
				$priceSeniors = $row['pricePerNight'];
			}
		}
		?>
        <td width="72">
		<input name="pricepn_seniors" type="text" id="pricepn_seniors" onkeypress="return numbersonly(this, event)" 
        value="<?php 
			if ($priceSeniors == NULL) {
				echo set_value('pricepn_seniors');
			} else {
				echo $priceSeniors; 
			}
			?>" 
        size="12" maxlength="12"/>
        </td>
    	<td width="46">Bs.F.</td>
  	</tr>
</table>
<br />
<a href="#">Agregar precios según día</a>
<br /><br />
<?php
echo form_submit('sumit', 'Enviar');
echo form_close();
?>
</div>


<div id="hasWeekdays">
<?php
$attributesED = array('id' => 'eachDay');
echo form_open(base_url().'prices/editPricesEachDay/'.$seasonId.'/'.$rateId.'/'.$planId, $attributesED);
?> 
<br />
Precio por noche según el día:
<br />
<table width="926" border="1">
  <tr>
    <td width="256">&nbsp;</td>
    <td width="87">Lunes</td>
    <td width="78">Martes</td>
    <td width="72">Miércoles</td>
    <td width="72">Jueves</td>
    <td width="72">Viernes</td>
    <td width="72">Sábado</td>
    <td width="72">Domingo</td>
    <td width="87">&nbsp;</td>
  </tr>
  	<?php 
	foreach ($roomTypes as $row) {
	$roomTypeId = $row['id_room_type'];
	?>
  <tr>
    <td><?php echo '* '.$row['name']; ?></td>
    <?php
	foreach ($prices as $row1) {
		if ($row1['fk_room_type'] == $row['id_room_type']) {
			$monPrice = $row1['monPrice'];
			$tuePrice = $row1['tuePrice'];
			$wedPrice = $row1['wedPrice'];
			$thuPrice = $row1['thuPrice'];
			$friPrice = $row1['friPrice'];
			$satPrice = $row1['satPrice'];
			$sunPrice = $row1['sunPrice'];
		}
	}
	?>
    <td>
    <input name="mon_price<?php echo $roomTypeId?>" type="text" id="mon_price<?php echo $roomTypeId?>" onkeypress="return numbersonly(this, event)" 
    value="<?php 
			if ($monPrice == NULL) {
				echo set_value('mon_price'.$roomTypeId);
			} else {
				echo $monPrice; 
			}
		?>" 
    size="12" maxlength="12"/>
    </td>
    <td>
    <input name="tue_price<?php echo $roomTypeId?>" type="text" id="tue_price<?php echo $roomTypeId?>" onkeypress="return numbersonly(this, event)" 
    value="<?php 
			if ($tuePrice == NULL) {
				echo set_value('tue_price'.$roomTypeId);
			} else {
				echo $tuePrice; 
			}			
			?>" 
    size="12" maxlength="12"/>
    </td>
    <td>
    <input name="wed_price<?php echo $roomTypeId?>" type="text" id="wed_price<?php echo $roomTypeId?>" onkeypress="return numbersonly(this, event)" 
    value="<?php 
			if ($wedPrice == NULL) {
				echo set_value('wed_price'.$roomTypeId);
			} else {
				echo $wedPrice; 
			} 
			?>" 
    size="12" maxlength="12"/>
    </td>
    <td>
    <input name="thu_price<?php echo $roomTypeId?>" type="text" id="thu_price<?php echo $roomTypeId?>" onkeypress="return numbersonly(this, event)" 
    value="<?php 
			if ($thuPrice == NULL) {
				echo set_value('thu_price'.$roomTypeId);
			} else {
				echo $thuPrice; 
			}
			?>" 
    size="12" maxlength="12"/>
    </td>
    <td>
    <input name="fri_price<?php echo $roomTypeId?>" type="text" id="fri_price<?php echo $roomTypeId?>" onkeypress="return numbersonly(this, event)" 
    value="<?php 
			if ($friPrice == NULL) {
				echo set_value('fri_price'.$roomTypeId);
			} else {
				echo $friPrice; 
			}
			?>" 
    size="12" maxlength="12"/>
    </td>
    <td>
    <input name="sat_price<?php echo $roomTypeId?>" type="text" id="sat_price<?php echo $roomTypeId?>" onkeypress="return numbersonly(this, event)" 
    value="<?php 
			if ($satPrice == NULL) {
				echo set_value('sat_price'.$roomTypeId);
			} else {
				echo $satPrice; 
			} 
			?>" 
    size="12" maxlength="12"/>
    </td>
    <td>
    <input name="sun_price<?php echo $roomTypeId?>" type="text" id="sun_price<?php echo $roomTypeId?>" onkeypress="return numbersonly(this, event)" 
    value="<?php 
			if ($sunPrice == NULL) {
				echo set_value('sun_price'.$roomTypeId);
			} else {
				echo $sunPrice; 
			}
			?>" 
    size="12" maxlength="12"/>
    </td>
    <td>Bs.F.</td>
  </tr>
  <?php
  }

	foreach ($prices as $row) {
		if ($row['persType'] == 'Children') {
			$monPriceC = $row['monPrice'];
			$tuePriceC = $row['tuePrice'];
			$wedPriceC = $row['wedPrice'];
			$thuPriceC = $row['thuPrice'];
			$friPriceC = $row['friPrice'];
			$satPriceC = $row['satPrice'];
			$sunPriceC = $row['sunPrice'];
		}
	}
	?>
  <tr>
    <td><strong>Niños</strong></td>
    <td>
    <input name="mon_price_children" type="text" id="mon_price_children" onkeypress="return numbersonly(this, event)" 
    value="<?php 
			if ($monPriceC == NULL) {
				echo set_value('mon_price_children');
			} else {
				echo $monPriceC; 
			}
			?>" 
    size="12" maxlength="12"/>
    </td>
    <td>
    <input name="tue_price_children" type="text" id="tue_price_children" onkeypress="return numbersonly(this, event)" 
    value="<?php 
			if ($tuePriceC == NULL) {
				echo set_value('tue_price_children');
			} else {
				echo $tuePriceC; 
			}
			?>" 
    size="12" maxlength="12"/>
    </td>
    <td>
    <input name="wed_price_children" type="text" id="wed_price_children" onkeypress="return numbersonly(this, event)" 
    value="<?php 
			if ($wedPriceC == NULL) {
				echo set_value('wed_price_children');
			} else {
				echo $wedPriceC; 
			}
			?>" 
    size="12" maxlength="12"/>
    </td>
    <td>
    <input name="thu_price_children" type="text" id="thu_price_children" onkeypress="return numbersonly(this, event)" 
    value="<?php 
			if ($thuPriceC == NULL) {
				echo set_value('thu_price_children');
			} else {
				echo $thuPriceC; 
			}
			?>" 
    size="12" maxlength="12"/>
    </td>
    <td>
    <input name="fri_price_children" type="text" id="fri_price_children" onkeypress="return numbersonly(this, event)" 
    value="<?php 
			if ($friPriceC == NULL) {
				echo set_value('fri_price_children');
			} else {
				echo $friPriceC; 
			}
			?>" 
    size="12" maxlength="12"/>
    </td>
    <td>
    <input name="sat_price_children" type="text" id="sat_price_children" onkeypress="return numbersonly(this, event)" 
    value="<?php 
			if ($satPriceC == NULL) {
				echo set_value('sat_price_children');
			} else {
				echo $satPriceC; 
			} 
			?>" 
    size="12" maxlength="12"/>
    </td>
    <td>
    <input name="sun_price_children" type="text" id="sun_price_children" onkeypress="return numbersonly(this, event)" 
    value="<?php 
			if ($sunPriceC == NULL) {
				echo set_value('sun_price_children');
			} else {
				echo $sunPriceC; 
			}
			?>" 
    size="12" maxlength="12"/>
    </td>
    <td>Bs.F.</td>
  </tr>
        
	<?php
	foreach ($prices as $row) {
	
		if ($row['persType'] == 'Seniors') {
		
			$monPriceS = $row['monPrice'];
			$tuePriceS = $row['tuePrice'];
			$wedPriceS = $row['wedPrice'];
			$thuPriceS = $row['thuPrice'];
			$friPriceS = $row['friPrice'];
			$satPriceS = $row['satPrice'];
			$sunPriceS = $row['sunPrice'];
		}
	}
	?>
  <tr>
    <td><strong>3era edad</strong></td>
    <td>
    <input name="mon_price_seniors" type="text" id="mon_price_seniors" onkeypress="return numbersonly(this, event)" 
    value="<?php 
			if ($monPriceS == NULL) {
				echo set_value('mon_price_seniors');
			} else {
				echo $monPriceS; 
			}			
			?>" 
    size="12" maxlength="12"/>
    </td>
    <td>
    <input name="tue_price_seniors" type="text" id="tue_price_seniors" onkeypress="return numbersonly(this, event)" 
    value="<?php 
			if ($tuePriceS == NULL) {
				echo set_value('tue_price_seniors');
			} else {
				echo $tuePriceS; 
			}	 
			?>" 
    size="12" maxlength="12"/>
    </td>
    <td>
    <input name="wed_price_seniors" type="text" id="wed_price_seniors" onkeypress="return numbersonly(this, event)" 
    value="<?php 
			if ($wedPriceS == NULL) {
				echo set_value('wed_price_seniors');
			} else {
				echo $wedPriceS; 
			}	
			?>" 
    size="12" maxlength="12"/>
    </td>
    <td>
    <input name="thu_price_seniors" type="text" id="thu_price_seniors" onkeypress="return numbersonly(this, event)" 
    value="<?php 
			if ($thuPriceS == NULL) {
				echo set_value('thu_price_seniors');
			} else {
				echo $thuPriceS; 
			}	
			?>" 
    size="12" maxlength="12"/>
    </td>
    <td>
    <input name="fri_price_seniors" type="text" id="fri_price_seniors" onkeypress="return numbersonly(this, event)" 
    value="<?php 
			if ($friPriceS == NULL) {
				echo set_value('fri_price_seniors');
			} else {
				echo $friPriceS; 
			}	
			?>" 
    size="12" maxlength="12"/>
    </td>
    <td>
    <input name="sat_price_seniors" type="text" id="sat_price_seniors" onkeypress="return numbersonly(this, event)" 
    value="<?php 
			if ($satPriceS == NULL) {
				echo set_value('sat_price_seniors');
			} else {
				echo $satPriceS; 
			}	
			?>" 
    size="12" maxlength="12"/>
    </td>
    <td>
    <input name="sun_price_seniors" type="text" id="sun_price_seniors" onkeypress="return numbersonly(this, event)" 
    value="<?php 
			if ($sunPriceS == NULL) {
				echo set_value('sun_price_seniors');
			} else {
				echo $sunPriceS; 
			}	
			?>" 
    size="12" maxlength="12"/>
    </td>
    <td>Bs.F.</td>
  </tr>
</table>
<br />
<a href="#">Agregar único precio por noche</a>
<br /><br />
<?php
echo form_submit('sumit', 'Enviar');
echo form_close();
?>
</div>

<a href="<?php echo base_url().'prices/checkPrices/'.$seasonId.'/'.$rateId.'/'.$planId?>" onClick="return confirm('Seguro que desea cancelar? Se perderá la información')">Cancelar</a>

</html>