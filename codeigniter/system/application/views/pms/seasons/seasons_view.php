
<?php 
$this->load->view('pms/header'); 
?>

<h3>Temporadas</h3>

<?php
$userRole = $this->session->userdata('userrole');

if ($userRole != 'Employee') {

	echo anchor('seasons/addSeason/','Agregar Nueva Temporada')."<br>";
}

if ($seasonsDis) {

	echo anchor('seasons/viewDisabledSeasons/', 'Ver Temporadas Deshabilitadas')."<br>";
}

echo "<br>";

if ($seasons) {
	?>

	<table width="688" border="1">
    
  	  <tr>
    	<td width="200" height="23">
            <?php 
			echo anchor('seasons/viewSeasons/name', 'Temporada');
			?>
        </td>
        
        <td width="130">
			<?php 
			echo anchor('seasons/viewSeasons/dateStart', 'Noche inicio');
			?>
        </td>
        
        <td width="130">
        	<?php 
			echo anchor('seasons/viewSeasons/dateEnd', 'Noche fin');
			?>
        </td>
        
        <td width="200">Sub Temporadas </td>
  	  </tr>
	
	  <?php
      foreach ($seasons as $row) { 
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
			
			<td>
				<?php 		
				foreach ($subSeasons as $row1) {

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
    
	<br />
    
	<?php

	echo $this->pagination->create_links();

} else {

	echo 'No existen temporadas!';	
}

?>

