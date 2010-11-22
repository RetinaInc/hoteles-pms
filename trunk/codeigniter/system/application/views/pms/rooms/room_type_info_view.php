
<?php 
$this->load->view('pms/header'); 
?>

<h3>Información Tipo de Habitación</h3>

<?php
foreach ($roomType as $row) {

	$roomTypeId   = $row['id_room_type'];
	$roomTypeName = $row['name'];
}
        
foreach ($roomType as $row) {

	echo 'Nombre: ', $row['name']."<br>";
	
	if ($row['abrv'] != NULL) {
	
		echo 'Abrv: ', $row['abrv']."<br>";
	}

	echo 'Pax estándar: ', $row['paxStd']."<br>";
	
	echo 'Pax máximo: ', $row['paxMax']."<br>";
	
	echo 'Camas: ', $row['beds']."<br>";
	
	echo 'Nivel: ', $row['scale']."<br>";
	
	if ($row['description'] != NULL) {
	
		echo 'Descripción: ', $row['description']."<br>";
	}
	
	echo "<br>";
	
	if ($row['disable'] == 1) {
		
		$userRole = $this->session->userdata('userrole');

		if ($userRole != 'Employee') {
		
			echo anchor('rooms/editRoomType/'.$roomTypeId, 'Editar Info')."<br>";
		}
		
		if ($roomTypeImages) {
			
			 echo anchor('rooms/viewImagesRoomType/'.$roomTypeId, 'Ver Imagenes')."<br>";
		}
		
		if ($userRole != 'Employee') {
		
			echo anchor('rooms/addRoomTypeImage/'.$roomTypeId, 'Agregar Imagen')."<br>";
			echo anchor('rooms/disableRoomType/'.$roomTypeId, 'Deshabilitar tipo de habitación', array('onClick' => "return confirm('Seguro que desea deshabilitar?')"));
			echo "<br>";
		}
	
	} else if ($row['disable'] == 0) {
		
		if ($userRole != 'Employee') {
			
			echo anchor('rooms/enableRoomType/'.$roomTypeId, 'Habilitar tipo de habitación', array('onClick' => "return confirm('Seguro que desea Habilitar?')"));
			echo "<br>";
		}
	}
}

echo "<br>";
echo 'Total habitaciones tipo '.$roomTypeName.': ', $roomTypeRoomCount."<br>"; 
echo 'En funcionamiento: ', $roomTypeRoomCountRunning."<br>";  
echo 'Fuera de servicio: ', $roomTypeRoomCountOos."<br><br>"; 

if ($roomTypeRooms) { 
	
	echo 'Habitaciones tipo "'.$roomTypeName.'" existentes: '."<br>"; 
	
	foreach ($roomTypeRooms as $row) {
		
		echo anchor('rooms/infoRoom/'.$row['id_room'].'/checkIn','# '.$row['number']).' ';
	}

	echo "<br><br>";
	
} else {

	echo 'No existen habitaciones habilitadas de este tipo de habitación!';
	echo "<br><br>";
}

if ($roomTypeReservations) { 
	
	echo anchor('rooms/roomTypeReservations/'.$roomTypeId.'/checkIn', 'VER RESERVACIONES');
	echo "<br><br>";

} else {

	echo 'No existen reservaciones en este tipo de habitación!';
}

echo anchor('rooms/viewRoomTypes/', 'Volver a tipos de habitaciones');

?>