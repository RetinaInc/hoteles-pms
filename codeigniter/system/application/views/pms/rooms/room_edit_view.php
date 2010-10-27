
<?php 
$this->load->view('pms/header'); 
?>

<h3>Editar Habitación</h3>

<span class="Estilo2">
	(*)Campos obligatorios
</span>

<span class="Estilo1">
	<?php
	echo validation_errors();
	?>
</span>

<?php
foreach ($room as $row)
{
	$roomId     = $row['id_room'];
	$roomNumber = $row['number'];
}

echo form_open('rooms/editRoom/'.$roomId.'/'.$roomNumber);

foreach ($room as $row) {
	?>
	<p>* Número:
	<input name="room_number" type="text" id="room_number" value="<?php echo $row['number']; ?>" size="5" maxlength="20" />
	</p>
    
    <p> Nombre:
	<input name="room_name" type="text" id="room_name" value="<?php echo $row['name']; ?>" size="30" maxlength="50" />
	</p>
    
    <p>
    <?php
	$options = array(
			   'Running'        => 'Funcionando',
			   'Out of service' => 'Fuera de servicio'
				);
				
	echo '* Estado: ', form_dropdown('room_status', $options, $row['status']);
	?>
	</p>
    
	<p>* Tipo de habitación:
    <select name="room_room_type" id="room_room_type">
    	<?php
		foreach ($roomTypes as $row1) {
		
			if ($row1['id_room_type'] == $row['fk_room_type']) {
			
				?><option value="<?php echo $row1['id_room_type']?>" selected><?php echo $row1['name']; ?></option><?php
				
			} else {
			
				?><option value="<?php echo $row1['id_room_type']?>"><?php echo $row1['name']; ?></option><?php
			}
		}
		?>
	</select>
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

echo anchor('rooms/infoRoom/'.$roomId, 'Cancelar', array('onClick' => "return confirm('Seguro que desea cancelar? Se perderá la información')"));

?>