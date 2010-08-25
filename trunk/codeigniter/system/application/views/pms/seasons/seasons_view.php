
<?php 
$this->load->view('pms/header'); 
?>

<h3>Temporadas</h3>

<?php
echo anchor(base_url().'seasons/addSeason/','Agregar Nueva Temporada')."<br><br>";

if ($seasons) {
?>

	<table width="544" border="1">
  	  <tr>
    	<td width="153" height="23">Temporada</td>
        <td width="110">Fecha inicio</td>
        <td width="110">Fecha fin</td>
        <td width="153">Sub Temporadas</td>
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
		?>        </td>
        
        <td>
		<?php 
		$dE       = $row['dateEnd'];
		$dE_array = explode ('-',$dE);
		$year     = $dE_array[0];
		$month    = $dE_array[1];
		$day      = $dE_array[2];
		echo $day.'-'.$month.'-'.$year;
		?>        </td>
        <td>
        <?php 
		foreach ($seasons as $row1) {
			$fk = 'No';
			if ($row1['fk_season'] == $row['id_season']) {
				echo $row1['name']."<br>";
				$fk = 'Yes';
			}
		}
		if ($fk == 'No') {
			echo "&nbsp;";
		}
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

