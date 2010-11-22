
<?php
$this->load->view('pms/header');
?>

<h3>Modificar Detalles Reservación</h3>

<?php

echo form_open('reservations/modifyReservationDetails/'.$reservationId);

foreach ($roomReservationInfo as $row) {
		
	echo 'Reservación # '.$row['id_reservation'];
	echo "<br><br>";
	
	?>
	<span class="Estilo1">
		<?php
		echo validation_errors();
		?>
	</span>
    
	<table width="594" border="0">

	  <tr>
		<td width="120">* Detalles reservación:</td>
		
		<td width="464"><textarea name="reservation_details" cols="50" rows="5" id="reservation_details"><?php echo $row['details'];?></textarea></td>
	  </tr>
	  
	</table>
	
<br />
	
	<?php
}

$att = array(
	'name'        => 'submit',
    'id'          => 'submit',
    'onClick'     => "return confirm('Seguro que desea guardar?')"
);
echo form_submit($att, 'Guardar');
echo form_close();

echo anchor('reservations/infoReservation/'.$reservationId.'/n/', 'Cancelar', array('onClick' => "return confirm('Seguro que desea cancelar? Se perderá la información')"));
?>