
<?php 

$this->load->view('pms/header'); 

echo 'PRECIOS'."<br><br>";

foreach ($season as $row) {

	$seasonId   = $row['id_season'];
	$seasonName = $row['name'];
	$dateStart  = $row['dateStart'];
	$dateEnd    = $row['dateEnd'];
	
	$dS_array = explode ('-',$dateStart);
	$year     = $dS_array[0];
	$month    = $dS_array[1];
	$day      = $dS_array[2];
	$dateS    = $day.'-'.$month.'-'.$year;
	
	$dE_array = explode ('-',$dateEnd);
	$year     = $dE_array[0];
	$month    = $dE_array[1];
	$day      = $dE_array[2];
	$dateE    = $day.'-'.$month.'-'.$year;	
	
	echo $seasonName.' ('.$dateS.' al '.$dateE.') <br>';
}

foreach ($rate as $row) {
	
	$rateId = $row['id_rate'];
	echo 'Tarifa ', $row['name']."<br>";
}

foreach ($plan as $row) {
	
	$planId = $row['id_plan'];
	echo 'Plan ', $row['name']."<br>";
}
?>

<p>
<table width="700" border="1">
  <tr>
    <td width="150">&nbsp;</td>
    <?php 
	foreach ($roomTypes as $row) {
	?>
    <td width="452"><?php echo $row['name']; ?></td>
    <?php
	}
	?>
  </tr>	
  <tr>
    <td>Lunes</td>
	<?php 
	foreach ($roomTypes as $row) {
		foreach ($prices as $row1) { 
  			if ($row1['fk_room_type'] == $row['id_room_type']) {
				?>
  				<td><?php echo $row1['monPrice'];?></td>
				<?php
			}
		}
	}
	?>
    <td width="76">Bs.F.</td>
  </tr>
  <tr>
    <td>Martes</td>
   	<?php 
	foreach ($roomTypes as $row) {
		foreach ($prices as $row1) { 
  			if ($row1['fk_room_type'] == $row['id_room_type']) {
				?>
  				<td><?php echo $row1['tuePrice'];?></td>
				<?php
			}
		}
	}
	?>
    <td>Bs.F.</td>
  </tr>
  <tr>
    <td>Miércoles</td>
    <?php 
	foreach ($roomTypes as $row) {
		foreach ($prices as $row1) { 
  			if ($row1['fk_room_type'] == $row['id_room_type']) {
				?>
  				<td><?php echo $row1['wedPrice'];?></td>
				<?php
			}
		}
	}
	?>
    <td>Bs.F.</td>
  </tr>
  <tr>
    <td>Jueves</td>
    <?php 
	foreach ($roomTypes as $row) {
		foreach ($prices as $row1) { 
  			if ($row1['fk_room_type'] == $row['id_room_type']) {
				?>
  				<td><?php echo $row1['thuPrice'];?></td>
				<?php
			}
		}
	}
	?>
    <td>Bs.F.</td>
  </tr>
  <tr>
    <td>Viernes</td>
    <?php 
	foreach ($roomTypes as $row) {
		foreach ($prices as $row1) { 
  			if ($row1['fk_room_type'] == $row['id_room_type']) {
				?>
  				<td><?php echo $row1['friPrice'];?></td>
				<?php
			}
		}
	}
	?>
    <td>Bs.F.</td>
  </tr>
  <tr>
    <td>Sábado</td>
    <?php 
	foreach ($roomTypes as $row) {
		foreach ($prices as $row1) { 
  			if ($row1['fk_room_type'] == $row['id_room_type']) {
				?>
  				<td><?php echo $row1['satPrice'];?></td>
				<?php
			}
		}
	}
	?>
    <td>Bs.F.</td>
  </tr>
  <tr>
    <td>Domingo</td>
    <?php 
	foreach ($roomTypes as $row) {
		foreach ($prices as $row1) { 
  			if ($row1['fk_room_type'] == $row['id_room_type']) {
				?>
  				<td><?php echo $row1['sunPrice'];?></td>
				<?php
			}
		}
	}
	?>
    <td>Bs.F.</td>
  </tr>
</table>
</p>

<p><a href="<?php echo base_url().'prices/editPrices/'.$seasonId.'/'.$rateId.'/'.$planId ?>">Editar Precios</a></p>
<p><a href="<?php echo base_url().'prices/selectPlanPrices/'.$seasonId.'/'.$rateId?>">Volver</a></p>

