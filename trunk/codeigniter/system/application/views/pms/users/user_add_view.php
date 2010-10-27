
<?php
$this->load->view('pms/header'); 
?>

<h3>Nuevo Usuario</h3>

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

echo form_open('users/addUser');

?>

<br />
    
<table width="728" border="0">

  <tr>
    <td width="120" height="40">* Num Identificaci&oacute;n</td>
    
    <td width="250">
      <select name="user_id_type" id="user_id_type">
        <option value="V" <?php echo set_select('user_id_type', 'V', TRUE); ?> >V-</option>
        <option value="E" <?php echo set_select('user_id_type', 'E'); ?> >E-</option>
        <option value="P" <?php echo set_select('user_id_type', 'P'); ?> >P-</option>
      </select>

    <input name="user_id_num" type="text" id="user_id_num" value="<?php echo set_value('user_id_num'); ?>" size="10" maxlength="10" onKeyPress="return numbersonly(this, event)"/>
    </td>
    <td width="140">&nbsp;</td>
    
    <td width="200">&nbsp;</td>
  </tr>
  
  <tr>
    <td height="40">* Nombre</td>
    
    <td>
    	<input name="user_name" type="text" id="user_name" value="<?php echo set_value('user_name'); ?>" size="30" maxlength="30" />    </td>
    
    <td>Seg. Nombre</td>
    
    <td>
    	<input name="user_2name" type="text" id="user_2name" value="<?php echo set_value('user_2name'); ?>" size="30" maxlength="30" />    </td>
  </tr>
  
  <tr>
    <td height="40">* Apellido</td>
    
    <td>
    	<input name="user_last_name" type="text" id="user_last_name" value="<?php echo set_value('user_last_name'); ?>" size="30" maxlength="30" />    </td>
    
    <td>Seg. Apellido</td>
    
    <td>
    	<input name="user_2last_name" type="text" id="user_2last_name" value="<?php echo set_value('user_2last_name'); ?>" size="30" maxlength="30" />    </td>
  </tr>
  
  <tr>
    <td height="40">* Tel&eacute;fono 1</td>
    
    <td>
    	<select name="user_tel_type_1" id="user_tel_type_1">
          <option value="Tel" <?php echo set_select('user_tel_type_1', 'Tel', TRUE); ?> >Tel</option>
          <option value="Fax" <?php echo set_select('user_tel_type_1', 'Fax'); ?> >Fax</option>
          <option value="Cel" <?php echo set_select('user_tel_type_1', 'Cel'); ?> >Cel</option>
        </select>
   		<input name="user_tel_num_1" type="text" id="user_tel_num_1" value="<?php echo set_value('user_tel_num_1'); ?>" size="20" maxlength="20" onKeyPress="return numbersonly(this, event)"/>    </td>
    
    <td>Tel&eacute;fono 2</td>
    
    <td>
    	<select name="user_tel_type_2" id="user_tel_type_2">
          <option value="Tel" <?php echo set_select('user_tel_type_2', 'Tel', TRUE); ?> >Tel</option>
          <option value="Fax" <?php echo set_select('user_tel_type_2', 'Fax'); ?> >Fax</option>
          <option value="Cel" <?php echo set_select('user_tel_type_2', 'Cel'); ?> >Cel</option>
        </select>
        <input name="user_tel_num_2" type="text" id="user_tel_num_2" value="<?php echo set_value('user_tel_num_2'); ?>" size="20" maxlength="20" onkeypress="return numbersonly(this, event)"/></td>
  </tr>
  
  <tr>
    <td height="40">* Correo</td>
    <td>
    	<input name="user_email" type="text" id="user_email" value="<?php echo set_value('user_email'); ?>" size="30" maxlength="50" />
    </td>
    <td>Direcci&oacute;n</td>
    <td>
    	<textarea name="user_address" cols="25" rows="2" id="user_address"><?php echo set_value('user_address'); ?></textarea>
  	</td>
  </tr>
</table>


<h4>Información Cuenta</h4>
<table width="728" border="0">

  <tr>
    <td width="120" height="40">* Rol </td>
    <td width="250">
        <select name="user_role" id="user_role">
            <option value="Manager" <?php echo set_select('user_role', 'Manager'); ?> >Administrador</option>
            <option value="Employee" <?php echo set_select('user_role', 'Employee'); ?> >Empleado</option>
        </select>    
    </td>
    <td width="140">* Contrase&ntilde;a </td>
	<td width="200">
    <input name="user_password" type="password" id="user_password" size="30" maxlength="30" />
     	<br />
	    <span class="Estilo2">(6 - 30 carac.)</span>
   	</td>
    
  </tr>
  <tr>
    <td height="40">* Nombre usuario </td>
    <td>
    	<input name="username" type="text" id="username" size="30" maxlength="20" value="<?php echo set_value('username'); ?>"/>
        <br />
      	<span class="Estilo2">(6 - 20 carac.)</span>
   	</td>
    <td>* Repetir contrase&ntilde;a</td>
    <td>
    	<input name="user_repeat_password" type="password" id="user_repeat_password" size="30" maxlength="30" />
  	</td>
  </tr>
  
</table>

<br />

<?php
$att = array(
	'name'        => 'submit',
    'id'          => 'submit',
    'onClick'     => "return confirm('Seguro que desea guardar?')"
);
echo form_submit($att, 'Guardar');
echo form_close();

echo anchor('users/viewUsers', 'Volver', array('onClick' => "return confirm('Seguro que desea volver? Se perderá la información')"));
?>
