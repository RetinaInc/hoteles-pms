
<?php
$this->load->view('pms/header'); 
?>

<h3>Editar Tipo de Habitación</h3>

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

foreach ($roomType as $row) {

	$roomTypeId   = $row['id_room_type'];
	$roomTypeName = $row['name'];
}


echo form_open('rooms/editRoomType/'.$roomTypeId.'/'.$roomTypeName);

foreach ($roomType as $row) {
	?>
    
	<p>* Nombre: 
		<input name="room_type_name" type="text" id="room_type_name" value="<?php echo $row['name']; ?>" size="30" maxlength="50"/>
    </p>
    
    <p>* Abrev.: 
		<input name="room_type_abrv" type="text" id="room_type_abrv" value="<?php echo $row['abrv']; ?>" size="5" maxlength="5"/>
    </p>
   
    <p>* Pax estandar: 
        <input name="room_type_paxStd" type="text" id="room_type_paxStd" value="<?php echo $row['paxStd']; ?>" size="5" maxlength="3" 
        onKeyPress="return numbersonly(this, event)"/>
    </p>
    
    <p>* Pax máximo: 
        <input name="room_type_paxMax" type="text" id="room_type_paxMax" value="<?php echo $row['paxMax']; ?>" size="5" maxlength="3" 
        onKeyPress="return numbersonly(this, event)"/>
    </p>
    
     <p>* Cantidad de camas: 
        <input name="room_type_beds" type="text" id="room_type_beds" value="<?php echo $row['beds']; ?>" size="5" maxlength="3" 
        onKeyPress="return numbersonly(this, event)"/>
    </p>
    
    <p>* Nivel: 
        <?php 
		$options = array(	
				'1' => '1',
				'2' => '2',
				'3' => '3',
				'4' => '4',
				'5' => '5',
				'6' => '6',
				'7' => '7',
				'8' => '8',
				'9' => '9',
				'10' => '10'
				);
		
		$js = 'id="room_type_scale"';
		echo form_dropdown('room_type_scale', $options, $row['scale'], $js);
		?>
    </p>
    
<p> Descripción: </p>
	<p>
    	<textarea name="room_type_description" rows="3" id="room_type_description"><?php echo $row['description']; ?></textarea>
   	</p>
   
	<?php
}

$att = array(
	'name'        => 'submit',
    'id'          => 'submit',
    'onClick'     => "return confirm('Seguro que desea guardar?')"
);
echo form_submit($att, 'Guardar');
echo form_close();

echo "<br><br>";

echo anchor('rooms/infoRoomType/'.$roomTypeId, 'Cancelar', array('onClick' => "return confirm('Seguro que desea cancelar? Se perderá la información')"));

?>

