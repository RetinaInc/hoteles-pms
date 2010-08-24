
<?php 
$this->load->view('pms/header'); 
?>

<h3>Seleccione Tarifa</h3>

<?php
foreach ($season as $row) {
	echo 'Temporada: ',$row['name']."<br><br>";
	$seasonId = $row['id_season'];
}


foreach ($rates as $row) { 
		
	echo anchor(base_url().'prices/selectPlanPrices/'.$seasonId.'/'.$row['id_rate'], $row['name'])."<br>";
}
?>
	
 


