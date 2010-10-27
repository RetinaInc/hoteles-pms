
<?php 
$this->load->view('pms/header'); 
?>

<h3>Seleccione Tarifa</h3>

<?php
foreach ($season as $row) {

	$seasonId = $row['id_season'];
	echo 'Temporada: ', $row['name']."<br><br>";
}

if ($rates) {

	foreach ($rates as $row) { 
		
		echo anchor('prices/selectPlanPrices/'.$seasonId.'/'.$row['id_rate'], $row['name'])."<br><br>";
	}

} else {

	echo 'No existen tarifas!';
}

echo $this->pagination->create_links();

echo "<br><br>";
echo anchor('prices/selectSeasonPrices', 'Volver');

?>


