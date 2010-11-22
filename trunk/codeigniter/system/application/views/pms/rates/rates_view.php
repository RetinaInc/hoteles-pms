
<?php 
$this->load->view('pms/header'); 
?>

<h3>Tarifas</h3>

<?php
$userRole = $this->session->userdata('userrole');

if ($userRole != 'Employee') {

	echo anchor('rates/addRate/','Agregar Nueva Tarifa')."<br>";
}

if ($ratesDis) {

	echo anchor('rates/viewDisabledRates/', 'Ver Tarifas Deshabilitadas');
	echo "<br>";
}

if ($rates) {

	echo "<br>";
	foreach ($rates as $row) { 
		
		echo "<strong>".'Tarifa: '.$row['name']."</strong> <br>";
		
	  	if ($row['description'] != NULL) {
	    	
			echo 'Descripción: '.$row['description']."<br>";
		}

		if ($userRole != 'Employee') {

			echo anchor('rates/editRate/'.$row['id_rate'], 'Editar')."<br>";
			echo anchor('rates/disableRate/'.$row['id_rate'], 'Deshabilitar', array('onClick' => "return confirm('Seguro que desea deshabilitar?')"))."<br>";
		}
		
		echo "<br>";
	}
	
	echo $this->pagination->create_links();
	  
} else {
	
	echo "<br><br>";
	echo 'No existen tarifas!';
}

?>
