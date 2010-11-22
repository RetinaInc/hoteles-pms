
<?php 
$this->load->view('pms/header'); 
?>

<h3>Planes</h3>

<?php
$userRole = $this->session->userdata('userrole');

if ($userRole != 'Employee') {

	echo anchor('plans/addPlan/','Agregar Nuevo Plan')."<br>";
}

if ($plansDis) {

	echo anchor('plans/viewDisabledPlans/', 'Ver Planes Deshabilitados');
	echo "<br>";
}

echo "<br>";

if ($plans) {

	foreach ($plans as $row) { 

		echo "<strong>".'Plan: ',$row['name']."</strong> <br>";

		if ($row['description'] != NULL) {
		
    		echo 'Descripcion: ', $row['description']."<br>";
		}

		$userRole = $this->session->userdata('userrole');

		if ($userRole != 'Employee') {

			echo anchor('plans/editPlan/'.$row['id_plan'],'Editar')."<br>";
			echo anchor('plans/disablePlan/'.$row['id_plan'], 'Deshabilitar', array('onClick' => "return confirm('Seguro que desea deshabilitar?')"))."<br>";
		}
		
		echo "<br>";
	}
	
	echo $this->pagination->create_links();
	
} else {
	
	echo 'No existen planes!';
} 

?>