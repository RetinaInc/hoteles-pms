
<?php 

$this->load->view('pms/header'); 

echo 'TEMPORADAS'."<br><br>";

echo anchor(base_url().'seasons/addSeason/','Agregar Nueva Temporada')."<br><br>";
?>


<table width="575" border="0">
  <tr>
    <td width="219" height="42">Temporada</td>
    <td width="104">Fecha inicio</td>
    <td width="104">Fecha fin</td>
    <td width="104">Editar</td>
  </tr>
	
<?php
foreach ($seasons as $row) { 
?>    
  	<tr>
        <td>
		<?php 
		if ($row['fk_season'] == NULL) {
		
		    echo "<br>".'* '.$row['name']; 
		}
		
		foreach ($seasons as $row1) {
		
			if ($row1['fk_season'] == $row['id_season']) {
			
				echo "<br>".' &nbsp;&nbsp;&nbsp; - '.$row1['name']; 
			}
		}
		?>
        </td> 
	    <td>
		<?php 
		if ($row['fk_season'] == NULL) {
		
			$dS       = $row['dateStart'];
			$dS_array = explode ('-',$dS);
			$year     = $dS_array[0];
			$month    = $dS_array[1];
			$day      = $dS_array[2];
		    echo "<br>".$day.'-'.$month.'-'.$year;
	    }
		
		foreach ($seasons as $row1) {
		
			if ($row1['fk_season'] == $row['id_season']) {
			
				$dS       = $row1['dateStart'];
				$dS_array = explode ('-',$dS);
				$year     = $dS_array[0];
				$month    = $dS_array[1];
				$day      = $dS_array[2];
		    	echo "<br>".$day.'-'.$month.'-'.$year;
			}
		} 
		?>
        </td>
        <td>
		<?php 
		if ($row['fk_season'] == NULL) {
		 
			$dE       = $row['dateEnd'];
			$dE_array = explode ('-',$dE);
			$year     = $dE_array[0];
			$month    = $dE_array[1];
			$day      = $dE_array[2];
		    echo "<br>".$day.'-'.$month.'-'.$year;
		}
		
		foreach ($seasons as $row1) {
		
			if ($row1['fk_season'] == $row['id_season']) {
			
				$dE       = $row1['dateEnd'];
			    $dE_array = explode ('-',$dE);
			    $year     = $dE_array[0];
			    $month    = $dE_array[1];
			    $day      = $dE_array[2];
		        echo "<br>".$day.'-'.$month.'-'.$year;
			}
		}
		?>
        </td>
         <td>
		<?php 
		if ($row['fk_season'] == NULL) {
		
		    echo "<br>".anchor(base_url().'seasons/editSeason/'.$row['id_season'],'Editar');  
		}
		
		foreach ($seasons as $row1) {
		
			if ($row1['fk_season'] == $row['id_season']) {
			
				echo "<br>".anchor(base_url().'seasons/editSeason/'.$row1['id_season'],'Editar'); 
			}
		}
		?>
        </td>
    </tr>
  
<?php
}
?>
</table>

