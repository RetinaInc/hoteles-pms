
<?php 
$this->load->view('pms/header'); 
?>

<h3>Tipos de Habitaciones Deshabilitadas</h3>

<?php

if ($roomTypes) {

	echo 'Total tipos de habitaciones deshabilitadas: ', $roomTypesCount."<br><br>";
	?>

	<table width="650" border="1">
	  <tr>
      	<td width="40">
        	<?php
        	echo anchor('rooms/viewDisabledRoomTypes/scale', 'Nivel');
			?>        </td>
        
   	  <td width="135">
        	<?php
        	echo anchor('rooms/viewDisabledRoomTypes/name', 'Nombre');
			?>        </td>
        
 	  <td width="60">
        	<?php
        	echo anchor('rooms/viewDisabledRoomTypes/abrv', 'Abrev');
			?>        </td>
        
	  <td width="125">
        	<?php
        	echo anchor('rooms/viewDisabledRoomTypes/paxStd', 'Pax estándar');
			?>        </td>
        
	  <td width="125">
        	<?php
        	echo anchor('rooms/viewDisabledRoomTypes/paxMax', 'Pax máximo');
			?>        </td>
        
	  <td width="125">
        	<?php
        	echo anchor('rooms/viewDisabledRoomTypes/beds', 'Camas');
			?>        </td>
	  </tr>

	  <?php
	  foreach ($roomTypes as $row) {	?>
          <tr>
          	<td>
                <?php 
                echo $row['scale'];
                ?>
            </td>
            
            <td>
                <?php 
                echo anchor('rooms/infoRoomType/'.$row['id_room_type'],$row['name']);
                ?>
            </td>
            
            <td>
                <?php 
                echo $row['abrv'];
                ?>
            </td>
            
            <td>
                <?php 
                echo $row['paxStd'];
                ?>
            </td>
            
            <td>
                <?php 
                echo $row['paxMax'];
                ?>
            </td>
            
            <td>
                <?php 
                echo $row['beds'];
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
	
	echo "<br><br>";
	echo 'No existen tipos de habitaciones deshabilitadas!';
}

echo "<br><br>";
echo anchor ('rooms/viewRoomTypes/name', 'Volver a Tipos de Habitaciones');

?>

