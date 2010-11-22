
<?php 
$this->load->view('pms/header'); 
?>

<h3>Agregar Imagen a Hotel</h3>

<?php
foreach ($hotelInfo as $row) {

	$hotelId   = $row['id_hotel'];
	$hotelName = $row['name'];
}

echo 'Hotel: '.$hotelName."<br><br>";

if (isset($error)) {
	
	echo "<span class='Estilo1'>".$error."</span>";
}

echo form_open_multipart('hotels/addHotelImage2/'.$hotelId);
?>

<p><input type="file" name="userfile" size="20" /></p>

<?php
echo form_submit('sumit', 'Enviar');
echo form_close();

echo "<br><br>";

echo anchor('hotels/infoHotel/'.$hotelId, 'Volver', array('onClick' => "return confirm('Seguro que desea volver?')"));

?>
