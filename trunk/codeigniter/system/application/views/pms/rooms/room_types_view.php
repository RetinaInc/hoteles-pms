
<?php 
$this->load->view('pms/header'); 
?>

<h3>Tipos de Habitaciones</h3>

<?php
echo anchor('rooms/addRoomType/','Agregar Nuevo Tipo de Habitación')."<br>";

if ($roomTypesDis) {
	
	echo anchor('rooms/viewDisabledRoomTypes/name', 'Ver Tipos de Habitaciones Deshabilitados')."<br><br>";	
}

if ($roomTypes) {

	echo 'Total tipos de habitaciones: ', $roomTypesCount."<br><br>";
	?>

	<table width="650" border="1">
    
	  <tr>
	    <td width="40">
        	<?php
        	echo anchor('rooms/viewRoomTypes/scale', 'Nivel');
			?>        </td>
    	<td width="135">
        	<?php
        	echo anchor('rooms/viewRoomTypes/name', 'Nombre');
			?>     	</td>
        
   	 	<td width="60">
        	<?php
        	echo anchor('rooms/viewRoomTypes/abrv', 'Abrev');
			?>        </td>
        
  		<td width="125">
        	<?php
        	echo anchor('rooms/viewRoomTypes/paxStd', 'Pax estándar');
			?>        </td>
        
  		<td width="125">
        	<?php
        	echo anchor('rooms/viewRoomTypes/paxMax', 'Pax máximo');
			?>        </td>
        
  		<td width="125">
        	<?php
        	echo anchor('rooms/viewRoomTypes/beds', 'Camas');
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
                echo anchor('rooms/infoRoomType/'.$row['id_room_type'].'/checkIn',$row['name']);
            	?>            
           	</td>
            
            <td>
                <?php 
                echo $row['abrv'];
                ?>            </td>
            
            <td>
                <?php 
                echo $row['paxStd'];
                ?>            </td>
            
            <td>
                <?php 
                echo $row['paxMax'];
                ?>            </td>
        
            <td>
                <?php 
                echo $row['beds'];
                ?>            </td>
  	  	  </tr>
	 	  <?php
	  }
	  ?>
	</table>
<br />
    
	<?php

	echo $this->pagination->create_links();

} else {
	
	echo "<br><br>".'No existen tipos de habitaciones!';
}
?>

