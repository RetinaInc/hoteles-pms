
<?php 
$this->load->view('pms/header'); 
?>

<h3>Clientes Encontrados</h3>

<?php

if ($result) {
	?>
	<table width="688" border="1">
    
  	  <tr>
    	<td width="250">Nombre</td>
        
        <td width="130">Cédula</td>
        
        <td width="130">Teléfono</td>
        
        <td width="150">Correo</td>
      </tr>
	
 	  <?php 
  	  foreach ($result as $row) {?>
      <tr>
        <td>
			<?php 
            echo anchor('guests/infoGuestReservations/'.$row['id_guest'],$row['lastName'].' '.$row['lastName2'].', '.$row['name'].' '.$row['name2']);
            ?>
        </td>
        
        <td>
			<?php 
            echo $row['idType'].'-'.$row['idNum'];
            ?>
        </td>
        
         <td>
			<?php 
            echo $row['telephone'];
            ?>
        </td>
        
        <td>
			<?php 
            echo $row['email'];
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
	
	echo 'No existen cliente con ese nombre!';
	echo "<br><br>";
}

echo anchor('guests/viewGuests/', 'Volver a Clientes');

?>
