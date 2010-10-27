
<?php 
$this->load->view('pms/header'); 
?>

<h3>Nueva Tarifa</h3>

<span class="Estilo2">
	(*)Campos obligatorios
</span>

<span class="Estilo1">
	<?php
	echo validation_errors();
	?>
</span>

<?php
echo form_open('rates/addRate');?>

	<p>* Nombre:
      <input name="rate_name" type="text" id="rate_name" value="<?php echo set_value('rate_name'); ?>" size="50" maxlength="100" />
    </p>
	
   <p>Descripci&oacute;n: :</p>
	<p>
  	<textarea name="rate_description" rows="3" id="rate_description"><?php echo set_value('rate_description'); ?></textarea>
	</p>
   
<?php
$att = array(
	'name'        => 'submit',
    'id'          => 'submit',
    'onClick'     => "return confirm('Seguro que desea guardar?')"
);
echo form_submit($att, 'Guardar');
echo form_close();

echo anchor('rates/viewRates', 'Volver');
?>

