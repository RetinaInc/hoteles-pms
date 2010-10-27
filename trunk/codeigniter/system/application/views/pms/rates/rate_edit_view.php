
<?php 
$this->load->view('pms/header'); 
?>

<h3>Editar Tarifa</h3> 

<span class="Estilo2">
	(*)Campos obligatorios
</span>

<span class="Estilo1">
	<?php
	echo validation_errors();
	?>
</span>

<?php
foreach ($rate as $row)
{
	$rateId = $row['id_rate'];
}

echo form_open('rates/editRate/'.$rateId);

foreach ($rate as $row) {
?>

	<p>* Nombre:
      <input name="rate_name" type="text" id="rate_name" value="<?php echo $row['name']; ?>" size="50" maxlength="300" />
    </p>
	
    <p> Descripción: </p>
	<p><textarea name="rate_description" rows="3" id="rate_description"><?php echo $row['description']; ?></textarea></p>  
   
<?php
}
$att = array(
	'name'        => 'submit',
    'id'          => 'submit',
    'onClick'     => "return confirm('Seguro que desea guardar?')"
);
echo form_submit($att, 'Guardar');
echo form_close();

echo anchor('rates/viewRates', 'Volver');
?>

