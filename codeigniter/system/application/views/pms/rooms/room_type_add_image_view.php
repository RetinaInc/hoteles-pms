

<?php 

$this->load->view('pms/header'); 

foreach ($roomType as $row) {

	$roomTypeId   = $row['id_room_type'];
	$roomTypeName = $row['name'];
}

echo 'AGREGAR IMAGEN A TIPO DE HABITACION "'.$roomTypeName.'"'."<br><br>";

if ($error != 1) {
	
	echo $error;
}

echo form_open_multipart(base_url().'rooms/addRoomTypeImage2/'.$roomTypeId);
?>
<p>
<input type="file" name="userfile" size="20" />
</p>
<?php
echo form_submit('sumit', 'Enviar');
echo form_close();

?>

<br /><br />

<a href="<?php echo base_url().'rooms/infoRoomType/'.$roomTypeId?>">Volver</a>
