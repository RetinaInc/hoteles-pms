

<?php 

$this->load->view('pms/header'); 

foreach ($roomType as $row) {

	$roomTypeName = $row['name']."<br>";
}	
	
echo 'Imagenes Tipo de Habitación: '.$roomTypeName."<br><br>";
	
foreach ($roomTypeImages as $row) {
		
	?><img src="<?php echo base_url() . "assets/images/" .$row['image']; ?>"/><?php 
}
		
		
?>
<p><a href="<?php echo base_url().'rooms/viewRoomTypes/'?>">Volver</a></p>
