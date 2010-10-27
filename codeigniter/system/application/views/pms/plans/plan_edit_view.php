
<?php 
$this->load->view('pms/header'); 
?>

<h3>Editar Plan</h3>

<span class="Estilo2">
	(*)Campos obligatorios
</span>

<span class="Estilo1">
	<?php
	echo validation_errors();
	?>
</span>

<?php  

foreach ($plan as $row)
{
	$planId = $row['id_plan'];
}

echo form_open('plans/editPlan/'.$planId);

foreach ($plan as $row) {
?>

    <p>* Nombre:
    <input name="plan_name" type="text" id="plan_name" value="<?php echo $row['name']; ?>" size="50" maxlength="300" />
    </p>
    
     <p> Descripción: </p>
	 <p><textarea name="plan_description" rows="3" id="plan_description"><?php echo $row['description']; ?></textarea></p>
	
<?php
}
$att = array(
	'name'        => 'submit',
    'id'          => 'submit',
    'onClick'     => "return confirm('Seguro que desea guardar?')"
);
echo form_submit($att, 'Guardar');
echo form_close();

echo anchor('plans/viewPlans', 'Volver', array('onClick' => "return confirm('Seguro que desea volver? Se perderán los cambios')"));
?>
