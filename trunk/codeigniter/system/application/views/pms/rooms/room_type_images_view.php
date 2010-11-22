
<?php 
$this->load->view('pms/header'); 
?>

<h3>Imágenes Tipo de Habitación</h3>

<?php
foreach ($roomType as $row) {

	$roomTypeId   = $row['id_room_type'];
	$roomTypeName = $row['name']."<br>";
}	
	
echo 'Tipo de Habitación: '.$roomTypeName."<br><br>";
	
foreach ($roomTypeImages as $row) {
		
	$imageId = $row['id_image'];
	?>
    <img src="<?php echo base_url() . "assets/images/" .$row['image']; ?>"/>
	<?php 
	$userRole = $this->session->userdata('userrole');

	if ($userRole != 'Employee') {
	
		echo anchor('rooms/deleteRoomTypeImage/'.$imageId, 'Eliminar', array('onClick' => "return confirm('Seguro que desea eliminar?')"));	
		echo "<br><br>";
	}
}
	
echo "<br><br>";
echo anchor('rooms/infoRoomType/'.$roomTypeId, 'Volver');	
		
?>
