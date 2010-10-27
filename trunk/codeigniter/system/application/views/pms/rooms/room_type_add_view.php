
<?php
$this->load->view('pms/header'); 
?>

<h3>Nuevo Tipo de Habitación</h3>

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
	
	if ($error != NULL) {
	
		echo "<br><br>";
		echo "<span class='Estilo1'>".$error."</span>";
	}
}

echo form_open('rooms/addRoomType/');?>

	<p>* Nombre: 
  	  <input name="room_type_name" type="text" id="room_type_name" value="<?php echo set_value('room_type_name'); ?>" size="30" maxlength="50"/>
	</p>
    
    <p>* Abrev.: 
	<input name="room_type_abrv" type="text" id="room_type_abrv" value="<?php echo set_value('room_type_abrv'); ?>" size="5" maxlength="5"/>
    </p>
    
    <p>* Pax estándar: 
	  <input name="room_type_paxStd" type="text" id="room_type_paxStd" value="<?php echo set_value('room_type_paxStd'); ?>" size="5" maxlength="3" 
      onKeyPress="return numbersonly(this, event)"/>
    </p>
    
    <p>* Pax máximo: 
	  <input name="room_type_paxMax" type="text" id="room_type_paxMax" value="<?php echo set_value('room_type_paxMax'); ?>" size="5" maxlength="3" 
      onKeyPress="return numbersonly(this, event)"/>
    </p>
    
	<p>* Cantidad de camas: 
	  <input name="room_type_beds" type="text" id="room_type_beds" value="<?php echo set_value('room_type_beds'); ?>" size="5" maxlength="3" 
      onKeyPress="return numbersonly(this, event)"/>
    </p>
    
    <p>* Nivel: 
	  <select name="room_type_scale" id="room_type_scale">
        <option value="1" <?php echo set_select('room_type_scale', '1'); ?> >1</option>
        <option value="2" <?php echo set_select('room_type_scale', '2'); ?> >2</option>
        <option value="3" <?php echo set_select('room_type_scale', '3'); ?> >3</option>
        <option value="4" <?php echo set_select('room_type_scale', '4'); ?> >4</option>
        <option value="5" <?php echo set_select('room_type_scale', '5'); ?> >5</option>
        <option value="6" <?php echo set_select('room_type_scale', '6'); ?> >6</option>
        <option value="7" <?php echo set_select('room_type_scale', '7'); ?> >7</option>
        <option value="8" <?php echo set_select('room_type_scale', '8'); ?> >8</option>
        <option value="9" <?php echo set_select('room_type_scale', '9'); ?> >9</option>
        <option value="10" <?php echo set_select('room_type_scale', '10'); ?> >10</option>
      </select>
    </p>
    
<p>Descripci&oacute;n: :</p>
	<p>
  	<textarea name="room_type_description" rows="3" id="room_type_description"><?php echo set_value('room_type_description'); ?></textarea>
	</p>

<?php 
$att = array(
	'name'        => 'submit',
    'id'          => 'submit',
    'onClick'     => "return confirm('Seguro que desea guardar?')"
);
echo form_submit($att, 'Guardar');
echo form_close();

echo "<br><br>";

echo anchor('rooms/viewRoomTypes/', 'Cancelar', array('onClick' => "return confirm('Seguro que desea cancelar? Se perderá la información')"));
?>
