
<?php 

$this->load->view('pms/header'); 

echo 'PLANES'."<br><br>";

echo anchor(base_url().'plans/addPlan/','Agregar Nuevo Plan')."<br><br>";


foreach ($plans as $row) { 

echo 'Plan: ',$row['name']."<br>";

if ($row['description'] != NULL) {
    echo 'Descripcion: ', $row['description']."<br>";
}

echo anchor(base_url().'plans/editPlan/'.$row['id_plan'],'Editar')."<br><br>";

}
?>
