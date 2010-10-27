
<?php 
$this->load->view('pms/header'); 
?>

<h3>Planes</h3>

<?php
echo anchor('plans/addPlan/','Agregar Nuevo Plan')."<br>";

if ($plansDis) {

	echo anchor('plans/viewDisabledPlans/', 'Ver Planes Deshabilitados');
	echo "<br>";
}

echo "<br>";

if ($plans) {

	foreach ($plans as $row) { 

		echo 'Plan: ',$row['name']."<br>";

		if ($row['description'] != NULL) {
		
    		echo 'Descripcion: ', $row['description']."<br>";
		}

		echo anchor('plans/editPlan/'.$row['id_plan'],'Editar')."<br>";
		echo anchor('plans/disablePlan/'.$row['id_plan'], 'Deshabilitar', array('onClick' => "return confirm('Seguro que desea deshabilitar?')"))."<br><br>";
	}
	
	echo $this->pagination->create_links();
	
} else {
	
	echo 'No existen planes!';
} 

?>