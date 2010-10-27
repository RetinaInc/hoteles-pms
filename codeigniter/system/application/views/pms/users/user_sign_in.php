
<?php
$this->load->view('pms/meta'); 
?>

<br />

<?php
echo form_open('users/userSignIn');

	?>
	<table width="348" border="0">
    
      <tr>
        <td height="22" colspan="2"><h3>Iniciar Sesión</h3></td>
      </tr>
      
      <tr>
        <td height="21" colspan="2">
                    
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
                echo "<br>";
            }
            ?>      	
      	</td>
      </tr>
      
      <tr>
        <td width="100" height="38">* Usuario:</td>
        <td width="238">
       	  <input name="username" type="text" id="username" value="<?php echo set_value('username'); ?>" size="20" maxlength="20" />       	
      	</td>
      </tr>
      
      <tr>
        <td height="36">* Contraseña:</td>
        <td>
        	<input name="password" type="password" id="password" size="30" maxlength="30"/>       	
      	</td>
      </tr>
      
      <tr>
        <td height="33" colspan="2">
			<?php
            echo anchor('users/forgottenPassword', '¿Olvidó su contraseña?');
            ?>       	
       	</td>
      </tr>
      
      <tr>
        <td height="36" colspan="2">
        	<?php
        	echo form_submit('sumit', 'Enviar');
			?>       	
      	</td>
      </tr>
	</table>
	<?php
	
echo form_close();

?>

<br /><br />

<table width="348" border="0">
  <tr>
    <td width="342"><h3>Nuevos Usuarios</h3></td>
  </tr>
  <tr>
    <td>
        <?php
        echo anchor('hotels/registerHotel', 'Registrar Nuevo Hotel');
        ?>
    </td>
  </tr>
</table>

 