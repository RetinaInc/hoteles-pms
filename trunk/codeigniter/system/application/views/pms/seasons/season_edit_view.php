
<?php 
$this->load->view('pms/header'); 
?>

<h3>Editar Temporada</h3>

<span class="Estilo2">
	(*)Campos obligatorios
</span>

<span class="Estilo1">
	<?php
	echo validation_errors();
	?>
</span>

<?php
if (isset($error)) {
	
	echo "<br><br>";
	echo "<span class='Estilo1'>".$error."</span>";
}

foreach ($season as $row)
{
	$seasonId = $row['id_season'];
}


$attributes = array('name' => 'form1', 'id' => 'form1');
echo form_open('seasons/editSeason/'.$seasonId, $attributes);

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
        <input name="season_dateStart" type="text" id="season_dateStart" value="<?php echo $dateStart; ?>" 
        onClick="popUpCalendar(this, form1.season_dateStart, 'dd-mm-yyyy');" onKeyPress="return rifnumbers(this, event)" size="10" maxlength="10">
        <span class="Estilo2">(dd - mm - yyyy)</span> 
        <br />
        <span class="Estilo2">(Incluye esa noche)</span>
    </p>
    
	<p>* Fecha fin:
        <input name="season_dateEnd" type="text" id="season_dateEnd"  value="<?php echo $dateEnd; ?>" 
        onClick="popUpCalendar(this, form1.season_dateEnd, 'dd-mm-yyyy');" onKeyPress="return rifnumbers(this, event)" size="10" maxlength="10">	
        <span class="Estilo2">(dd - mm - yyyy)</span> 
        <br />
        <span class="Estilo2">(Incluye esa noche)</span>		
	</p>
    
<?php
}

$att = array(
	'name'        => 'submit',
    'id'          => 'submit',
    'onClick'     => "return confirm('Seguro que desea guardar?')"
);
echo form_submit($att, 'Guardar');
echo form_close();

echo anchor('seasons/infoSeason/'.$seasonId, 'Volver', array('onClick' => "return confirm('Seguro que desea volver? Se perderá la información')"));

?>
