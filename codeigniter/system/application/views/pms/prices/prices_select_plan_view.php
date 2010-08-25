
<?php 
$this->load->view('pms/header'); 
?>

<h3>Seleccione Plan</h3>

<?php
foreach ($season as $row) {
	echo 'Temporada: ',$row['name']."<br>";
	$seasonId = $row['id_season'];
}

foreach ($rate as $row) {
	echo 'Tarifa: ',$row['name']."<br><br>";
	$rateId = $row['id_rate'];
}
	
if ($plans) {

	foreach ($plans as $row) { 
		
		echo anchor(base_url().'prices/checkPrices/'.$seasonId.'/'.$rateId.'/'.$row['id_plan'], $row['name'])."<br>";
	}

} else {

	echo 'No existen planes'."<br><br>";
}
?>

<p><a href="<?php echo base_url().'prices/selectRatePrices/'.$seasonId?>">Volver</a></p>
	
 


