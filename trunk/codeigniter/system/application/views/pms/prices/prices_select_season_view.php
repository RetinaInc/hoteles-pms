
<?php 
$this->load->view('pms/header'); 
?>

<h3>Seleccione Temporada</h3>

	<table width="575" border="0">
	  <?php
      foreach ($seasons as $row) { 
      ?>    
      <tr>
		<td height="35">
        <?php echo anchor(base_url().'prices/selectRatePrices/'.$row['id_season'], $row['name']);?></td> 
        
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


