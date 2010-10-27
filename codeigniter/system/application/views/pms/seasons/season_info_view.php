
<?php 
$this->load->view('pms/header'); 
?>

<h3>Información Temporada</h3>

<?php

if (isset($message)) {
	
	echo "<strong>".$message."</strong>";
	echo "<br><br>";
}
	
foreach ($season as $row) {

	$seasonId = $row['id_season'];
	
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
		            
	echo 'Nombre: ',   $row['name']."<br>";
	echo 'Noche inicio: ', $dateStart."<br>";
	echo 'Noche fin: ', $dateEnd."<br>";
	echo "<br>";
	
	if ($row['disable'] == 1) {
	
	    echo anchor('seasons/editSeason/'.$row['id_season'],'Editar')."<br>";
		echo anchor('seasons/disableSeason/'.$seasonId, 'Deshabilitar', array('onClick' => "return confirm('Seguro que desea deshabilitar?')"))."<br><br>"; 
	
	} else if ($row['disable'] == 0) {
	
		echo anchor('seasons/enableSeason/'.$seasonId, 'Habilitar', array('onClick' => "return confirm('Seguro que desea habilitar?')"))."<br><br>"; 
	}
}


if ($fSeason) {

    echo 'Sub Temporadas: '."<br><br>";
	?>
    
	<table width="392" border="1">
    
	  <tr>
		<td width="150" height="42">Temporada</td>
		
		<td width="110">Noche inicio</td>
		
		<td width="110">Noche fin</td>
	  </tr>

	  <?php
	  foreach ($fSeason as $row) { 
		  ?>  
			
		  <tr>
			<td height="35">
				<?php 
				echo anchor('seasons/infoSeason/'.$row['id_season'], $row['name']);
				?>
			</td> 
		
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
}

echo "<br><br>";
echo anchor('seasons/viewSeasons', 'Volver');

?>

