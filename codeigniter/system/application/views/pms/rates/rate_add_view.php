<head>
<script language='javascript' src="<?php echo base_url() . "assets/calendario/"?>popcalendar.js"></script>
<script language='javascript' src="<?php echo base_url() . "assets/calendario/images"?>"></script>
</head>

<?php 

$this->load->view('pms/header'); 


echo 'CREAR NUEVA TARIFA'."<br><br>";

echo validation_errors();

$attributes = array('name' => 'form1', 'id' => 'form1');
echo form_open(base_url().'rates/addRate/', $attributes);?>

	<p>* Nombre:
      <input name="rate_name" type="text" id="rate_name" value="<?php echo set_value('rate_name'); ?>" size="50" maxlength="100" />
    </p>
	
   <p>Descripci&oacute;n: :</p>
	<p>
  	<textarea name="rate_description" rows="3" id="rate_description"><?php echo set_value('rate_description');  ?></textarea>
	</p>
   
<?php
echo form_submit('sumit', 'Enviar');
echo form_close();
?>

<a href="<?php echo base_url().'rates/viewRates'?>">Volver</a>
