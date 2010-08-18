
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
	
	echo 'Nombre: ',   $row['name']."<br>";
	echo 'Fecha Inicio: ', $row['dateStart']."<br>";
	echo 'Fecha Fin: ', $row['dateStart']."<br>";
}

?>

<p><a href="<?php echo base_url().'seasons/viewSeasons/'?>">Volver</a></p>
