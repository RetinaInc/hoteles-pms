
<?php 
$this->load->view('pms/header'); 
?>

<h3>Seleccione Plan</h3>

<?php
foreach ($season as $row) {

	$seasonId = $row['id_season'];
	echo 'Temporada: ',$row['name']."<br>";
}

foreach ($rate as $row) {
	
	$rateId = $row['id_rate'];
	echo 'Tarifa: ',$row['name']."<br><br>";
}
	
if ($plans) {

	foreach ($plans as $row) { 
		
		echo anchor('prices/checkPrices/'.$seasonId.'/'.$rateId.'/'.$row['id_plan'], $row['name'])."<br><br>";
	}

} else {

	echo 'No existen planes!';
}

echo $this->pagination->create_links();

echo "<br><br><br>";
echo anchor('prices/selectRatePrices/'.$seasonId, 'Volver');

?>
	
 


