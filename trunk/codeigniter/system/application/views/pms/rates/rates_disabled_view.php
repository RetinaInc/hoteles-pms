
<?php 
$this->load->view('pms/header'); 
?>

<h3>Tarifas Deshabilitadas</h3>

<?php
if ($ratesDis) {

	foreach ($ratesDis as $row) { 
		
		echo $row['name']."<br>";
		
	  	if ($row['description'] != NULL) {
	    	
			echo 'Descripción: '.$row['description']."<br>";
		}
		
		echo anchor('rates/enableRate/'.$row['id_rate'], 'Habilitar', array('onClick' => "return confirm('Seguro que desea habilitar?')"))."<br><br>";
	}
	
	echo $this->pagination->create_links();
	  
} else {
	
	echo 'No existen tarifas deshabilitadas!'."<br>";
}

echo "<br><br>".anchor('rates/viewRates/', 'Volver a Tarifas');

?>
