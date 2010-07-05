

<?php 

$this->load->view('header'); 

foreach ($guest as $row)
{
	$guest_id = $row['ID_GUEST'];
}

echo 'EDITAR DATOS CLIENTE';?><br /><br /><?php

echo validation_errors();

echo form_open(base_url().'guests/edit_guest/'.$guest_id);

foreach ($guest as $row)
{?>
	<p>* Nombre:
	  <input name="guest_name" type="text" id="guest_name" value="<?php echo $row['NAME']; ?>" size="30" maxlength="30" />
	</p>
    
    <p>* Apellido:
	<input name="guest_last_name" type="text" id="guest_last_name" value="<?php echo $row['LAST_NAME']; ?>" size="30" maxlength="30" />
	</p>
    
    <p>* Teléfono:
	<input name="guest_telephone" type="text" id="guest_telephone" value="<?php echo $row['TELEPHONE']; ?>" size="20" maxlength="20" />
	</p>
    
    <p>Correo Electrónico:
	<input name="guest_email" type="text" id="guest_email" value="<?php echo $row['EMAIL']; ?>" size="30" maxlength="50" />
	</p>
    
    <p>Dirección: </p>
	<p><textarea name="guest_address" cols="30" rows="3" id="guest_address"><?php echo $row['ADDRESS'];  ?></textarea>
	</p>
    
<?php
}

echo form_submit('sumit', 'Enviar');
echo form_close();
?>

<p><a href="<?php echo base_url().'guests/delete_guest/'.$guest_id?>" onclick="return confirm('Seguro que desea eliminar?')">  Eliminar Cliente</a></p>
<p><a href="<?php echo base_url().'guests/view_guests/'.$guest_id?>">Volver</a></p>
