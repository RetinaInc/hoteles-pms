
<?php 
$this->load->view('pms/header'); 
?>

<h3>Habitaciones Deshabilitadas</h3>

<?php
if ($roomsDis) {

	echo 'Total habitaciones deshabilitadas: ', $roomsCountDis."<br>";
	?>

	<br />

	<table width="448" border="1">
    
 	  <tr>
    	<td width="80">
    		<?php
			echo anchor('rooms/viewDisabledRooms/number', 'Número');
			?>   			
      	</td>
    
		<?php 
		$name = 'No';
		foreach ($roomsDis as $row) {
	
			if ($row['name'] != NULL) {
		
		    	$name = 'Yes';
			}
		}
		
		if ($name == 'Yes') { 
			?>
        	<td width="150">
				<?php 
				echo anchor('rooms/viewDisabledRooms/name', 'Nombre');
				?>            	
           	</td>
		<?php
		}
		?>

		<td width="100">
    		<?php 
			echo anchor('rooms/viewDisabledRooms/rtabrv', 'Tipo');
			?>			
       	</td>
            
		<td width="140">
			<?php 
        	echo anchor('rooms/viewDisabledRooms/status', 'Estado');
            ?>           
       	</td>
        
 	  </tr>
	
	  <?php
	  foreach ($roomsDis as $row) { 
		  ?>
		  <tr>
			<td>
				<?php 
				echo anchor('rooms/infoRoom/'.$row['id_room'],$row['number']);
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
            
            <td>
                <?php 
                echo lang($row['status']);
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
	
	echo 'No existen habitaciones deshabilitadas!';
}

echo "<br><br>";
echo anchor('rooms/viewRooms/number', 'Volver');

?>


