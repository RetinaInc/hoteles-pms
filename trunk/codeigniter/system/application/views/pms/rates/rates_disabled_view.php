
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
		
		?>
        <a href="<?php echo base_url().'rates/enableRate/'.$row['id_rate'] ?>" onClick="return confirm('Seguro que desea habilitar?')">Habilitar</a><br /><br /><br />
        <?php
	}
	  
} else {
	
	echo 'No existen tarifas deshabilitadas!'."<br>";
}

echo "<br>".anchor(base_url().'rates/viewRates/', 'Volver a Tarifas');

?>
