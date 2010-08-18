
<?php 
$this->load->view('pms/header'); 
?>

<h3>Temporadas Deshabilitadas</h3>

<?php
if ($seasonsDis) {
?>

	<table width="575" border="1">
  	  <tr>
    	<td width="219" height="42">Temporada</td>
        <td width="104">Fecha inicio</td>
        <td width="104">Fecha fin</td>
      </tr>
	
	  <?php
      foreach ($seasonsDis as $row) { 
      ?>    
      <tr>
		<td height="35"><a href="<?php echo base_url().'seasons/infoSeason/'.$row['id_season'] ?>"><?php echo $row['name']?></a></td> 
        
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

	echo 'No existen temporadas deshabilitadas!';	
}

?>

<p><a href="<?php echo base_url().'seasons/viewSeasons/'?>">Volver a Temporadas</a></p>


