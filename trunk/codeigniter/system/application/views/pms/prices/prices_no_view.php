 
<?php 
$this->load->view('pms/header'); 
?>

<script type="text/javascript">

	$(function(){
		
		<?php 
		if ($type == 'hasWeekdays') {
		?>
			$('#noWeekdays').hide();
			$('#hasWeekdays').show();
		<?php
		} else {
		?>
			$('#hasWeekdays').hide();
			$('#noWeekdays').show();
		<?php
		}
		?>
	});

</script>


<h3>Precios</h3>

<?php
foreach ($season as $row) {

	$seasonId   = $row['id_season'];
	$seasonName = $row['name'];
	$dateStart  = $row['dateStart'];
	$dateEnd    = $row['dateEnd'];
	
	$dS_array = explode ('-',$dateStart);
	$year     = $dS_array[0];
	$month    = $dS_array[1];
	$day      = $dS_array[2];
	$dateS    = $day.'-'.$month.'-'.$year;
	
	$dE_array = explode ('-',$dateEnd);
	$year     = $dE_array[0];
	$month    = $dE_array[1];
	$day      = $dE_array[2];
	$dateE    = $day.'-'.$month.'-'.$year;	
	
	echo $seasonName.' ('.$dateS.' al '.$dateE.') <br>';
}

foreach ($rate as $row) {
	
	$rateId = $row['id_rate'];
	echo 'Tarifa ', $row['name']."<br>";
}

foreach ($plan as $row) {
	
	$planId = $row['id_plan'];
	echo 'Plan ', $row['name']."<br><br>";
}

echo "<span class='Estilo3'>".'No existen precios en dicha temporada, tarifa y plan!'."</span> <br><br>";

echo anchor('prices/selectPlanPrices/'.$seasonId.'/'.$rateId, 'Volver');
?>

