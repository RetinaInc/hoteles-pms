
<?php 
$this->load->view('pms/header'); 
?>

<h3>Habitaciones</h3>

<?php
if ($roomTypes) {

	echo anchor(base_url().'rooms/addRoom/','Agregar Nueva Habitaci�n')."<br><br>";
} 

if ($rooms) {
 
	echo 'Total habitaciones: ', $roomsCount."<br>";
	echo 'Total habitaciones en funcionamiento: ', $roomsCountRunning."<br>";
	echo 'Total habitaciones fuera de servicio: ', $roomsCountOos."<br><br>";
?>

	<table width="448" border="1">
 		<tr>
    		<td width="61">
    		<?php
        	echo form_open(base_url().'rooms/viewRooms');
			echo form_hidden('order', 'number');
			echo 'N�mero ', form_submit('sumit', '^');
       	 	echo form_close();
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
        		<td width="115">
				<?php 
				echo form_open(base_url().'rooms/viewRooms');
				echo form_hidden('order', 'name');
				echo 'Nombre ', form_submit('sumit', '^');
        		echo form_close();
				?>    	
            	</td>
   			<?php
			}
			?>
  
    		<td width="94">
    		<?php 
			echo form_open(base_url().'rooms/viewRooms');
			echo form_hidden('order', 'rtname');
			echo 'Tipo ', form_submit('sumit', '^');
			echo form_close();
			?>  	
			</td>
            
			<td width="150">
			<?php 
            echo form_open(base_url().'rooms/viewRooms');
            echo form_hidden('order', 'status');
            echo 'Estado ', form_submit('sumit', '^');
            echo form_close();
            ?> 	
            </td>
 		</tr>
	
		<?php
		foreach ($rooms as $row) { 
		?>
  		<tr>
    		<td><?php echo anchor(base_url().'rooms/infoRoom/'.$row['id_room'],$row['number']);?></td> 
    		
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
	
    		<td><?php echo $row['rtabrv'];?></td>
    		<td><?php echo lang($row['status']);?><br></td>
  		</tr>
		<?php
		}
		?>
	</table>


<?php
} else {
	
	echo "<br><br>".'No existen habitaciones!';
}

if (!$roomTypes) {

	echo "<br><br>".'Agregue tipos de habitaciones para poder agregar habitaciones';
}
?>