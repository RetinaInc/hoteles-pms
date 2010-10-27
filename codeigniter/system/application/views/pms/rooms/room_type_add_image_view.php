
<?php 
$this->load->view('pms/header'); 
?>

<h3>Agregar Imagen a Tipo de Habitación</h3>

<?php
foreach ($roomType as $row) {

	$roomTypeId   = $row['id_room_type'];
	$roomTypeName = $row['name'];
}

echo 'Tipo de habitación: '.$roomTypeName."<br><br>";

if (isset($error)) {
	
	echo "<span class='Estilo1'>".$error."</span>";
}

echo form_open_multipart('rooms/addRoomTypeImage2/'.$roomTypeId);
?>

<p><input type="file" name="userfile" size="20" /></p>

<?php
echo form_submit('sumit', 'Enviar');
echo form_close();

echo "<br><br>";

echo anchor('rooms/infoRoomType/'.$roomTypeId, 'Volver');

?>
