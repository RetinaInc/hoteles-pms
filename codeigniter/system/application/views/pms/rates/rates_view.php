
<?php 
$this->load->view('pms/header'); 
?>

<h3>Tarifas</h3>

<?php
echo anchor(base_url().'rates/addRate/','Agregar Nueva Tarifa')."<br><br>";

if ($rates) {

	foreach ($rates as $row) { 
		
		echo $row['name']."<br>";
		
	  	if ($row['description'] != NULL) {
	    	
			echo 'Descripción: '.$row['description']."<br>";
		}
		
		echo anchor(base_url().'rates/editRate/'.$row['id_rate'], 'Editar')."<br>";
		?>
        <a href="<?php echo base_url().'rates/disableRate/'.$row['id_rate'] ?>" onClick="return confirm('Seguro que desea deshabilitar?')">Deshabilitar</a><br /><br /><br />
        <?php
	}
	  
} else {
	
	echo 'No existen tarifas!'."<br>";
}

if ($ratesDis) {

	echo "<br>".anchor(base_url().'rates/viewDisabledRates/', 'Ver Tarifas Deshabilitadas');
}
?>
