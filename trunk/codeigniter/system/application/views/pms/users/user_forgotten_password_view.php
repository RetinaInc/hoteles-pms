
<?php
$this->load->view('pms/meta'); 
?>

<br />

<h3>Contraseña Olvidada</h3>

La contraseña será enviada al correo electrónico

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

echo form_open('users/forgottenPassword');

	?>
    
    <br />
    
    <table width="470" border="0">
      
      <tr>
        <td height="40">* Nombre de usuario: </td>
        <td>
        	<input name="username" id="username" value="<?php echo set_value('username'); ?>" size="20" maxlength="20" />
      	</td>
      </tr>
      <tr>
     	<td width="150" height="40">* Correo electrónico: </td>
		<td width="310">
       		<input name="user_email" id="user_email" value="<?php echo set_value('user_email'); ?>" size="50" maxlength="50" />       	
     	</td>
      </tr>
      <tr>
        <td height="40" colspan="2">
			<?php
			$att = array(
				'name'        => 'submit',
				'id'          => 'submit',
				'onClick'     => "return confirm('Seguro que desea enviar?')"
			);
			
			echo form_submit($att, 'Enviar');
			?>
      	</td>
      </tr>
	</table>  

<br /><br />

<?php
echo form_close();

echo anchor('users/userSignIn', 'Volver');
?>

