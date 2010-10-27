
<?php 
$this->load->view('pms/header'); 
?>

<h3>Nuevo Plan</h3>

<span class="Estilo2">
	(*)Campos obligatorios
</span>

<span class="Estilo1">
	<?php
	echo validation_errors();
	?>
</span>

<?php
echo form_open('plans/addPlan/');?>

	<p>* Nombre:
      <input name="plan_name" type="text" id="plan_name" value="<?php echo set_value('plan_name'); ?>" size="50" maxlength="100" />
    </p>
	
   <p>Descripci&oacute;n: </p>
	<p>
  	<textarea name="plan_description" rows="3" id="plan_description"><?php echo set_value('plan_description'); ?></textarea>
	</p>
   
<?php
$att = array(
	'name'        => 'submit',
    'id'          => 'submit',
    'onClick'     => "return confirm('Seguro que desea guardar?')"
);
echo form_submit($att, 'Guardar');
echo form_close();

echo anchor('plans/viewPlans', 'Volver', array('onClick' => "return confirm('Seguro que desea volver? Se perderá la información')"));
?>

