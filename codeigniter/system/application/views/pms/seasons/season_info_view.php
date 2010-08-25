
<?php 

$this->load->view('pms/header'); 

echo 'INFO TEMPORADA'."<br>";

foreach ($season as $row) {

	$seasonId = $row['id_season'];
	
	if ($row['disable'] == 1) {
	
	    echo anchor(base_url().'seasons/editSeason/'.$row['id_season'],'Editar')."<br>";
		?>
        <a href="<?php echo base_url().'seasons/disableSeason/'.$seasonId ?>" onClick="return confirm('Seguro que desea deshabilitar?')">Deshabilitar</a><br /><br />
        <?php
	
	} else if ($row['disable'] == 0){
		
		 ?>
        <a href="<?php echo base_url().'seasons/enableSeason/'.$seasonId ?>" onClick="return confirm('Seguro que desea habilitar?')">Habilitar</a><br /><br />
        <?php 
	}
	
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
	echo 'Inicio: ', $dateStart."<br>";
	echo 'Fin: ', $dateEnd."<br>";
}

if ($fSeason) {

    echo "<br>".'Sub Temporadas: '."<br><br>";
    
	    ?>
		<table width="392" border="1">
  	  	  <tr>
    		<td width="150" height="42">Temporada</td>
        	<td width="110">Fecha inicio</td>
        	<td width="110">Fecha fin</td>
      	  </tr>
	
	  	  <?php
      	  foreach ($fSeason as $row) { 
      	  ?>    
      	  <tr>
			<td height="35"><?php echo anchor(base_url().'seasons/infoSeason/'.$row['id_season'], $row['name']);?></td> 
        
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
?>

<p><a href="<?php echo base_url().'seasons/viewSeasons/'?>">Volver</a></p>
