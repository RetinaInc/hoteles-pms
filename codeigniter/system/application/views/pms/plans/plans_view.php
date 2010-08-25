
<?php 
$this->load->view('pms/header'); 
?>

<h3>Planes</h3>

<?php
echo anchor(base_url().'plans/addPlan/','Agregar Nuevo Plan')."<br><br>";

if ($plans) {

	foreach ($plans as $row) { 

		echo 'Plan: ',$row['name']."<br>";

		if ($row['description'] != NULL) {
		
    		echo 'Descripcion: ', $row['description']."<br>";
		}

		echo anchor(base_url().'plans/editPlan/'.$row['id_plan'],'Editar')."<br>";
		?>
        <a href="<?php echo base_url().'plans/disablePlan/'.$row['id_plan'] ?>" onClick="return confirm('Seguro que desea deshabilitar?')">Deshabilitar</a><br /><br /><br />
        <?php
	}
	
} else {
	
	echo 'No existen planes!'."<br><br>";

} 


if ($plansDis) {

	echo "<br>".anchor(base_url().'plans/viewDisabledPlans/', 'Ver Planes Deshabilitados');
}
?>