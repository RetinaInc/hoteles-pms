
<?php
$this->load->view('pms/meta');
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

<h3>Nuevo Hotel</h3>

<span class="Estilo2">
    (*)Campos obligatorios
</span>

<span class="Estilo1">
    <?php
    echo validation_errors();
    ?>
</span>

<?php 
echo form_open('hotels/registerHotel');
?>

<table width="825" border="0">

  <tr>
    <td width="140" height="40">* Nombre</td>
    <td>
      <input name="hotel_name" type="text" value="<?php echo set_value('hotel_name'); ?>" size="100" />  	</td>
  </tr>
  
  <tr>
    <td height="40">* Tipo</td>
  	<td width="675">
   		<input name="hotel_type" type="text" value="<?php echo set_value('hotel_type'); ?>" size="30" maxlength="50" />  	</td>
  </tr>
  
  <tr>
    <td height="40">* Descripción</td>
  	<td>
    	<textarea name="hotel_description" cols="30" rows="2"><?php echo set_value('hotel_description'); ?></textarea>   	</td>
  </tr>
  
  <tr>
    <td height="40">* País/Ciudad</td>
    <td>
      País
      <select name="hotel_country" id="hotel_country">
   		<option value=" ">Seleccionar</option>
        	<?php
			foreach ($countries as $row) {
				?>
        		<option value="<?php echo $row['id_place']?>" <?php echo set_select('hotel_country', $row['id_place']); ?> ><?php echo $row['name']?></option>
        		<?php
			}
			?>
      </select>
      
      Ciudad
      <select name="hotel_city" id="hotel_city">
      	<option value=" ">Seleccionar</option>
      </select>  	</td>
  </tr>
  
  <tr>
    <td height="40">* Dirección</td>
  	<td>
    	<textarea name="hotel_address" cols="30" rows="2"><?php echo set_value('hotel_address'); ?></textarea>   	</td>
  </tr>
  
  <tr>
    <td height="40">Referencias direcci&oacute;n</td>
  	<td>
    	<textarea name="hotel_ref_address" cols="30" rows="2"><?php echo set_value('hotel_ref_address'); ?></textarea>	</td>
  </tr>
  
  <tr>
    <td height="40">Teléfonos</td>
    <td>*
        <select name="hotel_tel_type_1" id="hotel_tel_type_1">
          <option value="Tel" <?php echo set_select('hotel_tel_type_1', 'Tel', TRUE); ?>>Tel</option>
          <option value="Fax" <?php echo set_select('hotel_tel_type_1', 'Fax'); ?>>Fax</option>
          <option value="Cel" <?php echo set_select('hotel_tel_type_1', 'Cel'); ?>>Cel</option>
        </select>
        
         <input type="text" name="hotel_tel_num_1" id="hotel_tel_num_1" value="<?php echo set_value('hotel_tel_num_1'); ?>" 
         onkeypress="return numbersonly(this, event)"/>
         
      	<select name="hotel_tel_type_2" id="hotel_tel_type_2">
          <option value="Tel" <?php echo set_select('hotel_tel_type_2', 'Tel', TRUE); ?>>Tel</option>
          <option value="Fax" <?php echo set_select('hotel_tel_type_2', 'Fax'); ?>>Fax</option>
          <option value="Cel" <?php echo set_select('hotel_tel_type_2', 'Cel'); ?>>Cel</option>
        </select>
        
        <input type="text" name="hotel_tel_num_2" id="hotel_tel_num_2" value="<?php echo set_value('hotel_tel_num_2'); ?>" 
        onKeyPress="return numbersonly(this, event)"/>
      
      <select name="hotel_tel_type_3" id="hotel_tel_type_3">
         <option value="Tel" <?php echo set_select('hotel_tel_type_3', 'Tel', TRUE); ?>>Tel</option>
         <option value="Fax" <?php echo set_select('hotel_tel_type_3', 'Fax'); ?>>Fax</option>
         <option value="Cel" <?php echo set_select('hotel_tel_type_3', 'Cel'); ?>>Cel</option>
      </select>
    
      <input type="text" name="hotel_tel_num_3" id="hotel_tel_num_3" value="<?php echo set_value('hotel_tel_num_3'); ?>" 
      onKeyPress="return numbersonly(this, event)"/>   	</td>
  </tr>
  
  <tr>
    <td height="40">Página web</td>
  	<td>
  		<input name="hotel_web_page" type="text" value="<?php echo set_value('hotel_web_page'); ?>" size="42" maxlength="100" />  	</td>
  </tr>
  
  <tr>
    <td height="40">* Correo electrónico</td>
  	<td>
    	<input name="hotel_email" type="text" value="<?php echo set_value('hotel_email'); ?>" size="42" maxlength="50" />  	
  	</td>
  </tr>
  <tr>
    <td height="40">Informaci&oacute;n cancelaci&oacute;n:</td>
    <td>
    	<textarea name="hotel_cancel_info" cols="40" rows="2"><?php echo set_value('hotel_cancel_info'); ?></textarea>
 	</td>
  </tr>
</table>

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
