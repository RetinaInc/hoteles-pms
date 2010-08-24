
<?php 

$this->load->view('pms/header'); 

echo 'PRECIOS'."<br><br>";

foreach ($season as $row) {
	
	$seasonId = $row['id_season'];
	echo 'TEMPORADA: ', $row['name']."<br>";
	echo 'Fecha Inicio: ', $row['dateStart']."<br>";
	echo 'Fecha Fin: ', $row['dateEnd']."<br>";
}

foreach ($rate as $row) {
	
	$rateId = $row['id_rate'];
	echo 'TARIFA: ', $row['name']."<br>";
}

foreach ($plan as $row) {
	
	$planId = $row['id_plan'];
	echo 'PLAN: ', $row['name']."<br>";
}
?>

<p>
<table width="367" border="1">
  <tr>
    <td width="150">&nbsp;</td>
    <?php 
	foreach ($roomTypes as $row) {
	?>
    <td width="150"><?php echo $row['name']; ?></td>
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
    <td width="45">Bs.F.</td>
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

<?php
echo anchor(base_url().'prices/editPrices/'.$seasonId.'/'.$rateId.'/'.$planId, 'Editar Precios');
?>

