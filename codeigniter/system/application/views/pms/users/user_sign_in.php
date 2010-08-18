
<?php

echo 'Iniciar Sesi&oacute;n'."<br>";

echo validation_errors()."<br>"; 

if ($error != NULL)
{
	echo $error."<br>"; 
}


echo form_open(base_url().'users/userSignIn');
?>

	<p>* Usuario:
      <input name="hotel_username" type="text" id="hotel_username" value="<?php echo set_value('hotel_username'); ?>" size="20" maxlength="20" />
    </p>
	
    <p>* Contraseña: 
  	  <input name="hotel_password" type="password" id="hotel_password" size="30" maxlength="30"/>
	</p>
   
<?php
echo form_submit('sumit', 'Enviar');
echo form_close();
?>


 