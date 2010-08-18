
<?php 

$this->load->view('pms/header'); 

foreach ($plan as $row)
{
	$planId = $row['id_plan'];
}

echo 'EDITAR PLAN'."<br><br>";

echo validation_errors();

echo form_open(base_url().'plans/editPlan/'.$planId);

foreach ($plan as $row) {
?>

    <p>* Nombre:
    <input name="plan_name" type="text" id="plan_name" value="<?php echo $row['name']; ?>" size="50" maxlength="300" />
    </p>
    
     <p> Descripción: </p>
	 <p><textarea name="plan_description" rows="3" id="plan_description"><?php echo $row['description'];  ?></textarea></p>
	
<?php
}

echo form_submit('sumit', 'Enviar');
echo form_close();
?>

<a href="<?php echo base_url().'plans/viewPlans'?>">Volver</a>
