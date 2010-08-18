
<?php 

$this->load->view('pms/header'); 


echo 'CREAR NUEVO PLAN'."<br><br>";

echo validation_errors();

echo form_open(base_url().'plans/addPlan/');?>

	<p>* Nombre:
      <input name="plan_name" type="text" id="plan_name" value="<?php echo set_value('plan_name'); ?>" size="50" maxlength="100" />
    </p>
	
   <p>Descripci&oacute;n: :</p>
	<p>
  	<textarea name="plan_description" rows="3" id="plan_description"><?php echo set_value('plan_description');  ?></textarea>
	</p>
   
<?php
echo form_submit('sumit', 'Enviar');
echo form_close();
?>

<a href="<?php echo base_url().'plans/viewPlans'?>">Volver</a>
