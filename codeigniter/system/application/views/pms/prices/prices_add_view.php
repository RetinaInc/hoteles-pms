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
		} else {
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

echo 'AGREGAR PRECIOS'."<br><br>";

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
echo form_open(base_url().'prices/addPricesPerNight/'.$seasonId.'/'.$rateId.'/'.$planId, $attributesPN);
?>
<br />
Precio por noche:
<br />
 <table width="295" border="1">
  <tr>
    <td width="163">Tipo de Hab</td>
    <td width="72">Precio</td>
    <td width="38">&nbsp;</td>
  </tr>
   <?php 
	foreach ($roomTypes as $row) {
	$roomTypeId = $row['id_room_type'];
	?>
    <tr>
    	<td width="163"><?php echo '* '.$row['name']; ?></td>
    	<td>
    	<input name="pricepn<?php echo $roomTypeId?>" type="text" id="pricepn<?php echo $roomTypeId?>" onKeyPress="return numbersonly(this, event)" value="<?php echo set_value('pricepn'.$roomTypeId); ?>" size="12" maxlength="12"/>    	</td>
   	    <td>Bs.F.</td>
    </tr>
   
    <?php
	}
	?>
  <tr>
    <td width="163"><strong>Ni�os</strong></td>
    <td width="72"><input name="pricepn_children" type="text" id="pricepn_children" onkeypress="return numbersonly(this, event)" value="<?php echo set_value('pricepn_children'); ?>" size="12" maxlength="12"/>    </td>
    <td width="38">Bs.F.</td>
  </tr>
  <tr>
   	<td width="163"><strong>3era edad</strong></td>
    <td>
    	<input name="pricepn_seniors" type="text" id="pricepn_seniors" onKeyPress="return numbersonly(this, event)" value="<?php echo set_value('pricepn_seniors'); ?>" size="12" maxlength="12"/>    	</td>
   	<td>Bs.F.</td>
   </tr>
</table>

<br />
<a href="#">Agregar precios seg�n d�a</a>
<br /><br />
<?php
echo form_submit('sumit', 'Enviar');
echo form_close();
?>
</div>

<div id="hasWeekdays">
<?php
$attributesED = array('id' => 'eachDay');
echo form_open(base_url().'prices/addPricesEachDay/'.$seasonId.'/'.$rateId.'/'.$planId, $attributesED);
?> 
<br />
Precio por noche seg�n el d�a:
<br />
<table width="929" border="1">
  <tr>
    <td width="150">&nbsp;</td>
    <td width="80">Lunes</td>
    <td width="80">Martes</td>
    <td width="80">Mi�rcoles</td>
    <td width="80">Jueves</td>
    <td width="80">Viernes</td>
    <td width="80">S�bado</td>
    <td width="80">Domingo</td>
    <td width="50">&nbsp;</td>
  </tr>
  	<?php 
	foreach ($roomTypes as $row) {
	$roomTypeId = $row['id_room_type'];
	?>
  <tr>
    <td><?php echo '* '.$row['name']; ?></td>
    <td><input name="mon_price<?php echo $roomTypeId?>" type="text" id="mon_price<?php echo $roomTypeId?>" onkeypress="return numbersonly(this, event)" value="<?php echo set_value('mon_price'.$roomTypeId); ?>" size="12" maxlength="12"/></td>
    <td><input name="tue_price<?php echo $roomTypeId?>" type="text" id="tue_price<?php echo $roomTypeId?>" onkeypress="return numbersonly(this, event)" value="<?php echo set_value('tue_price'.$roomTypeId); ?>" size="12" maxlength="12"/></td>
    <td><input name="wed_price<?php echo $roomTypeId?>" type="text" id="wed_price<?php echo $roomTypeId?>" onkeypress="return numbersonly(this, event)" value="<?php echo set_value('wed_price'.$roomTypeId); ?>" size="12" maxlength="12"/></td>
    <td><input name="thu_price<?php echo $roomTypeId?>" type="text" id="thu_price<?php echo $roomTypeId?>" onkeypress="return numbersonly(this, event)" value="<?php echo set_value('thu_price'.$roomTypeId); ?>" size="12" maxlength="12"/></td>
    <td><input name="fri_price<?php echo $roomTypeId?>" type="text" id="fri_price<?php echo $roomTypeId?>" onkeypress="return numbersonly(this, event)" value="<?php echo set_value('fri_price'.$roomTypeId); ?>" size="12" maxlength="12"/></td>
    <td><input name="sat_price<?php echo $roomTypeId?>" type="text" id="sat_price<?php echo $roomTypeId?>" onkeypress="return numbersonly(this, event)" value="<?php echo set_value('sat_price'.$roomTypeId); ?>" size="12" maxlength="12"/></td>
    <td><input name="sun_price<?php echo $roomTypeId?>" type="text" id="sun_price<?php echo $roomTypeId?>" onkeypress="return numbersonly(this, event)" value="<?php echo set_value('sun_price'.$roomTypeId); ?>" size="12" maxlength="12"/></td>
    <td>Bs.F.</td>
  </tr>
  <?php
  }
  ?>
  <tr>
    <td><strong>Ni�os</strong></td>
    <td><input name="mon_price_children" type="text" id="mon_price_children" onkeypress="return numbersonly(this, event)" value="<?php echo set_value('mon_price_children'); ?>" size="12" maxlength="12"/></td>
    <td><input name="tue_price_children" type="text" id="tue_price_children" onkeypress="return numbersonly(this, event)" value="<?php echo set_value('tue_price_children'); ?>" size="12" maxlength="12"/></td>
    <td><input name="wed_price_children" type="text" id="wed_price_children" onkeypress="return numbersonly(this, event)" value="<?php echo set_value('wed_price_children'); ?>" size="12" maxlength="12"/></td>
    <td><input name="thu_price_children" type="text" id="thu_price_children" onkeypress="return numbersonly(this, event)" value="<?php echo set_value('thu_price_children'); ?>" size="12" maxlength="12"/></td>
    <td><input name="fri_price_children" type="text" id="fri_price_children" onkeypress="return numbersonly(this, event)" value="<?php echo set_value('fri_price_children'); ?>" size="12" maxlength="12"/></td>
    <td><input name="sat_price_children" type="text" id="sat_price_children" onkeypress="return numbersonly(this, event)" value="<?php echo set_value('sat_price_children'); ?>" size="12" maxlength="12"/></td>
    <td><input name="sun_price_children" type="text" id="sun_price_children" onkeypress="return numbersonly(this, event)" value="<?php echo set_value('sun_price_children'); ?>" size="12" maxlength="12"/></td>
    <td>Bs.F.</td>
  </tr>
  <tr>
    <td><strong>3era edad</strong></td>
    <td><input name="mon_price_seniors" type="text" id="mon_price_seniors" onkeypress="return numbersonly(this, event)" value="<?php echo set_value('mon_price_seniors'); ?>" size="12" maxlength="12"/></td>
    <td><input name="tue_price_seniors" type="text" id="tue_price_seniors" onkeypress="return numbersonly(this, event)" value="<?php echo set_value('tue_price_seniors'); ?>" size="12" maxlength="12"/></td>
    <td><input name="wed_price_seniors" type="text" id="wed_price_seniors" onkeypress="return numbersonly(this, event)" value="<?php echo set_value('wed_price_seniors'); ?>" size="12" maxlength="12"/></td>
    <td><input name="thu_price_seniors" type="text" id="thu_price_seniors" onkeypress="return numbersonly(this, event)" value="<?php echo set_value('thu_price_seniors'); ?>" size="12" maxlength="12"/></td>
    <td><input name="fri_price_seniors" type="text" id="fri_price_seniors" onkeypress="return numbersonly(this, event)" value="<?php echo set_value('fri_price_seniors'); ?>" size="12" maxlength="12"/></td>
    <td><input name="sat_price_seniors" type="text" id="sat_price_seniors" onkeypress="return numbersonly(this, event)" value="<?php echo set_value('sat_price_seniors'); ?>" size="12" maxlength="12"/></td>
    <td><input name="sun_price_seniors" type="text" id="sun_price_seniors" onkeypress="return numbersonly(this, event)" value="<?php echo set_value('sun_price_seniors'); ?>" size="12" maxlength="12"/></td>
    <td>Bs.F.</td>
  </tr>
</table>
<br />
<a href="#">Agregar �nico precio por noche</a>
<br /><br />
<?php
echo form_submit('sumit', 'Enviar');
echo form_close();
?>
</div>

<p><a href="<?php echo base_url().'prices/selectPlanPrices/'.$seasonId.'/'.$rateId?>" onClick="return confirm('Seguro que desea cancelar? Se perder� la informaci�n')">Cancelar</a></p>