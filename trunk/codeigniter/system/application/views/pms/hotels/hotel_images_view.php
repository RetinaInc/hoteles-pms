
<?php 
$this->load->view('pms/header'); 
?>

<h3>Imágenes Hotel</h3>

<?php
foreach ($hotelInfo as $row) {

	$hotelId   = $row['id_hotel'];
	$hotelName = $row['name'];
}	
	
echo 'Hotel: '.$hotelName."<br><br>";
	
foreach ($hotelImages as $row) {
		
	$imageId = $row['id_image'];
	?>
    <img src="<?php echo base_url() . "assets/images/" .$row['image']; ?>"/>
	<?php 
	echo anchor('hotels/deleteHotelImage/'.$imageId, 'Eliminar', array('onClick' => "return confirm('Seguro que desea eliminar?')"));	
	echo "<br><br>";
}
	
echo "<br><br>";
echo anchor('hotels/infoHotel/'.$hotelId, 'Volver');	
		
?>
