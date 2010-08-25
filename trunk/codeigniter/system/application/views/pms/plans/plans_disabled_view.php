
<?php 
$this->load->view('pms/header'); 
?>

<h3>Planes Deshabilitados</h3>

<?php
if ($plansDis) {

	foreach ($plansDis as $row) { 
		
		echo $row['name']."<br>";
		
	  	if ($row['description'] != NULL) {
	    	
			echo 'Descripción: '.$row['description']."<br>";
		}
		
		?>
        <a href="<?php echo base_url().'plans/enablePlan/'.$row['id_plan'] ?>" onClick="return confirm('Seguro que desea habilitar?')">Habilitar</a><br /><br /><br />
        <?php
	}
	  
} else {
	
	echo 'No existen planes deshabilitadas!'."<br>";
}

echo "<br>".anchor(base_url().'plans/viewPlans/', 'Volver a Planes');

?>
