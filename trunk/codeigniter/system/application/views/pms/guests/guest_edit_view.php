
<?php
$this->load->view('pms/header'); 

foreach ($guest as $row) {

	$guestId = $row['id_guest'];
}
?>

<h3>Editar Información Cliente</h3>

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

	echo "<br><br>";
	echo "<span class='Estilo1'>".$error."</span>";
}

echo form_open('guests/editGuest/'.$guestId);

foreach ($guest as $row) {
	?>
	
    <table width="1136" border="0">
    
      <tr>
        <td height="45">* ID: </td>
        <td>
			<?php
            $options = array(	
                    'V' => 'V-',
                    'E' => 'E-',
                    'P' => 'P-'
                    );
            
            $js = 'id="guest_id_type"';
            echo form_dropdown('guest_id_type', $options, $row['idType'], $js);
            ?>
            
          <input name="guest_id_num" type="text" id="guest_id_num" value="<?php echo $row['idNum']; ?>" size="10" maxlength="10" onKeyPress="return numbersonly(this, event)"/>        
      	</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="2">Informaci&oacute;n Corporaci&oacute;n: </td>
      </tr>
      
      <tr>
        <td width="100" height="45">* Nombre:</td>
      	<td width="270">
       		<input name="guest_name" type="text" id="guest_name" value="<?php echo $row['name']; ?>" size="30" maxlength="30" />
    	</td>
        <td width="100">Seg Nombre:</td>
  		<td width="270">
   	  		<input name="guest_2name" type="text" id="guest_2name" value="<?php echo $row['name2']; ?>" size="30" maxlength="30" />
      	</td>
      	<td width="100">Rif: </td>
      	<td width="270">
      		<input name="guest_corp_rif" type="text" id="guest_corp_rif" value="<?php echo $row['corpRif']; ?>" size="20" maxlength="20" />
      	</td>
      </tr>
      
      <tr>
        <td height="45">* Apellido:</td>
        <td>
        	<input name="guest_last_name" type="text" id="guest_last_name" value="<?php echo $row['lastName']; ?>" size="30" maxlength="30" />
      	</td>
        <td>Seg Apellido:</td>
      	<td>
       		<input name="guest_2last_name" type="text" id="guest_2last_name" value="<?php echo $row['lastName2']; ?>" size="30" maxlength="30" />
      	</td>
      	<td>Nombre: </td>
      	<td>
      		<input name="guest_corp_name" type="text" id="guest_corp_name" value="<?php echo $row['corpName']; ?>" size="30" maxlength="100" />
      	</td>
      </tr>
      
      <tr>
        <td height="45">* Teléfono:</td>
        <td>
        	<input name="guest_telephone" type="text" id="guest_telephone" value="<?php echo $row['telephone']; ?>" size="20" maxlength="20" />
       	</td>
        <td>Correo Electr&oacute;nico:</td>
        <td>
        	<input name="guest_email" type="text" id="guest_email" value="<?php echo $row['email']; ?>" size="30" maxlength="50" />
       	</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      
      <tr>
        <td height="45">Direcci&oacute;n:</td>
        <td>
        	<textarea name="guest_address" cols="25" rows="2" id="guest_address"><?php echo $row['address']; ?></textarea>
       	</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
	</table>  

	<br /><br />

	<?php
}

$att = array(
	'name'        => 'submit',
    'id'          => 'submit',
    'onClick'     => "return confirm('Seguro que desea guardar?')"
);
echo form_submit($att, 'Guardar');
echo form_close();

echo anchor('guests/infoGuestReservations/'.$guestId, 'Volver', array('onClick' => "return confirm('Seguro que desea volver? Se perderán los cambios')"));
?>

