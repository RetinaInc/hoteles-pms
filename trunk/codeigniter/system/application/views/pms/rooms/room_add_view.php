
<?php 
$this->load->view('pms/header'); 
?>

<h3>Nueva Habitación</h3>

<span class="Estilo2">
	(*)Campos obligatorios
</span>

<span class="Estilo1">
	<?php
	echo validation_errors();
	?>
</span>

<?php
echo form_open('rooms/addRoom');

	foreach ($maxRoomNumber as $row) {

		$nextRoom = $row['number'] + 1;
	}
	?>

	<p>* Número:
      <input name="room_number" type="text" id="room_number" value="<?php echo $nextRoom; ?>" size="5" maxlength="20" />
    </p>
	
    <p> Nombre: 
  	  <input name="room_name" type="text" id="room_name" value="<?php echo set_value('room_name'); ?>" size="30" maxlength="50"/>
	</p>
    
    <p>* Estado:			
	  <select name="room_status" id="room_status">
    	<option value="Running" <?php echo set_select('room_status', 'Running'); ?> >Funcionando</option>
      	<option value="Out of service" <?php echo set_select('room_status', 'Out of service'); ?> >Fuera de servicio</option>
  	</select>
    </p>
                
	 <p>* Tipo de habitación:
     <select name="room_room_type" id="room_room_type"><?php
		foreach ($roomTypes as $row) { 
			?>
            <option value="<?php echo $row['id_room_type']; ?>" <?php echo set_select('room_room_type', $row['id_room_type']); ?> ><?php echo $row['name']; ?></option>
			<?php 
		}
	?>
	</select>
    </p>
 
<?php
$att = array(
	'name'        => 'submit',
    'id'          => 'submit',
    'onClick'     => "return confirm('Seguro que desea guardar?')"
);
echo form_submit($att, 'Guardar');
echo form_close();

echo anchor('rooms/viewRooms', 'Cancelar', array('onClick' => "return confirm('Seguro que desea cancelar? Se perderá la información')"));
?>

