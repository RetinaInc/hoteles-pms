
<html>
<head>

<script language='javascript' src="<?php echo base_url() . "assets/calendario/"?>popcalendar.js"></script>
<script type="text/javascript" src="<?php echo base_url() . "assets/js/jquery-1.3.2.min.js" ?>"></script>

<script type="text/javascript">

	$(function(){
		
		$('.prueba').change(function(){
		
			$('#table2').children().remove();
			
			var rooms = $('#reservation_room_count').val();
			var i
			for (i=2; i<=rooms; i++) {
				var guests = '<tr>';
					guests += '<td height="35" width="123">* Habitaci&oacute;n ' + i +':</td>';
					guests += '<td width="124">Adultos: ';
					guests += '<select name="reservation_adults' + i +'" id="reservation_adults' + i +'">';
					guests += '<option value="1" <?php echo set_select('reservation_adults', '1'); ?> selected="selected">1</option>';
					guests += '<option value="2" <?php echo set_select('reservation_adults', '2'); ?> >2</option>';
					guests += '<option value="3" <?php echo set_select('reservation_adults', '3'); ?> >3</option>';
					guests += '<option value="4" <?php echo set_select('reservation_adults', '4'); ?> >4</option>';
					guests += '<option value="5" <?php echo set_select('reservation_adults', '5'); ?> >5</option>';
					guests += '<option value="6" <?php echo set_select('reservation_adults', '6'); ?> >6</option>';
					guests += '</select>';
					guests += '</td>';
					
					guests += '<td width="116">Ni&ntilde;os:  ';
					guests += '<select name="reservation_children' + i +'" id="reservation_children' + i +'">';
					guests += '<option value="0" <?php echo set_select('reservation_children', '0'); ?> selected="selected">0</option>';
					guests += '<option value="1" <?php echo set_select('reservation_children', '1'); ?> >1</option>';
					guests += '<option value="2" <?php echo set_select('reservation_children', '2'); ?> >2</option>';
					guests += '<option value="3" <?php echo set_select('reservation_children', '3'); ?> >3</option>';
					guests += '<option value="4" <?php echo set_select('reservation_children', '4'); ?> >4</option>';
					guests += '<option value="5" <?php echo set_select('reservation_children', '5'); ?> >5</option>';
					guests += '</select>';
					guests += '</td>';
					guests += '</tr>';
					
				$('#table2').append(guests);
			}
		});
	});
</script>

<style type="text/css">
<!--
.Estilo1 {color: #FF0000}
-->
</style>

</head>

<body>
<?php 

$this->load->view('pms/header'); 


echo 'NUEVA RESERVACI&Oacute;N - CHEQUEAR DISPONIBILIDAD'."<br><br>";

?><span class="Estilo1"><?php echo validation_errors(); ?></span><?php

if ($error != 1) {
	?><span class="Estilo1"><?php echo $error."<br><br>"; ?></span><?php
}

$attributes = array('name' => 'form1', 'id' => 'form1');

echo form_open(base_url().'reservations/createReservation1/', $attributes);?>


<table width="374" border="0">
  <tr>
    <td width="120" height="35">* Fecha llegada: </td>
    <td colspan="2"><input name="reservation_check_in" type="text" id="dateArrival" value="<?php echo set_value('reservation_check_in'); ?>" onClick="popUpCalendar(this, form1.dateArrival, 'dd-mm-yyyy');" size="10" maxlength="10" /></td>
  </tr>
  <tr>
    <td height="35">* Fecha salida: </td>
    <td colspan="2"><input name="reservation_check_out" type="text" id="dateDeparture" onClick="popUpCalendar(this, form1.dateDeparture, 'dd-mm-yyyy');" value="<?php echo set_value('reservation_check_out'); ?>" size="10" maxlength="10" /></td>
  </tr>
  <tr>
    <td height="35">* Tarifa: </td>
    <td colspan="2"> 
     <select name="reservation_rate" id="reservation_rate">
    	<?php
		foreach ($rates as $row) {
			?>
			<option value="<?php echo $row['id_rate']; ?>" <?php echo set_select('reservation_rate', $row['id_rate']); ?> ><?php echo $row['name']; ?></option>
       		<?php
		}
		?>
    </select>
    </td>
  </tr>
  <tr>
    <td height="35">* Plan: </td>
    <td colspan="2">
    <select name="reservation_plan" id="reservation_plan">
    	<?php
		foreach ($plans as $row) {
			?>
			<option value="<?php echo $row['id_plan']; ?>" <?php echo set_select('reservation_plan', $row['id_plan']); ?> ><?php echo $row['name']; ?></option>
       		<?php
		}
		?>
    </select>
    </td>
  </tr>
  <tr>
    <td height="35">* Habitaciones:</td>
    <td colspan="2">
    <select name="reservation_room_count" id="reservation_room_count" class="prueba">
      <option value="1" <?php echo set_select('reservation_room_count', '1'); ?> selected>1</option>
      <option value="2" <?php echo set_select('reservation_room_count', '2'); ?> >2</option>
      <option value="3" <?php echo set_select('reservation_room_count', '3'); ?> >3</option>
      <option value="4" <?php echo set_select('reservation_room_count', '4'); ?> >4</option>
      <option value="5" <?php echo set_select('reservation_room_count', '5'); ?> >5</option>    
	</select>   </td>
  </tr>

  <tr>
    <td height="35">* Habitaci&oacute;n 1:</td>
    <td width="124">Adultos: 
      <select name="reservation_adults1" id="reservation_adults1">
        <option value="1" <?php echo set_select('reservation_adults', '1'); ?> selected="selected">1</option>
        <option value="2" <?php echo set_select('reservation_adults', '2'); ?> >2</option>
        <option value="3" <?php echo set_select('reservation_adults', '3'); ?> >3</option>
        <option value="4" <?php echo set_select('reservation_adults', '4'); ?> >4</option>
        <option value="5" <?php echo set_select('reservation_adults', '5'); ?> >5</option>
        <option value="6" <?php echo set_select('reservation_adults', '6'); ?> >6</option>
      </select></td>
    <td width="116">Ni&ntilde;os: 
      <select name="reservation_children1" id="reservation_children1">
        <option value="0" <?php echo set_select('reservation_children', '0'); ?> selected="selected">0</option>
        <option value="1" <?php echo set_select('reservation_children', '1'); ?> >1</option>
        <option value="2" <?php echo set_select('reservation_children', '2'); ?> >2</option>
        <option value="3" <?php echo set_select('reservation_children', '3'); ?> >3</option>
        <option value="4" <?php echo set_select('reservation_children', '4'); ?> >4</option>
        <option value="5" <?php echo set_select('reservation_children', '5'); ?> >5</option>
      </select>      </td>
  </tr>
</table>

<table id="table2">
</table>

<?php 
echo "<br>";
echo form_submit('sumit', 'Buscar');
echo form_close(); 
?>
   
<br />
<a href="<?php echo base_url().'reservations/viewPendingReservations'?>">Volver</a>

</body>
</html>