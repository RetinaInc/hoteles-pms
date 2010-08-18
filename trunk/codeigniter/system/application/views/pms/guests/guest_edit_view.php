
<?php 

$this->load->view('pms/header'); 

foreach ($guest as $row) {

	$guestId = $row['id_guest'];
}

echo 'EDITAR DATOS CLIENTE';?><br /><br /><?php

echo validation_errors();

echo form_open(base_url().'guests/editGuest/'.$guestId);

foreach ($guest as $row) {?>

	<p>* Nombre:
	  <input name="guest_name" type="text" id="guest_name" value="<?php echo $row['name']; ?>" size="30" maxlength="30" />
	</p>
    
    <p>* Apellido:
	<input name="guest_last_name" type="text" id="guest_last_name" value="<?php echo $row['lastName']; ?>" size="30" maxlength="30" />
	</p>
    
    <p>* Teléfono:
	<input name="guest_telephone" type="text" id="guest_telephone" value="<?php echo $row['telephone']; ?>" size="20" maxlength="20" />
	</p>
    
    <p>Correo Electrónico:
	<input name="guest_email" type="text" id="guest_email" value="<?php echo $row['email']; ?>" size="30" maxlength="50" />
	</p>
    
    <p>Dirección: </p>
	<p><textarea name="guest_address" cols="30" rows="3" id="guest_address"><?php echo $row['address'];  ?></textarea>
	</p>
<?php
}

echo form_submit('sumit', 'Enviar');
echo form_close();
?>

<p><a href="<?php echo base_url().'guests/disableGuest/'.$guestId ?>" onclick="return confirm('Seguro que desea deshabilitar?')">  Deshabilitar Cliente</a></p>

<?php
$referer = $_SERVER['HTTP_REFERER'];
echo "<a href='" . $referer . "'> Volver</a><br>";
?>

