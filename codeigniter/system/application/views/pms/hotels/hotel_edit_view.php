
<?php
$this->load->view('pms/header'); 
?>

<script type="text/javascript">

	$(function(){
		
		$('#hotel_country').change(function(){
			
			var country = $('#hotel_country').val();
			
			 $.ajax({
             	type: "GET",
                url: "<?php echo base_url().'hotels/ajax_get_cities/'?>" + country,
				dataType: 'html',
				success: function(data) {
					$('#hotel_city').replaceWith('<select name="hotel_city" id="hotel_city" selected="selected">' + data + '</select>');
				}
          	});
			
		});
		
	});

</script>

<h3>Editar Información Hotel</h3>

<span class="Estilo2">
    (*)Campos obligatorios
</span>

<span class="Estilo1">
    <?php
    echo validation_errors();
    ?>
</span>

<?php 
foreach ($hotelInfo as $row) {

	$hotelId = $row['id_hotel'];
	$cityId  = $row['fk_place']; 
	
	foreach ($places as $row1) {
		
		if ($row1['id_place'] == $row['fk_place']) {
			
			$countryId = $row1['fk_place'];
		}
	}
	
	$city    = getInfo(null, 'PLACE', 'id_place', $cityId,    null, null, null, null);
	$country = getInfo(null, 'PLACE', 'id_place', $countryId, null, null, null, null);
}

echo form_open('hotels/editHotel/'.$hotelId);

foreach ($hotelInfo as $row) {

	?>
	
	<table width="825" border="0">
	
	  <tr>
		<td width="138" height="40">* Nombre</td>
		<td>
		  <input name="hotel_name" type="text" value="<?php echo $row['name']; ?>" size="100" />   	
       	</td>
	  </tr>
	  
	  <tr>
		<td height="40">* Tipo</td>
		<td width="677">
		<input name="hotel_type" type="text" value="<?php echo $row['type']; ?>" size="30" maxlength="50" />   	
     	</td>
	  </tr>
	  
	  <tr>
		<td height="40"> Descripción</td>
		<td>
			<textarea name="hotel_description" cols="30" rows="2"><?php echo $row['description']; ?></textarea>   	
       	</td>
	  </tr>
	  
	  <tr>
		<td height="40">* País/Ciudad</td>
		<td>
		  País
		  <select name="hotel_country" id="hotel_country">
				<?php
				foreach ($places as $row1) {
					
					if ($row1['type'] == 'Country') {
					
						if ($row1['id_place'] == $countryId) {
						
							?>
							<option value="<?php echo $row1['id_place']?>" <?php echo set_select('hotel_country', $row1['id_place']); ?> selected="selected"> <?php echo $row1['name']?></option>
							<?php
							
						} else {
							
							?>
							<option value="<?php echo $row1['id_place']?>" <?php echo set_select('hotel_country', $row1['id_place']); ?> ><?php echo $row1['name']?></option>
							<?php
						}
					}
				}
				?>
		  </select>
          
		  Ciudad
		  <select name="hotel_city" id="hotel_city">
				<?php
				foreach ($places as $row1) {
					
					if (($row1['type'] == 'City') && ($row1['fk_place'] == $countryId)) {
					
						if ($row1['id_place'] == $cityId) {
						
							?>
							<option value="<?php echo $row1['id_place']?>" <?php echo set_select('hotel_city', $row1['id_place']); ?> selected="selected"> <?php echo $row1['name']?></option>
							<?php
							
						} else {
							
							?>
							<option value="<?php echo $row1['id_place']?>" <?php echo set_select('hotel_city', $row1['id_place']); ?> ><?php echo $row1['name']?></option>
							<?php
						}
					}
				}
				?>
		  </select>   	
     	</td>
	  </tr>
      
	  <tr>
		<td height="40">* Dirección</td>
		<td>
			<textarea name="hotel_address" cols="30" rows="2"><?php echo $row['address']; ?></textarea>  	
       	</td>
	  </tr>
	  
	  <tr>
		<td height="40">Referencias direcci&oacute;n</td>
		<td>
        	<textarea name="hotel_ref_address" cols="30" rows="2"><?php echo $row['refAddress']; ?></textarea>
     	</td>
	  </tr>
	  
	  <tr>
		<td height="40">Teléfonos</td>
		<td>*
        	<?php
			$type1 = NULL;
			$numb1 = NULL;
			$type2 = NULL;
			$numb2 = NULL;
			$type3 = NULL;
			$numb3 = NULL;
			
			foreach ($telephones as $row1) {
			
				if ($row1['telNum'] == 1) {
					$type1 = $row1['type'];
					$numb1 = $row1['number'];
				}
				
				if ($row1['telNum'] == 2) {
					$type2 = $row1['type'];
					$numb2 = $row1['number'];
				}
				
				if ($row1['telNum'] == 3) {
					$type3 = $row1['type'];
					$numb3 = $row1['number'];
				}
			}
			
			$options = array(
					  'Tel' => 'Tel',
					  'Fax' => 'Fax',
					  'Cel' => 'Cel'
               		);

			echo form_dropdown('hotel_tel_type_1', $options, $type1);
			?>
            
            <input type="text" name="hotel_tel_num_1" id="hotel_tel_num_1" value="<?php echo $numb1; ?>" 
            onkeypress="return numbersonly(this, event)"/>

            <?php
			$options = array(
					  'Tel' => 'Tel',
					  'Fax' => 'Fax',
					  'Cel' => 'Cel'
               		);

			echo form_dropdown('hotel_tel_type_2', $options, $type2);
			?>
        
            <input type="text" name="hotel_tel_num_2" id="hotel_tel_num_2" value="<?php echo $numb2; ?>" 
            onKeyPress="return numbersonly(this, event)"/>
            
           <?php
			$options = array(
					  'Tel' => 'Tel',
					  'Fax' => 'Fax',
					  'Cel' => 'Cel'
               		);

			echo form_dropdown('hotel_tel_type_3', $options, $type3);
			?>
    
            <input type="text" name="hotel_tel_num_3" id="hotel_tel_num_3" value="<?php echo $numb3; ?>" 
            onKeyPress="return numbersonly(this, event)"/>     
      	</td>
	  </tr>
	  
	  <tr>
		<td height="40">Página web</td>
		<td>
			<input name="hotel_web_page" type="text" value="<?php echo $row['webPage']; ?>" size="42" maxlength="100" />    
      	</td>
	  </tr>
	  
	  <tr>
		<td height="40">* Correo electrónico</td>
		<td>
			<input name="hotel_email" type="text" value="<?php echo $row['email']; ?>" size="42" maxlength="50" />  	
      	</td>
	  </tr>
      
      <tr>
    	<td height="40">Informaci&oacute;n cancelaci&oacute;n:</td>
    	<td>
    		<textarea name="hotel_cancel_info" cols="40" rows="2"><?php echo $row['cancelInfo']; ?></textarea>
 		</td>
  	  </tr>
	</table>
	
	<?php
}
?>
<br />

<?php
$att = array(
	'name'        => 'submit',
    'id'          => 'submit',
    'onClick'     => "return confirm('Seguro que desea continuar?')"
);
echo form_submit($att, 'Continuar');
echo form_close();

echo anchor('users/userSignIn', 'Cancelar', array('onClick' => "return confirm('Seguro que desea cancelar? Se perderá la información')"));
?>
