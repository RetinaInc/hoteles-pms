
<?php
$this->load->view('pms/header'); 

$sessionUserId   = $this->session->userdata('userid');
$sessionUserRole = $this->session->userdata('userrole');

foreach ($user as $row) {

	$userId = $row['id_user'];
}
?>

<h3>Editar Información Usuario</h3>

<?php
if ($sessionUserId == $userId) {
		
	echo anchor('users/modifyUserPassword/'.$userId, 'Modificar Contraseña');
	echo "<br><br>";
}
?>

<span class="Estilo2">
	(*)Campos obligatorios
</span>

<span class="Estilo1">
	<?php
	echo validation_errors();
	?>
</span>

<?php

echo form_open('users/editUser/'.$userId);

foreach ($user as $row) {
	
	?>
	
    <br />
    
    <table width="729" border="0">
    
      <tr>
        <td height="40">ID: </td>
        <td>
        	<?php
			if (($row['idNum'] != NULL) || ($row['idNum'] != 0)) {
	
				echo $row['idType'].' - '.$row['idNum']."<br>";
			}
			?>        </td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td width="120" height="40">* Nombre:</td>
        
        <td width="250">
       	<input name="user_name" type="text" id="user_name" value="<?php echo $row['name']; ?>" size="30" maxlength="30" />        </td>
        
        <td width="141">Segundo Nombre:</td>
        
        <td width="200">
       	<input name="user_2name" type="text" id="user_2name" value="<?php echo $row['name2']; ?>" size="30" maxlength="30" />        </td>
      </tr>
      
      <tr>
        <td height="40">* Apellido:</td>
        
        <td>
        	<input name="user_last_name" type="text" id="user_last_name" value="<?php echo $row['lastName']; ?>" size="30" maxlength="30" />        </td>
        
        <td>Segundo Apellido:</td>
        
        <td>
        	<input name="user_2last_name" type="text" id="user_2last_name" value="<?php echo $row['lastName2']; ?>" size="30" maxlength="30" />        </td>
      </tr>
      
      <tr>
        
        <?php 
		$i = 1;
		foreach ($telephones as $row1) {
			?>
            <td height="40">* Teléfono <?php echo $i; ?>:</td>
			<td>
				<?php
				$options = array(	
							'Tel' => 'Tel',
							'Fax' => 'Fax',
							'Cel' => 'Cel'
							);
					
					$js = 'id="user_tel_type_'.$i.'"';
					echo form_dropdown('user_tel_type_'.$i, $options, $row1['type'], $js);
				?>
				
				<input name="user_tel_num_<?php echo $i; ?>" type="text" id="user_tel_num_<?php echo $i; ?>" value="<?php echo $row1['number']; ?>" size="20" maxlength="20" />			</td>
			<?php
			$i++;
		}
		
		$countTel = count($telephones);
		if ($countTel == 1) {
			?>
            <td>Tel&eacute;fono 2</td>
			<td>
                <select name="user_tel_type_2" id="user_tel_type_2">
                  <option value="Tel" <?php echo set_select('user_tel_type_2', 'Tel'); ?> >Tel</option>
                  <option value="Fax" <?php echo set_select('user_tel_type_2', 'Fax'); ?> >Fax</option>
                  <option value="Cel" <?php echo set_select('user_tel_type_2', 'Cel', TRUE); ?> >Cel</option>
                </select>
                
                <input name="user_tel_num_2" type="text" id="user_tel_num_2" value="<?php echo set_value('user_tel_num_2'); ?>" size="20" maxlength="20" 
                onkeypress="return numbersonly(this, event)"/>        	
            	</td>
        <?php
		}
		?>
      </tr>
      
      <tr>
        <td height="40">Correo Electr&oacute;nico:</td>
        
        <td><input name="user_email" type="text" id="user_email" value="<?php echo $row['email']; ?>" size="30" maxlength="50" /></td>
        
        <td>Direcci&oacute;n:</td>
        
        <td><textarea name="user_address" cols="25" rows="2" id="user_address"><?php echo $row['address']; ?></textarea></td>
      </tr>
      
      <?php
	  if ($sessionUserRole == 'Master') {
		  ?>
		  <tr>
			<td height="40">* Rol </td>
			<td>
				<?php
				if ($row['role'] == 'Master') {
					
					echo $row['role'];
				
				} else {
					
					$options = array(	
							'Manager'  => 'Administrador',
							'Employee' => 'Empleado'
							);
						
					$js = 'id="user_role"';
					echo form_dropdown('user_role', $options, $row['role'], $js);
				}
				?>
			</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		  </tr>
		  <?php
	  }
	  ?>
      
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

echo anchor('users/infoUser/'.$userId, 'Volver', array('onClick' => "return confirm('Seguro que desea volver? Se perderán los cambios')"));
?>

