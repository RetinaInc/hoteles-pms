
<?php 
$this->load->view('pms/header'); 
?>

<h3>Clientes Encontrados</h3>

<?php

if ($result) {
	?>
	<table width="549" border="1">
  	  <tr>
    	<td width="277">Nombre</td>
        <td width="100">Teléfono</td>
        <td width="150">Correo</td>
      </tr>
	
 	  <?php 
  	  foreach ($result as $row) {?>
      <tr>
        <td><?php echo anchor(base_url().'guests/infoGuestReservations/'.$row['id_guest'],$row['lastName'].' '.$row['lastName2'].', '.$row['name'].' '.$row['name2']);?></td>
        <td><?php echo $row['telephone'];?></td>
        <td><?php echo $row['email'];?></td>
      </tr>
	  <?php
      }
      ?>
</table>
 
<?php
} else {
	
	echo 'No existen cliente con ese nombre!';
}
?>
<br />
<a href="<?php echo base_url().'guests/viewGuests/'?>">Volver a Clientes</a><br />
