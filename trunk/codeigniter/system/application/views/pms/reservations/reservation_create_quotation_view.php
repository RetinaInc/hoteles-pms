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

</head>

<body>

<?php 

$this->load->view('pms/header'); 


echo 'COTIZACIÓN'."<br><br>";

echo validation_errors();

$attributes = array('name' => 'reservation', 'id' => 'reservation');

echo form_open(base_url().'reservations/createQuotation2/', $attributes);?>

<table width="452" border="0">
  <tr>
    <td width="87"></td>
    <td width="355"></td>
  </tr>
  <tr>
    <td>Habitaci&oacute;n:</td>
    <td>
    <?php
	foreach ($roomTypeInfo as $row) {
		echo $row['abrv'];
	}
	?>
    </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Llegada: </td>
    <td><?php
	$unixCi = human_to_unix($checkIn);
	echo date ("D  j/m/Y  " , $unixCi);
	echo form_hidden('check_in', $checkIn);
	?></td>
  </tr>
  <tr>
    <td>Salida: </td>
    <td><?php
	$unixCo = human_to_unix($checkOut);
	echo date ("D  j/m/Y  " , $unixCo);
	echo form_hidden('check_out', $checkOut);
	?></td>
  </tr>
  <tr>
    <td colspan="2"><?php echo '('.$nights.' noches)';?> </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>* Tarifa</td>
    <td>
     <select name="reservation_rate" id="reservation_rate">
    	<option value='' selected>Seleccione</option>
		<?php
        foreach($rates as $row) {
   		?>
        	<option value="<?php echo $row['id_rate'];?>" <?php echo set_select('reservation_rate', $row['id_rate']); ?> ><?php echo $row['name']; ?></option>
		<?php 
		} 
		?>
    </select>    </td>
  </tr>
  <tr>
    <td>* Plan</td>
    <td>
    <select name="reservation_plan" id="reservation_plan">
    	<option value='' selected>Seleccione</option>
		<?php
        foreach($plans as $row) {
   		?>
        	<option value="<?php echo $row['id_plan'];?>" <?php echo set_select('reservation_plan', $row['id_plan']); ?> ><?php echo $row['name']; ?></option>
		<?php 
		} 
		?>
    </select>    </td>
  </tr>
  <tr>
    <td>* Adultos: </td>
    <td>
    	<?php 
		foreach ($roomTypeInfo as $row) {
		
			$maxPers = $row['paxMax'];
		}
		?>
		<select name="reservation_adults" id="reservation_adults" onChange="redirect(this.options.selectedIndex)">
            <option value='' selected>Seleccione</option>
        <?php 
		for ($i = 1; $i <= $maxPers; $i++) {
			    
		    ?><option value="<?php echo $i; ?>" <?php echo set_select('reservation_adults', $i); ?> ><?php echo $i?></option><?php
		}
		?>
  		</select>
				
    <!-- <input name="reservation_adults2" type="text" id="reservation_adults2" value="<?php echo set_value('reservation_adults'); ?>" size="4" maxlength="4" onkeypress="return numbersonly(this, event)" />-->    </td>
  </tr>
  <tr>
    <td>* Ni&ntilde;os: </td>
    <td>
    <select name="reservation_children" id="reservation_children">
        <option value='0' selected>0</option>
	</select>
    <!--<select name="reservation_children" id="reservation_children">
    	<option value='' selected>''</option>
	</select>   -->
    <!-- <input name="reservation_children2" type="text" id="reservation_children2" value="<?php echo set_value('reservation_children'); ?>" size="4" maxlength="4" onKeyPress="return numbersonly(this, event)"/>-->    </td>
  </tr>
  <tr>
    <td height="52"><?php
		echo form_submit('sumit', 'Cotizar');
		echo form_close();
	?></td>
    <td>&nbsp;</td>
  </tr>
</table>
    
<p>
<a href="<?php echo base_url().'reservations/createReservation1'?>" onClick="return confirm('Seguro que desea volver? Se perderá la información')">Volver</a>
</p>



<script>
var groups=document.reservation.reservation_adults.options.length
var maxp = groups-1
var otro = maxp-1
var group=new Array(groups)
var j
var k
for (i=0; i<groups; i++)
group[i]=new Array()

group[0][0]=new Option("0","0")

for (j=1; j <= maxp; j++) {

    for (k=0; k <= otro; k++) {
	
        group[j][k]=new Option(otro-k,otro-k)

    }
	otro = otro-1
}


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
</html>