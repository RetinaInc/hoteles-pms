
<?php 
$this->load->view('pms/header'); 
?>

<h3>Habitaciones</h3>

<?php

$userRole = $this->session->userdata('userrole');

if ($userRole != 'Employee') {

	if ($roomTypes) {
	
		echo anchor('rooms/addRoom/','Agregar Nueva Habitación')."<br>";
	} 
}

if ($roomsDis) {
	
	echo anchor('rooms/viewDisabledRooms/number','Ver Habitaciones Deshabilitadas')."<br>";
}

if ($rooms) {
	
	?>
    
    <br />
    
	<table width="464" border="0">
    
      <tr>
    	<td width="150">
			<?php 
            echo 'Total habitaciones: ', $roomsCount; 
            ?>
        </td>
        
        <!--
    	<td width="150">
			<?php 
            echo 'En funcionamiento: ', $roomsCountRunning; 
            ?>
        </td>
        
    	<td width="150">
			<?php 
            echo 'Fuera de servicio: ', $roomsCountOos; 
            ?>
        </td>
        -->
      </tr>
      
	</table>

	<br />

	<table width="352" border="1">
    
	  <tr>
    	<td width="80">
    		<?php
			echo anchor('rooms/viewRooms/number', 'Número');
			?>   			
      	</td>
    
		<?php 
		$name = 'No';
		foreach ($rooms as $row) {
	
			if ($row['name'] != NULL) {
		
		    	$name = 'Yes';
			}
		}
		
		if ($name == 'Yes') { 
			?>
        	<td width="150">
				<?php 
				echo anchor('rooms/viewRooms/name', 'Nombre');
				?>           	</td>
		<?php
		}
		?>

		<td width="100">
    		<?php 
			echo anchor('rooms/viewRooms/rtabrv', 'Tipo');
			?>       	</td>
           
        <!-- 
		<td width="140">
			<?php 
        	echo anchor('rooms/viewRooms/status', 'Estado');
            ?>           
       	</td>
        -->
  	  </tr>
	
	  <?php
	  foreach ($rooms as $row) { 
	 	 ?>
  	  	<tr>
    		<td>
				<?php 
                echo anchor('rooms/infoRoom/'.$row['id_room'].'/checkIn',$row['number']);
                ?>
      		</td> 
    		
			<?php
            if ($name == 'Yes') { ?>
                <td> 
                    <?php 
                    if ($row['name'] != NULL) {
                        echo $row['name']; 
                    } else {
                        echo '&nbsp;';
                    }
                    ?>
                </td>
                <?php 
          	}
          	?>
	
            <td>
                <?php 
                echo $row['rtabrv'];
                ?>
            </td>
            
            <!--
            <td>
                <?php 
                echo lang($row['status']);
                ?>
           </td>
           -->
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
	echo 'No existen habitaciones!';
}

if (!$roomTypes) {

	echo "<br><br>";
	echo 'Agregue tipos de habitaciones para poder agregar habitaciones';
}

?>
