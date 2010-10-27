
<?php 
$this->load->view('pms/header'); 
?>

<h3>Precios</h3>

<?php 
if ($roomTypes) {

	if (($seasons) && ($rates) && ($plans)) {
		?>
    
		<h4>Seleccione Temporada</h4>
        
		<?php
      	foreach ($seasons as $row) { 
		
			echo anchor('prices/selectRatePrices/'.$row['id_season'], $row['name'])."<br>";
	  
			$dS       = $row['dateStart'];
			$dS_array = explode ('-',$dS);
			$year     = $dS_array[0];
			$month    = $dS_array[1];
			$day      = $dS_array[2];
			echo $day.'-'.$month.'-'.$year;
			echo ' al ';
			$dE       = $row['dateEnd'];
			$dE_array = explode ('-',$dE);
			$year     = $dE_array[0];
			$month    = $dE_array[1];
			$day      = $dE_array[2];
			echo $day.'-'.$month.'-'.$year;
			echo "<br><br>";
		}
	 
	} else {
	
		echo 'Deben existir temporadas, tarifas y planes para agregar los precios.';
	} 
	
	echo $this->pagination->create_links();
	
} else {

	echo 'Deben existir tipos de habitaciones para agregar los precios.';
}

?>
