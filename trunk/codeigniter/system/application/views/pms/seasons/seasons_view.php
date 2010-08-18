
<?php 
$this->load->view('pms/header'); 
?>

<h3>Temporadas</h3>

<?php
echo anchor(base_url().'seasons/addSeason/','Agregar Nueva Temporada')."<br><br>";

if ($seasons) {
?>

	<table width="575" border="1">
  	  <tr>
    	<td width="219" height="42">Temporada</td>
        <td width="104">Fecha inicio</td>
        <td width="104">Fecha fin</td>
      </tr>
	
	  <?php
      foreach ($seasons as $row) { 
      ?>    
      <tr>
		<td height="35">
        <?php echo anchor(base_url().'seasons/infoSeason/'.$row['id_season'], $row['name']);?></td> 
        
	    <td>
		<?php 
		$dS       = $row['dateStart'];
		$dS_array = explode ('-',$dS);
		$year     = $dS_array[0];
		$month    = $dS_array[1];
		$day      = $dS_array[2];
		echo $day.'-'.$month.'-'.$year;
		?>
        </td>
        
        <td>
		<?php 
		$dE       = $row['dateEnd'];
		$dE_array = explode ('-',$dE);
		$year     = $dE_array[0];
		$month    = $dE_array[1];
		$day      = $dE_array[2];
		echo $day.'-'.$month.'-'.$year;
		?>
        </td>
      </tr>
      <?php
	  }
	  ?>
	</table>

<?php
} else {

	echo 'No existen temporadas!';	
}

if ($seasonsDis) {

	echo "<br>".anchor(base_url().'seasons/viewDisabledSeasons/', 'Ver Temporadas Deshabilitadas');
}
?>

