<head>
<script language='javascript' src="<?php echo base_url() . "assets/calendario/"?>popcalendar.js"></script>
<script language='javascript' src="<?php echo base_url() . "assets/calendario/images"?>"></script>
</head>

<?php 

$this->load->view('pms/header'); 

foreach ($season as $row)
{
	$seasonId = $row['id_season'];
}

echo 'EDITAR TEMPORADA'."<br><br>";

echo validation_errors();

$attributes = array('name' => 'form1', 'id' => 'form1');

echo form_open(base_url().'seasons/editSeason/'.$seasonId, $attributes);

foreach ($season as $row) {

    $dS        = $row['dateStart'];
	$dS_array  = explode ('-',$dS);
	$year      = $dS_array[0];
	$month     = $dS_array[1];
	$day       = $dS_array[2];
    $dateStart = $day.'-'.$month.'-'.$year;
	
	$dE       = $row['dateEnd'];
	$dE_array = explode ('-',$dE);
	$year     = $dE_array[0];
	$month    = $dE_array[1];
	$day      = $dE_array[2];
    $dateEnd  = $day.'-'.$month.'-'.$year;
?>

	<p>* Nombre:
      <input name="season_name" type="text" id="season_name" value="<?php echo $row['name']; ?>" size="50" maxlength="300" />
    </p>
	
   	<p>* Fecha inicio:			
	<input name="season_dateStart" type="text" id="season_dateStart" value="<?php echo $dateStart; ?>" onClick="popUpCalendar(this, form1.season_dateStart, 'dd-mm-yyyy');" size="10" maxlength="10">
    </p>
    
	<p>* Fecha fin:
    <input name="season_dateEnd" type="text" id="season_dateEnd" onClick="popUpCalendar(this, form1.season_dateEnd, 'dd-mm-yyyy');" value="<?php echo $dateEnd; ?>" size="10" maxlength="10">			
	</p>
    
     <p>Temporada a la que pertenece:
     
      <select name="season_season" id="season_season">
          <option value= "NULL" selected>Ninguna</option>
    	<?php
        foreach ($seasons as $row1) {
		
	        if ($row1['id_season'] == $row['fk_season']) {
				
		        ?><option value="<?php echo $row1['id_season']?>" selected><?php echo $row1['name']; ?></option><?php
				
			} else {
				
				if (($row1['id_season'] != $row['id_season']) && ($row1['fk_season'] != $row['id_season'])) {
				
				?><option value="<?php echo $row1['id_season']?>"><?php echo $row1['name']; ?></option><?php
				
				}
			}
        }
		?>
        </select>
  
    </p>
    
    
   
<?php
}

echo form_submit('sumit', 'Enviar');
echo form_close();
?>

<a href="<?php echo base_url().'seasons/infoSeason/'.$seasonId?>">Volver</a>
