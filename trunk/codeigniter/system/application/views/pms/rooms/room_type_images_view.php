
<?php 
$this->load->view('pms/header'); 
?>

<h3>Im�genes Tipo de Habitaci�n</h3>

<?php
foreach ($roomType as $row) {

	$roomTypeId   = $row['id_room_type'];
	$roomTypeName = $row['name']."<br>";
}	
	
echo 'Tipo de Habitaci�n: '.$roomTypeName."<br><br>";
	
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
