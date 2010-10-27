
<?php

$this->load->view('pms/header'); 

$sessionUserId = $this->session->userdata('userid');

foreach ($user as $row) {

	$userId   = $row['id_user'];
	$username = $row['username'];
}
?>

<h3>Modificar Contraseña Usuario</h3>

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

echo form_open('users/modifyUserPassword/'.$userId);

	?>
    
    <br />
    
    <table width="490" border="0">
    
      <tr>
        <td width="200" height="40">Usuario: </td>
        <td width="280">
       		<?php 
			echo $username; 
			?> 
            <input name="username" type="hidden" value="<?php echo $username; ?>" />     	
       	</td>
      </tr>
      
      <tr>
        <td height="40">* Contraseña: </td>
        <td><input name="user_password" type="password" id="user_password" size="30" maxlength="30" /></td>
      </tr>
      <tr>
        <td height="40">* Nueva contraseña: </td>
        <td>
        	<input name="user_new_password" type="password" id="user_new_password" size="30" maxlength="30" />
            <span class="Estilo2">(6 - 30 carac.)</span>      	</td>
      </tr>
      
      <tr>
     	<td height="40">* Repetir nueva contraseña: </td>
		<td>
        	<input name="user_repeat_new_password" type="password" id="user_repeat_new_password" size="30" maxlength="30" />       	</td>
      </tr>
</table>  

<br /><br />

<?php

$att = array(
	'name'        => 'submit',
    'id'          => 'submit',
    'onClick'     => "return confirm('Seguro que desea guardar?')"
);
echo form_submit($att, 'Guardar');
echo form_close();

echo anchor('users/infoUser/'.$userId, 'Volver a usuario', array('onClick' => "return confirm('Seguro que desea volver? Se perderán los cambios')"));
?>

