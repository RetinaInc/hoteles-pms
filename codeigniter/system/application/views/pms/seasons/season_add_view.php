<head>
<script language='javascript' src="<?php echo base_url() . "assets/calendario/"?>popcalendar.js"></script>
<script language='javascript' src="<?php echo base_url() . "assets/calendario/images"?>"></script>
</head>

<?php 

$this->load->view('pms/header'); 


echo 'CREAR NUEVA TEMPORADA';?><br /><br /><?php

echo validation_errors();

$attributes = array('name' => 'form1', 'id' => 'form1');
echo form_open(base_url().'seasons/addSeason/', $attributes);?>

	<p>* Nombre:
      <input name="season_name" type="text" id="season_name" value="<?php echo set_value('season_name'); ?>" size="50" maxlength="300" />
    </p>
	
   	<p>* Fecha inicio:			
	<input name="season_dateStart" type="text" id="season_dateStart" value="<?php echo set_value('season_dateStart'); ?>" onClick="popUpCalendar(this, form1.season_dateStart, 'dd-mm-yyyy');" size="10" maxlength="10">
    </p>
    
	<p>* Fecha fin:
    <input name="season_dateEnd" type="text" id="season_dateEnd" onClick="popUpCalendar(this, form1.season_dateEnd, 'dd-mm-yyyy');" value="<?php echo set_value('season_dateEnd'); ?>" size="10" maxlength="10">			
	</p>
                
	 <p>Temporada a la que pertenece:
       <select name="season_season" id="season_season">
	        <option value= "NULL" <?php echo set_select('season_season', NULL); ?> ><?php echo 'Ninguna' ?></option>
            <?php
		    foreach ($seasons as $row) { 
			?>
            <option value="<?php echo $row['id_season']; ?>" <?php echo set_select('season_season', $row['id_season']); ?> ><?php echo $row['name']; ?></option><?php 
			}
			?>
	</select>
    </p>
   
<?php
echo form_submit('sumit', 'Enviar');
echo form_close();
?>

<a href="<?php echo base_url().'seasons/viewSeasons'?>">Volver</a>
