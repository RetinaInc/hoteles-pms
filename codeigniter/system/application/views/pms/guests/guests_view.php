
<?php 
$this->load->view('pms/header'); 
?>

<h3>Clientes</h3>

<?php
if ($guests) {
	?>
	<table width="549" border="1">
  	  <tr>
    	<td width="277">Nombre</td>
        <td width="100">Teléfono</td>
        <td width="150">Correo</td>
      </tr>
	
 	  <?php 
  	  foreach ($guests as $row) {?>
      <tr>
        <td><?php echo anchor(base_url().'guests/infoGuestReservations/'.$row['id_guest'],$row['lastName'].', '.$row['name']);?></td>
        <td><?php echo $row['telephone'];?></td>
        <td><?php echo $row['email'];?></td>
      </tr>
	  <?php
      }
      ?>
</table>

<p><a href="<?php echo base_url().'guests/viewDisableGuests/'?>">Ver Clientes Deshabilitados</a></p>
 
<?php
} else {
	
	echo 'No existen clientes!';
}
?>
