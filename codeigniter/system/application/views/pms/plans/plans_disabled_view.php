
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
		
		echo anchor('plans/enablePlan/'.$row['id_plan'], 'Habilitar', array('onClick' => "return confirm('Seguro que desea habilitar?')"))."<br><br>";
	}
	
	echo $this->pagination->create_links();
	  
} else {
	
	echo 'No existen planes deshabilitadas!';
}

echo "<br><br>";
echo anchor('plans/viewPlans/', 'Volver a Planes');

?>
