
<?php
$this->load->view('pms/header'); 
?>

<script type="text/javascript">

	$(function(){
		
		var rooms = $('#reservation_room_count').val();
		
		var i
		var j
			
		for (i=2; i<=rooms; i++) {
		
			var guests = '<tr>';
				guests += '<td height="35" width="160">* Habitaci&oacute;n ' + i +':</td>';
				guests += '<td width="160">Adultos: ';
				guests += '<select name="reservation_adults' + i +'" id="reservation_adults' + i +'">';
				guests += '<option value="1" <?php echo set_select('reservation_adults', '1'); ?> selected="selected">1</option>';
				guests += '<option value="2" <?php echo set_select('reservation_adults', '2'); ?> >2</option>';
				guests += '<option value="3" <?php echo set_select('reservation_adults', '3'); ?> >3</option>';
				guests += '<option value="4" <?php echo set_select('reservation_adults', '4'); ?> >4</option>';
				guests += '<option value="5" <?php echo set_select('reservation_adults', '5'); ?> >5</option>';
				guests += '<option value="6" <?php echo set_select('reservation_adults', '6'); ?> >6</option>';
				guests += '</select>';
				guests += '</td>';
				
				guests += '<td width="160">Ni&ntilde;os:  ';
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
			
		$('.prueba').change(function(){
		
			$('#table2').children().remove();
			
			var rooms = $('#reservation_room_count').val();
			
			for (i=2; i<=rooms; i++) {
			
				var guests = '<tr>';
					guests += '<td height="35" width="160">* Habitaci&oacute;n ' + i +':</td>';
					guests += '<td width="160">Adultos: ';
					guests += '<select name="reservation_adults' + i +'" id="reservation_adults' + i +'">';
					guests += '<option value="1" <?php echo set_select('reservation_adults2', '1'); ?> >1</option>';
					guests += '<option value="2" <?php echo set_select('reservation_adults2', '2'); ?> >2</option>';
					guests += '<option value="3" <?php echo set_select('reservation_adults2', '3'); ?> >3</option>';
					guests += '<option value="4" <?php echo set_select('reservation_adults2', '4'); ?> >4</option>';
					guests += '<option value="5" <?php echo set_select('reservation_adults2', '5'); ?> >5</option>';
					guests += '<option value="6" <?php echo set_select('reservation_adults2', '6'); ?> >6</option>';
					guests += '</select>';
					guests += '</td>';
					
					guests += '<td width="160">Ni&ntilde;os:  ';
					guests += '<select name="reservation_children' + i +'" id="reservation_children' + i +'">';
					guests += '<option value="0" <?php echo set_select('reservation_children', '0'); ?> >0</option>';
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

<h3>Nueva Reservación - Chequear Disponibilidad</h3>

<span class="Estilo2">
	(*)Campos obligatorios
</span>

<span class="Estilo1">
	<?php
	echo validation_errors();
	?>
</span>

<?php
if (isset($error)) {

	if ($error != 1) {
	
		echo "<br><br>";
		echo "<span class='Estilo1'>".$error."</span>";
	}
}


$attributes = array('name' => 'form1', 'id' => 'form1');
echo form_open('reservations/createReservation1/', $attributes);

?>

<br />
<table width="494" border="0">

  <tr>
    <td width="160" height="35">* Fecha llegada: </td>
    
    <td colspan="3">
        <input name="reservation_check_in" type="text" id="dateArrival" value="<?php echo set_value('reservation_check_in'); ?>" 
        onClick="popUpCalendar(this, form1.dateArrival, 'dd-mm-yyyy');" onKeyPress="return rifnumbers(this, event)" size="10" maxlength="10" />  
        <span class="Estilo2">(dd - mm - yyyy)</span>  
   	</td>
  </tr>
  
  <tr>
    <td height="35">* Fecha salida: </td>
    
    <td colspan="3">
        <input name="reservation_check_out" type="text" id="dateDeparture" value="<?php echo set_value('reservation_check_out'); ?>" onClick="popUpCalendar(this, form1.dateDeparture, 'dd-mm-yyyy');" onKeyPress="return rifnumbers(this, event)" size="10" maxlength="10" />   
    	<span class="Estilo2">(dd - mm - yyyy)</span>
   	</td>
  </tr>
  
  <tr>
    <td height="35">* Tarifa: </td>
    
    <td colspan="3"> 
    	<select name="reservation_rate" id="reservation_rate">
    		<?php
			foreach ($rates as $row) {
				?>
				<option value="<?php echo $row['id_rate']; ?>" <?php echo set_select('reservation_rate', $row['id_rate']); ?> ><?php echo $row['name']; ?></option>
       			<?php
			}
			?>
    	</select>    </td>
  </tr>
  
  <tr>
    <td height="35">* Plan: </td>
    
    <td colspan="3">
    	<select name="reservation_plan" id="reservation_plan">
    		<?php
			foreach ($plans as $row) {
				?>
				<option value="<?php echo $row['id_plan']; ?>" <?php echo set_select('reservation_plan', $row['id_plan']); ?> ><?php echo $row['name']; ?></option>
       			<?php
			}
			?>
    	</select>    </td>
  </tr>
  
  <tr>
    <td height="35">* Habitaciones:</td>
    
    <td colspan="3">
    	<select name="reservation_room_count" id="reservation_room_count" class="prueba">
      		<option value="1" <?php echo set_select('reservation_room_count', '1'); ?> selected>1</option>
      		<option value="2" <?php echo set_select('reservation_room_count', '2'); ?> >2</option>
      		<option value="3" <?php echo set_select('reservation_room_count', '3'); ?> >3</option>
      		<option value="4" <?php echo set_select('reservation_room_count', '4'); ?> >4</option>
      		<option value="5" <?php echo set_select('reservation_room_count', '5'); ?> >5</option>    
		</select>    
   	</td>
  </tr>

  <tr>
    <td height="35">* Habitaci&oacute;n 1:</td>
    
    <td width="160">Adultos: 
		<select name="reservation_adults1" id="reservation_adults1">
        	<option value="1" <?php echo set_select('reservation_adults1', '1', TRUE); ?> >1</option>
        	<option value="2" <?php echo set_select('reservation_adults1', '2'); ?> >2</option>
        	<option value="3" <?php echo set_select('reservation_adults1', '3'); ?> >3</option>
        	<option value="4" <?php echo set_select('reservation_adults1', '4'); ?> >4</option>
        	<option value="5" <?php echo set_select('reservation_adults1', '5'); ?> >5</option>
        	<option value="6" <?php echo set_select('reservation_adults1', '6'); ?> >6</option>
   		</select>    
  	</td>
    
    <td width="160">Ni&ntilde;os: 
		<select name="reservation_children1" id="reservation_children1">
        	<option value="0" <?php echo set_select('reservation_children1', '0', TRUE); ?> >0</option>
        	<option value="1" <?php echo set_select('reservation_children1', '1'); ?> >1</option>
        	<option value="2" <?php echo set_select('reservation_children1', '2'); ?> >2</option>
        	<option value="3" <?php echo set_select('reservation_children1', '3'); ?> >3</option>
        	<option value="4" <?php echo set_select('reservation_children1', '4'); ?> >4</option>
        	<option value="5" <?php echo set_select('reservation_children1', '5'); ?> >5</option>
  		</select>      
 	</td>
    <div id="age_col">
    </div>
  </tr>
</table>

<table id="table2">
</table>

<?php 
echo "<br>";
echo form_submit('sumit', 'Buscar');
echo form_close(); 

echo "<br>";
echo anchor('reservations/viewPendingReservations', 'Volver');
?>
 